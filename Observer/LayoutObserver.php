<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Layout Observer
 */
class LayoutObserver implements ObserverInterface
{
    /**
     * @var AbstractFormConfig
     */
    protected $config;

    /**
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Initialize Observer
     *
     * @param AbstractFormConfig $config
     * @param ReCaptchaHelper $helper
     */
    public function __construct(
        AbstractFormConfig $config,
        ReCaptchaHelper $helper
    ) {
        $this->config = $config;
        $this->helper = $helper;
    }

    /**
     * Handler For Layout Load Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var string $name */
        $name = $observer->getEvent()->getData('full_action_name');
        if ($this->helper->isFormAllowed($name)) {
            $handle = $this->config->getFormHandle($name);
            if ($handle) {
                /** @var \Magento\Framework\View\LayoutInterface $layout */
                $layout = $observer->getEvent()->getData('layout');
                $layout->getUpdate()->addHandle($handle);
            }
        }
    }
}
