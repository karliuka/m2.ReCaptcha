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
		if ($this->_helper->isEnabled()) {
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
