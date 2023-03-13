<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Locale\ResolverInterface;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * Head Block
 *
 * @api
 */
class Head extends Template
{
    /**
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * @var ResolverInterface
     */
    protected $localeResolver;

    /**
     * Initialize block
     *
     * @param Context $context
     * @param ReCaptchaHelper $helper
     * @param ResolverInterface $localeResolver
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        ReCaptchaHelper $helper,
        ResolverInterface $localeResolver,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->localeResolver = $localeResolver;

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
        return $this->helper->isEnabled();
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
     * Retrieve locale code
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->localeResolver->getLocale();
    }
}
