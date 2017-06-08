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
namespace Faonni\ReCaptcha\Block\Adminhtml;

use Magento\Framework\View\Element\Template\Context;
use Faonni\ReCaptcha\Helper\Adminhtml\Data as ReCaptchaHelper;
use Faonni\ReCaptcha\Block\Form as AbstractForm;

/**
 * ReCaptcha Block Form
 */
class Form extends AbstractForm
{
    /**
     * Initialize block
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Faonni\ReCaptcha\Helper\Data $helper
     * @param array $data
     * 
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
		Context $context, 
		ReCaptchaHelper $helper,
		array $data = []
	) {
        parent::__construct(
			$context, 
			$helper, 
			$data
		);
    }
} 
