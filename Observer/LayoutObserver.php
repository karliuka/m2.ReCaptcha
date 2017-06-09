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
namespace Faonni\ReCaptcha\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;
use Faonni\ReCaptcha\Helper\Data as ReCaptchaHelper;

/**
 * ReCaptcha Layout observer
 */
class LayoutObserver implements ObserverInterface
{
    /**
     * FormConfig instance
     *	
     * @var \Faonni\ReCaptcha\Model\Form\AbstractFormConfig
     */
    protected $_config;
    
    /**
     * Helper instance
     *
     * @var \Faonni\ReCaptcha\Helper\Data
     */
    protected $_helper;  
        
    /**
     * Initialize observer
     * 	
     * @param AbstractFormConfig $config
     * @param Data $helper
     */
    public function __construct(
        AbstractFormConfig $config,
        ReCaptchaHelper $helper
    ) {
        $this->_config = $config;
        $this->_helper = $helper;
    }

    /**
     * Handler for layout load event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		$name = $observer->getEvent()->getFullActionName();
		if ($this->_helper->isFormAllowed($name)) {
			$handle = $this->_config->getFormHandle($name);		
			if ($handle) {
				$layout = $observer->getEvent()->getLayout(); 
				$layout->getUpdate()->addHandle($handle);
			}		
		}
		return $this;
    }
}  
