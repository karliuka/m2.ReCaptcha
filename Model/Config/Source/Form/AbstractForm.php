<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Config\Source\Form;

use Magento\Framework\Option\ArrayInterface;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;

/**
 * Source of option values in a form of value-label pairs
 */
class AbstractForm implements ArrayInterface
{
    /**
     * FormConfig instance
     *		
     * @var \Faonni\ReCaptcha\Model\Form\FormConfig
     */
    protected $_config;
    
    /**
     * Options as value-label pairs
     * 
     * @var array
     */
    protected $_options;
    
    /**
     * Initialize source
     * 	
     * @param AbstractFormConfig $config
     */
    public function __construct(
        AbstractFormConfig $config
    ) {
        $this->_config = $config;
    }
    
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = [];
            foreach ($this->_config->getAvailableForms() as $name) {
                $this->_options[] = [
                    'label' => $this->_config->getFormLabel($name),
                    'value' => $name,
                ];
            }
        }
        return $this->_options;
    }
}  
