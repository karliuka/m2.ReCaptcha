<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\Exception\Plugin\AuthenticationException as PluginAuthenticationException;
use Magento\Framework\Phrase;
use Faonni\ReCaptcha\Helper\Adminhtml\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Model\Provider;

/**
 * ReCaptcha ValidateLogin observer
 */
class ValidateLoginObserver implements ObserverInterface
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
     * Request instance
     * 
     * @var \Magento\Framework\App\Request\Http
     */    
    protected $_request;
    
    /**
     * Initialize observer
     * 
     * @param Data $helper
     * @param Provider $provider
     * @param Request $request
     */
    public function __construct(
        ReCaptchaHelper $helper,
		Provider $provider,
		Request $request         
    ) {
        $this->_helper = $helper;
		$this->_provider = $provider;
		$this->_request = $request;
    }
        	
    /**
     * Handler for admin login event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		if ($this->_helper->isEnabled() && 
            $this->_helper->isFormAllowed('adminhtml_auth_login')) {
			$recaptcha = $this->_request->getPost('g-recaptcha-response');
			if (!empty($recaptcha) && 
				$this->_provider->validate($recaptcha, $this->_helper->getSecretKey())) {
				return $this;
			}
			throw new PluginAuthenticationException(
				new Phrase('There was an error with the reCAPTCHA code, please try again.')
			);		
		}		
    }    
}  
