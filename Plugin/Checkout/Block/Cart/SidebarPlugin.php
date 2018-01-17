<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Plugin\Checkout\Block\Cart;

use Magento\Checkout\Block\Cart\Sidebar;
use Faonni\ReCaptcha\Model\Checkout\ConfigProvider;

/**
 * Checkout Sidebar Plugin
 */
class SidebarPlugin
{
    /**
     * Config Provider
     *
     * @var \Faonni\ReCaptcha\Model\Checkout\ConfigProvider
     */
    protected $_configProvider;

    /**
     * Initialize Plugin
     *
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->_configProvider = $configProvider;
    }

    /**
     * Retrieve Minicart Config
     *
     * @param Sidebar $subject
     * @param array $result
     * @return array
     */
    public function afterGetConfig(Sidebar $subject, array $result)
    {
        return array_merge_recursive(
			$result, 
			$this->_configProvider->getConfig()
		);
    }
}