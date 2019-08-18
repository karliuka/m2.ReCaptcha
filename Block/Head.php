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
     * Helper
     *
     * @var ReCaptchaHelper
     */
    protected $_helper;

    /**
     * Locale Resolver
     *
     * @var ResolverInterface
     */
    protected $_resolver;

    /**
     * Initialize block
     *
     * @param Context $context
     * @param ReCaptchaHelper $helper
     * @param ResolverInterface $resolver
     * @param array $data
     */
    public function __construct(
        Context $context,
        ReCaptchaHelper $helper,
        ResolverInterface $resolver,
        array $data = []
    ) {
        $this->_helper = $helper;
        $this->_resolver = $resolver;

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
     * Retrieve locale code
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->_resolver->getLocale();
    }
}
