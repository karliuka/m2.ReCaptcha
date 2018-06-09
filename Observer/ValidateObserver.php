<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
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
     * @var \Faonni\ReCaptcha\Helper\Data
     */
    protected $_helper; 
    
    /**
     * Json Helper
     *
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;    
    
    /**
     * Provider
     * 
     * @var \Faonni\ReCaptcha\Model\Provider
     */
    protected $_provider;	     
    
	/**
     * Response Redirect
     * 	
	 * @var \Magento\Framework\App\Response\RedirectInterface
	 */
	protected $_redirect;

	/**
     * ActionFlag
     * 		
	 * @var \Magento\Framework\App\ActionFlag
	 */
	protected $_actionFlag; 
	
    /**
     * Message Manager
     * 	
     * @var \Magento\Message\ManagerInterface
     */
    protected $_messageManager;	   
        
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
        $this->_helper = $helper;
        $this->_jsonHelper = $jsonHelper;         
		$this->_redirect = $context->getRedirect();
		$this->_actionFlag = $context->getActionFlag();
		$this->_messageManager = $context->getMessageManager();
		$this->_provider = $provider;
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

		if ($request->isPost() && $this->_helper->isPostAllowed($action)) {
			$recaptcha = $this->_getReCaptcha($request);
			if (!empty($recaptcha) && 
				$this->_provider->validate($recaptcha, $this->_helper->getSecretKey())) {
				return;
			}
			$controller = $observer->getEvent()->getControllerAction();
			$this->_setResponse($request, $controller, $action);
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
    protected function _setResponse(RequestInterface $request, Action $controller, $action)
    {
        $this->_actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
		if ($request->isXmlHttpRequest()) {
			$this->_representJson($controller);
		} else {
			$this->_redirect($controller, $action);
		}
    }
  
    /**
     * Retrieve ReCAPTCHA Value
     *
     * @param RequestInterface $request     
     * @return string|null
     */
    protected function _getReCaptcha(RequestInterface $request)
    {
		return $request->isXmlHttpRequest()
			? $this->_getDecodeReCaptcha($request)
			: $request->getPost(self::PARAM_RECAPTCHA);
    } 
    
    /**
     * Retrieve Decode ReCAPTCHA Value
     *
     * @param RequestInterface $request     
     * @return string|null
     */
    protected function _getDecodeReCaptcha(RequestInterface $request)
    {
		if ($request->getContent()) {
			$params = $this->_jsonHelper->jsonDecode($request->getContent());
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
    protected function _addError() {
		$this->_messageManager->addErrorMessage(
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
    protected function _redirect(Action $controller, $action)
    {
		$this->_addError();
		$this->_redirect->redirect(
			$controller->getResponse(), 
			$this->_getRedirectUrl($action)
		);
    }
    
    /**
     * Retrieve the redirect URL
     *
     * @param  string $action
     * @return string
     */
    protected function _getRedirectUrl($action)
    {
		return $this->_helper->isReferer($action)
			? $this->_redirect->getRefererUrl()
			: $this->_helper->getRedirectUrl($action);      
    }
    
    /**
     * Represents an HTTP Response Body In JSON format
     *
     * @param Action $controller
     * @return void
     */
    protected function _representJson(Action $controller)
    {
		$json = $this->_jsonHelper->jsonEncode([
			'error' => 1, // compatibility with checkout as guest js
			'errors' => true, // compatibility with checkout login js
			'message' => __('Incorrect reCAPTCHA')
		]);
		$controller->getResponse()->representJson($json);
    }   
}  
