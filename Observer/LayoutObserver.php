<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
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
