<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * Checkout Config Provider
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * Helper
     *
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Initialize Config
     *
     * @param ReCaptchaHelper $helper
     */
    public function __construct(
        ReCaptchaHelper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Check ReCaptcha functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper->isEnabled();
    }

    /**
     * Retrieve Assoc Array Of Checkout Configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return ['recaptcha' => $this->helper->getConfig()];
    }

    /**
     * Retrieve Site Key
     *
     * @return  string|null
     */
    public function getSiteKey()
    {
        return $this->helper->getSiteKey();
    }

    /**
     * Retrieve Type of ReCaptcha
     *
     * @return  string|null
     */
    public function getType()
    {
        return $this->helper->getType();
    }

    /**
     * Retrieve Size of ReCaptcha
     *
     * @return  string|null
     */
    public function getSize()
    {
        return $this->helper->getSize();
    }

    /**
     * Retrieve Color theme of ReCaptcha
     *
     * @return  string|null
     */
    public function getTheme()
    {
        return $this->helper->getTheme();
    }
}
