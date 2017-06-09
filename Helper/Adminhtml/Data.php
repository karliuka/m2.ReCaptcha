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
namespace Faonni\ReCaptcha\Helper\Adminhtml;

use Faonni\ReCaptcha\Helper\Data as AbstractHelper;

/**
 * Faonni ReCaptcha Adminhtml Data helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_ENABLED = 'admin/recaptcha/enabled';
    
    /**
     * Site Key config path
     */
    const XML_SITE_KEY = 'admin/recaptcha/site_key';
    
    /**
     * Secret Key config path
     */
    const XML_SECRET_KEY = 'admin/recaptcha/secret_key';
    
    /**
     * Allowed forms config path
     */
    const XML_FORMS = 'admin/recaptcha/forms';
      
    /**
     * Type of ReCAPTCHA config path
     */
    const XML_TYPE = 'admin/recaptcha/type';
      
    /**
     * Size of ReCAPTCHA config path
     */
    const XML_SIZE = 'admin/recaptcha/size';        
      
    /**
     * Color theme of ReCAPTCHA config path
     */
    const XML_THEME = 'admin/recaptcha/theme';   
}