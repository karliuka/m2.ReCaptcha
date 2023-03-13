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
     * @var ReCaptchaHelper
     */
    private $helper;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

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
