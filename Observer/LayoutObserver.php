<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
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
        $name = $observer->getEvent()->getFullActionName();
        if ($this->helper->isFormAllowed($name)) {
            $handle = $this->config->getFormHandle($name);
            if ($handle) {
                $layout = $observer->getEvent()->getLayout();
                $layout->getUpdate()->addHandle($handle);
            }
        }
    }
}
