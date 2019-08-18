<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
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
     * Helper
     *
     * @var ReCaptchaHelper
     */
    protected $_helper;

    /**
     * Initialize Observer
     *
     * @param ReCaptchaHelper $helper
     */
    public function __construct(
        ReCaptchaHelper $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * Handler For Layout Load Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->_helper->isFormAllowed('checkout_index_index')) {
            $layout = $observer->getEvent()->getLayout();
            $layout->getUpdate()->addHandle('recaptcha_authentication_popup');
        }
    }
}
