<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Plugin\Checkout\Block\Cart;

use Magento\Checkout\Block\Cart\Sidebar;
use Faonni\ReCaptcha\Model\Checkout\ConfigProvider;

/**
 * Checkout Sidebar Plugin
 */
class SidebarPlugin
{
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * Initialize Plugin
     *
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * Retrieve Minicart Config
     *
     * @param Sidebar $subject
     * @param string[] $result
     * @return string[]
     */
    public function afterGetConfig(Sidebar $subject, array $result)
    {
        return array_merge_recursive(
            $result,
            $this->configProvider->getConfig()
        );
    }
}
