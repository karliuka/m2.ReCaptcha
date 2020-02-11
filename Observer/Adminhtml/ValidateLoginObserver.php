<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\Exception\Plugin\AuthenticationException as PluginAuthenticationException;
use Magento\Framework\Phrase;
use Faonni\ReCaptcha\Helper\Adminhtml\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Model\Provider;

/**
 * ReCaptcha ValidateLogin observer
 */
class ValidateLoginObserver implements ObserverInterface
{
    /**
     * Helper instance
     *
     * @var ReCaptchaHelper
     */
    protected $helper;

    /**
     * Provider instance
     *
     * @var Provider
     */
    protected $provider;

    /**
     * Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * Initialize observer
     *
     * @param ReCaptchaHelper $helper
     * @param Provider $provider
     * @param Request $request
     */
    public function __construct(
        ReCaptchaHelper $helper,
        Provider $provider,
        Request $request
    ) {
        $this->helper = $helper;
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * Handler for admin login event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->isEnabled() &&
            $this->helper->isFormAllowed('adminhtml_auth_login')) {
            $recaptcha = $this->request->getPost('g-recaptcha-response');
            if (!empty($recaptcha) &&
                $this->provider->validate($recaptcha, $this->helper->getSecretKey())) {
                return;
            }
            throw new PluginAuthenticationException(
                new Phrase('There was an error with the reCAPTCHA code, please try again.')
            );
        }
    }
}
