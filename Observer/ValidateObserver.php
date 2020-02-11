<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Phrase;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Model\Provider;

/**
 * ReCaptcha Validate Observer
 */
class ValidateObserver implements ObserverInterface
{
    /**
     * Recaptcha Request Variable Name
     */
    const PARAM_RECAPTCHA = 'g-recaptcha-response';

    /**
     * Helper
     *
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Json Helper
     *
     * @var JsonHelper
     */
    protected $jsonHelper;

    /**
     * Provider
     *
     * @var Provider
     */
    protected $provider;

    /**
     * Response Redirect
     *
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

    /**
     * ActionFlag
     *
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $actionFlag;

    /**
     * Message Manager
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Initialize Observer
     *
     * @param ReCaptchaHelper $helper
     * @param JsonHelper $jsonHelper
     * @param Context $context
     * @param Provider $provider
     */
    public function __construct(
        ReCaptchaHelper $helper,
        JsonHelper $jsonHelper,
        Context $context,
        Provider $provider
    ) {
        $this->helper = $helper;
        $this->jsonHelper = $jsonHelper;
        $this->redirect = $context->getRedirect();
        $this->actionFlag = $context->getActionFlag();
        $this->messageManager = $context->getMessageManager();
        $this->provider = $provider;
    }

    /**
     * Handler For Controller Action Predispatch Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        $action = strtolower($request->getFullActionName());

        if ($request->isPost() && $this->helper->isPostAllowed($action)) {
            $recaptcha = $this->getReCaptcha($request);
            if (!empty($recaptcha) &&
                $this->provider->validate($recaptcha, $this->helper->getSecretKey())) {
                return;
            }
            $controller = $observer->getEvent()->getControllerAction();
            $this->setResponse($request, $controller, $action);
        }
    }

    /**
     * Set Response
     *
     * @param RequestInterface $request
     * @param Action $controller
     * @param string $action
     * @return void
     */
    protected function setResponse(RequestInterface $request, Action $controller, $action)
    {
        $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
        if ($request->isXmlHttpRequest()) {
            $this->representJson($controller);
        } else {
            $this->redirect($controller, $action);
        }
    }

    /**
     * Retrieve ReCAPTCHA Value
     *
     * @param RequestInterface $request
     * @return string|null
     */
    protected function getReCaptcha(RequestInterface $request)
    {
        return $request->isXmlHttpRequest()
            ? $this->getDecodeReCaptcha($request)
            : $request->getPost(self::PARAM_RECAPTCHA);
    }

    /**
     * Retrieve Decode ReCAPTCHA Value
     *
     * @param RequestInterface $request
     * @return string|null
     */
    protected function getDecodeReCaptcha(RequestInterface $request)
    {
        if ($request->getContent()) {
            $params = $this->jsonHelper->jsonDecode($request->getContent());
            if (isset($params[self::PARAM_RECAPTCHA])) {
                return $params[self::PARAM_RECAPTCHA];
            }
        }
        return null;
    }

    /**
     * Adds New Error Message
     *
     * @return void
     */
    protected function addError()
    {
        $this->messageManager->addErrorMessage(
            new Phrase('There was an error with the reCAPTCHA code, please try again.')
        );
    }

    /**
     * Redirect To Action
     *
     * @param Action $controller
     * @param string $action
     * @return void
     */
    protected function redirect(Action $controller, $action)
    {
        $this->addError();
        $this->redirect->redirect(
            $controller->getResponse(),
            $this->getRedirectUrl($action)
        );
    }

    /**
     * Retrieve the redirect URL
     *
     * @param  string $action
     * @return string
     */
    protected function getRedirectUrl($action)
    {
        return $this->helper->isReferer($action)
            ? $this->redirect->getRefererUrl()
            : $this->helper->getRedirectUrl($action);
    }

    /**
     * Represents an HTTP Response Body In JSON format
     *
     * @param Action $controller
     * @return void
     */
    protected function representJson(Action $controller)
    {
        $json = $this->jsonHelper->jsonEncode([
            'error' => 1, // compatibility with checkout as guest js
            'errors' => true, // compatibility with checkout login js
            'message' => __('Incorrect reCAPTCHA')
        ]);
        $controller->getResponse()->representJson($json);
    }
}
