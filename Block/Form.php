<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * Form Block
 *
 * @api
 */
class Form extends Template
{
    /**
     * Helper
     *
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Json Helper
     *
     * @var JsonHelper
     */
    protected $jsonHelper;

    /**
     * Initialize Block
     *
     * @param Context $context
     * @param ReCaptchaHelper $helper
     * @param JsonHelper $jsonHelper
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        ReCaptchaHelper $helper,
        JsonHelper $jsonHelper,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->jsonHelper = $jsonHelper;

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
        return $this->helper->isEnabled();
    }

    /**
     * Retrieve Assoc Array Of ReCaptcha Configuration
     *
     * @return mixed[]
     * @since 2.0.8
     */
    public function getConfig()
    {
        return $this->helper->getConfig();
    }

    /**
     * Retrieve ReCaptcha Configuration as Json
     *
     * @return string
     * @since 2.0.8
     */
    public function getJsonConfig()
    {
        return $this->jsonHelper->jsonEncode(
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
        return $this->helper->getSiteKey();
    }

    /**
     * Retrieve Type of ReCAPTCHA
     *
     * @return  string|null
     * @deprecated 2.0.8
     */
    public function getType()
    {
        return $this->helper->getType();
    }

    /**
     * Retrieve Size of ReCAPTCHA
     *
     * @deprecated 2.0.8
     * @return  string|null
     */
    public function getSize()
    {
        return $this->helper->getSize();
    }

    /**
     * Retrieve Color theme of ReCAPTCHA
     *
     * @return  string|null
     * @deprecated 2.0.8
     */
    public function getTheme()
    {
        return $this->helper->getTheme();
    }

    /**
     * Check Compact Size
     *
     * @return bool
     * @since 2.0.8
     */
    public function isCompact()
    {
        return $this->helper->getSize() == 'compact';
    }
}
