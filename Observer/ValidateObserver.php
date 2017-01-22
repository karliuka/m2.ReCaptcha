<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_ReCaptcha
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\ReCaptcha\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\Phrase;
use Faonni\ReCaptcha\Model\Form\FormConfig;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Validate observer
 */
class ValidateObserver implements ObserverInterface
{
    /**
     * Helper instance
     *
     * @var \Faonni\ReCaptcha\Helper\Data
     */
    protected $_helper; 
    
    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */    
    protected $_remoteAddress;
    
	/**
	 * @var \Magento\Framework\App\Response\RedirectInterface
	 */
	protected $_redirect;

	/**
	 * @var \Magento\Framework\App\ActionFlag
	 */
	protected $_actionFlag; 
	
    /**
     * @var \Magento\Message\ManagerInterface
     */
    protected $_messageManager;	   
        
    /**
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress 
     * @param \Faonni\ReCaptcha\Helper\Data $helper
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        RemoteAddress $remoteAddress,
        ReCaptchaHelper $helper,
		RedirectInterface $redirect,
		ActionFlag $actionFlag,
		Context $context     
    ) {
        $this->_remoteAddress = $remoteAddress;
        $this->_helper = $helper;
		$this->_redirect = $redirect;
		$this->_actionFlag = $actionFlag;
		$this->_messageManager = $context->getMessageManager();        
    }

    /**
     * Handler for controller action predispatch event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		$request = $observer->getEvent()->getRequest();	
		$action = strtolower($request->getFullActionName());
		
		if ($this->_helper->isPostAllowed($action)) {
			$captcha = $request->getPost('g-recaptcha-response');
			if (!empty($captcha)){
				$client = $this->getClient('https://www.google.com/recaptcha/api/siteverify');
				$client->setParameterPost(array(
					'secret'   => $this->_helper->getSecretKey(),
					'response' => $captcha,
					'remoteip' => $this->_remoteAddress->getRemoteAddress(),
				));
				
				$response = $client->request(\Zend_Http_Client::POST);
				if($response->isSuccessful()){
					$json = json_decode($response->getBody());
					if(!empty($json->success) && true == $json->success){
						return $this;
					}		
				}
			}

			$message = new Phrase('There was an error with the reCAPTCHA code, please try again.');
			$this->_messageManager->addError($message);
			
			/** @var \Magento\Framework\App\Action\Action $controller */
			$controller = $observer->getEvent()->getControllerAction();	
						
			$this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
			$this->_redirect->redirect($controller->getResponse(), $this->_helper->getRedirectUrl($action));
			return $this;			
		}
    }
    
    /**
     * Returns the Zend Http Client
	 *
     * @param string $url	 
     * @return Zend_Http_Client
     */
    public function getClient($url) 
	{
		return new \Zend_Http_Client($url, array(
			'adapter'     => 'Zend_Http_Client_Adapter_Curl',
			'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false),
		));
    }	    
}  
