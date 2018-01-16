<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Config Provider
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * Helper
     *
     * @var \Faonni\ReCaptcha\Helper\Data
     */
    protected $_helper;   
    
    /**
	 * Initialize Config
	 *	
     * @param ReCaptchaHelper $helper    
     */
    public function __construct(
        ReCaptchaHelper $helper
    ) {
        $this->_helper = $helper;      
    } 

    /**
     * Retrieve Assoc Array Of Checkout Configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return ['recaptcha' => []];
    } 
}