<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * Config Provider
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
     * Check ReCaptcha functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_helper->isEnabled();
    }

    /**
     * Retrieve Assoc Array Of Checkout Configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return ['recaptcha' => $this->_helper->getConfig()];
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
     * Retrieve Type of ReCaptcha
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->_helper->getType();
    }

    /**
     * Retrieve Size of ReCaptcha
     *
     * @return  string|null
     */
    public function getSize()
    {
        return $this->_helper->getSize();
    }

    /**
     * Retrieve Color theme of ReCaptcha
     *
     * @return  string|null
     */
    public function getTheme()
    {
        return $this->_helper->getTheme();
    }
}
