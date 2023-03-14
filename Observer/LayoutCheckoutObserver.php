<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Layout Checkout Observer
 */
class LayoutCheckoutObserver implements ObserverInterface
{
    /**
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Initialize Observer
     *
     * @param ReCaptchaHelper $helper
     */
    public function __construct(
        ReCaptchaHelper $helper
    ) {
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
        if ($this->helper->isFormAllowed('checkout_index_index')) {
            /** @var \Magento\Framework\View\LayoutInterface $layout */
            $layout = $observer->getEvent()->getData('layout');
            $layout->getUpdate()->addHandle('recaptcha_authentication_popup');
        }
    }
}
