<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

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
    private const PARAM_RECAPTCHA = 'g-recaptcha-response';

    /**
     * @var ReCaptchaHelper
     */
    private $helper;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @var Provider
     */
    private $provider;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    private $redirect;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    private $actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

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
        /** @var RequestInterface $request */
        $request = $observer->getEvent()->getData('request');
        $action = strtolower($request->getFullActionName());

        if ($request->isPost() && $this->helper->isPostAllowed($action)) {
            $recaptcha = $this->getReCaptcha($request);
            if (!empty($recaptcha) &&
                $this->provider->validate($recaptcha, $this->helper->getSecretKey())) {
                return;
            }
            $controller = $observer->getEvent()->getData('controller_action');
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
    private function getDecodeReCaptcha(RequestInterface $request)
    {
        if ($request->getContent()) {
            /** @var string[] $params */
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
            (string)$this->getRedirectUrl($action)
        );
    }

    /**
     * Retrieve the redirect URL
     *
     * @param  string $action
     * @return string|null
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
