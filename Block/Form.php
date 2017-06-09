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
namespace Faonni\ReCaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Block Form
 */
class Form extends Template
{
    /**
     * Helper instance
     *
     * @var \Faonni\ReCaptcha\Helper\Data
     */
    protected $_helper;  
    
    /**
     * Initialize block
     * 	
     * @param Context $context
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
		Context $context, 
		ReCaptchaHelper $helper,
		array $data = []
	) {
        $this->_helper = $helper;
		
        parent::__construct(
			$context, 
			$data
		);
    }
    
    /**
     * Check ReCaptcha functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_helper->isEnabled();
    } 
    
    /**
     * Retrieve Site Key
     *
     * @return  string|null
     */
    public function getSiteKey()
    {
        return $this->_helper->getSiteKey();
    }

    /**
     * Retrieve Type of ReCAPTCHA
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->_helper->getType();
    } 

    /**
     * Retrieve Size of ReCAPTCHA
     *
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
     */
    public function getTheme()
    {
        return $this->_helper->getTheme();
    }               
} 
