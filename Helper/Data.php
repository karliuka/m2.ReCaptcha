<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;

/**
 * Helper
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
     * Type of ReCaptcha config path
     */
    const XML_TYPE = 'customer/recaptcha/type';

    /**
     * Size of ReCaptcha config path
     */
    const XML_SIZE = 'customer/recaptcha/size';

    /**
     * Color theme of ReCaptcha config path
     */
    const XML_THEME = 'customer/recaptcha/theme';

    /**
     * Allowed forms list
     *
     * @var bool[]
     */
    protected $form = [];

    /**
     * Allowed post actions list
     *
     * @var bool[]
     */
    protected $posts = [];

    /**
     * Form Config
     *
     * @var AbstractFormConfig
     */
    protected $formConfig;

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
        $this->formConfig = $formConfig;

        parent::__construct(
            $context
        );

        $this->init();
    }

    /**
     * Initialize Helper
     *
     * @return $this
     */
    protected function init()
    {
        $forms = explode(',', $this->getForms());
        foreach ($this->formConfig->getAvailableForms() as $name) {
            if (false === in_array($name, $forms)) {
                continue;
            }
            $this->form[$name] = true;
            $this->posts[$this->formConfig->getFormPost($name)] = true;
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
        return (bool)$this->_getConfig(static::XML_ENABLED);
    }

    /**
     * Retrieve Assoc Array Of ReCaptcha Configuration
     *
     * @return mixed[]
     */
    public function getConfig()
    {
        return [
            'enabled' => $this->isEnabled(),
            'type' => $this->getType(),
            'size' => $this->getSize(),
            'theme' => $this->getTheme(),
            'sitekey' => $this->getSiteKey()
        ];
    }

    /**
     * Retrieve Site Key
     *
     * @return  string
     */
    public function getSiteKey()
    {
        return (string)$this->_getConfig(static::XML_SITE_KEY);
    }

    /**
     * Retrieve Secret Key
     *
     * @return  string
     */
    public function getSecretKey()
    {
        return (string)$this->_getConfig(static::XML_SECRET_KEY);
    }

    /**
     * Retrieve Allowed forms
     *
     * @return  string
     */
    public function getForms()
    {
        return (string)$this->_getConfig(static::XML_FORMS);
    }

    /**
     * Retrieve Type of ReCaptcha
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->_getConfig(static::XML_TYPE);
    }

    /**
     * Retrieve Size of ReCaptcha
     *
     * @return  string|null
     */
    public function getSize()
    {
        return $this->_getConfig(static::XML_SIZE);
    }

    /**
     * Retrieve Color theme of ReCaptcha
     *
     * @return  string|null
     */
    public function getTheme()
    {
        return $this->_getConfig(static::XML_THEME);
    }

    /**
     * Check the permission from form
     *
     * @param  string $name
     * @return bool
     */
    public function isFormAllowed($name)
    {
        return $this->isEnabled() && isset($this->form[$name]);
    }

    /**
     * Check the permission from post action
     *
     * @param  string $name
     * @return bool
     */
    public function isPostAllowed($name)
    {
        return $this->isEnabled() && isset($this->posts[$name]);
    }

    /**
     * Checks is Referer Url
     *
     * @param string $post
     * @return bool
     */
    public function isReferer($post)
    {
        foreach ($this->formConfig->getAvailableForms() as $name) {
            if ($this->formConfig->getFormPost($name) == $post) {
                return $this->formConfig->isReferer($name);
            }
        }
        return false;
    }

    /**
     * Get the redirect URL
     *
     * @param  string $post
     * @return string|null
     */
    public function getRedirectUrl($post)
    {
        foreach ($this->formConfig->getAvailableForms() as $name) {
            if ($this->formConfig->getFormPost($name) == $post) {
                return str_replace('_', '/', $name);
            }
        }
        return null;
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
