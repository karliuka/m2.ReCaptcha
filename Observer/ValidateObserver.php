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
use Magento\Framework\App\Action\Context;
use Magento\Framework\Phrase;
use Faonni\ReCaptcha\Model\Form\FormConfig;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Model\Provider;

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
     * Provider instance
     * 
     * @var \Faonni\ReCaptcha\Model\Provider
     */
    protected $_provider;	     
    
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
     * @param Data $helper
     * @param Context $context
     * @param Provider $provider
     */
    public function __construct(
        ReCaptchaHelper $helper,
		Context $context,
		Provider $provider         
    ) {
        $this->_helper = $helper;
		$this->_redirect = $context->getRedirect();
		$this->_actionFlag = $context->getActionFlag();
		$this->_messageManager = $context->getMessageManager();
		$this->_provider = $provider;
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
			$recaptcha = $request->getPost('g-recaptcha-response');
			if (!empty($recaptcha)){
				return $this->_provider->validate(
					$recaptcha, 
					$this->_helper->getSecretKey()
				);
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
}  
