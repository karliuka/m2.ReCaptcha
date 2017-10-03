<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;

/**
 * Faonni ReCaptcha Data helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_ENABLED = 'customer/recaptcha/enabled';
    
    /**
     * Site Key config path
     */
    const XML_SITE_KEY = 'customer/recaptcha/site_key';
    
    /**
     * Secret Key config path
     */
    const XML_SECRET_KEY = 'customer/recaptcha/secret_key';
    
    /**
     * Allowed forms config path
     */
    const XML_FORMS = 'customer/recaptcha/forms';
      
    /**
     * Type of ReCAPTCHA config path
     */
    const XML_TYPE = 'customer/recaptcha/type';
      
    /**
     * Size of ReCAPTCHA config path
     */
    const XML_SIZE = 'customer/recaptcha/size';        
      
    /**
     * Color theme of ReCAPTCHA config path
     */
    const XML_THEME = 'customer/recaptcha/theme'; 
    
    /**
     * Allowed forms list
     * 	 
     * @var array
     */
    protected $_form = [];
	
    /**
     * Allowed post actions list
     * 	 
     * @var array
     */
    protected $_posts = [];
    
    /**
     * FormConfig instance
     *		
     * @var \Faonni\ReCaptcha\Model\Form\AbstractFormConfig
     */
    protected $_formConfig;    
    
    /**
     * Initialize helper
     * 
     * @param Context $context
     * @param AbstractFormConfig $formConfig
     */
    public function __construct(
        Context $context,
        AbstractFormConfig $formConfig
    ) {         
        parent::__construct(
			$context
		);		
		$this->_formConfig = $formConfig; 
        $this->_init();
    }
    
    /**
     * Initialize ReCaptcha Helper
     *
     * @return Mage_Core_Helper_Abstract
     */
    protected function _init()
    {
		$forms = explode(',', $this->getForms());
		foreach ($this->_formConfig->getAvailableForms() as $name) {
			if (false === in_array($name, $forms)) continue;
			$this->_form[$name] = true;
			$this->_posts[$this->_formConfig->getFormPost($name)] = true;
		}      
        return $this;
    }
                
    /**
     * Check ReCaptcha functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isModuleOutputEnabled() && $this->_getConfig($this::XML_ENABLED);
    } 
    
    /**
     * Retrieve Site Key
     *
     * @return  string|null
     */
    public function getSiteKey()
    {
        return $this->_getConfig($this::XML_SITE_KEY);
    } 
    
    /**
     * Retrieve Secret Key
     *
     * @return  string|null
     */
    public function getSecretKey()
    {
        return $this->_getConfig($this::XML_SECRET_KEY);
    } 
    
    /**
     * Retrieve Allowed forms
     *
     * @return  string|null
     */
    public function getForms()
    {
        return $this->_getConfig($this::XML_FORMS);
    } 
        
    /**
     * Retrieve Type of ReCAPTCHA
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->_getConfig($this::XML_TYPE);
    } 
    
    /**
     * Retrieve Size of ReCAPTCHA
     *
     * @return  string|null
     */
    public function getSize()
    {
        return $this->_getConfig($this::XML_SIZE);
    } 
    
    /**
     * Retrieve Color theme of ReCAPTCHA
     *
     * @return  string|null
     */
    public function getTheme()
    {
        return $this->_getConfig($this::XML_THEME);
    } 
    
    /**
     * Check the permission from form
     *
     * @param  string $name
     * @return bool
     */
    public function isFormAllowed($name)
    {	
        return $this->isEnabled() && isset($this->_form[$name]);
    }
	
    /**
     * Check the permission from post action
     *
     * @param  string $name
     * @return bool
     */
    public function isPostAllowed($name)
    {
        return $this->isEnabled() && isset($this->_posts[$name]);
    }
    
    /**
     * Get the redirect URL
     *
     * @param  string $post
     * @return string
     */
    public function getRedirectUrl($post)
    {
		foreach ($this->_formConfig->getAvailableForms() as $name) {
			if ($this->_formConfig->getFormPost($name) == $post) {
				return str_replace('_', '/', $name);
			}
		}        
    }	
                                    	
    /**
     * Retrieve store configuration data
     *
     * @param   string $path
     * @return  string|null
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }      
}
