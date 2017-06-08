<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_ReCaptcha
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\ReCaptcha\Observer\Adminhtml;

use Faonni\ReCaptcha\Model\Form\Adminhtml\FormConfig;
use Faonni\ReCaptcha\Helper\Adminhtml\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Observer\LayoutObserver as AbstractLayoutObserver;

/**
 * ReCaptcha Layout observer
 */
class LayoutObserver extends AbstractLayoutObserver
{
    /**
     * @param FormConfig $config
     * @param Data $helper
     */
    public function __construct(
        FormConfig $config,
        ReCaptchaHelper $helper
    ) {
        $this->_config = $config;
        $this->_helper = $helper;
    }
}  
