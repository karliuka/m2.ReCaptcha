<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Block Form
 */
class Form extends Template
{
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
     * Initialize Block
     * 	
     * @param Context $context
     * @param Data $helper
     * @param JsonHelper $jsonHelper     
     * @param array $data
     */
    public function __construct(
		Context $context, 
		ReCaptchaHelper $helper,
		JsonHelper $jsonHelper,
		array $data = []
	) {
        $this->_helper = $helper;
        $this->_jsonHelper = $jsonHelper;
		
        parent::__construct(
			$context, 
			$data
		);
    }
    
    /**
     * Check ReCaptcha Functionality Should Be Enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_helper->isEnabled();
    } 
	
    /**
     * Retrieve Assoc Array Of ReCaptcha Configuration
     *
     * @return array
     * @since 2.0.8     
     */
    public function getConfig()
    {
        return $this->_helper->getConfig();
    }
    
    /**
     * Retrieve ReCaptcha Configuration as Json
     *
     * @return string
     * @since 2.0.8     
     */
    public function getJsonConfig()
    {
        return $this->_jsonHelper->jsonEncode(
			$this->getConfig()
        );
    }
    
    /**
     * Retrieve Site Key
     *
     * @return  string|null
     * @deprecated 2.0.8   
     */
    public function getSiteKey()
    {
        return $this->_helper->getSiteKey();
    }

    /**
     * Retrieve Type of ReCAPTCHA
     *
     * @return  string|null
     * @deprecated 2.0.8     
     */
    public function getType()
    {
        return $this->_helper->getType();
    } 

    /**
     * Retrieve Size of ReCAPTCHA
     *
     * @deprecated 2.0.8     
     * @return  string|null
     */
    public function getSize()
    {
        return $this->_helper->getSize();
    } 

    /**
     * Retrieve Color theme of ReCAPTCHA
     *
     * @return  string|null
     * @deprecated 2.0.8     
     */
    public function getTheme()
    {
        return $this->_helper->getTheme();
    }
    
    /**
     * Check Compact Size
     *
     * @return bool
     * @since 2.0.8     
     */
    public function isCompact()
    {
        return $this->_helper->getSize() == 'compact';
    }     
} 
