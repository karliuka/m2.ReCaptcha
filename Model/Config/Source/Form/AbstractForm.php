<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
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
     * @var AbstractFormConfig
     */
    protected $config;

    /**
     * Options as value-label pairs
     *
     * @var array
     */
    protected $options;

    /**
     * Initialize source
     *
     * @param AbstractFormConfig $config
     */
    public function __construct(
        AbstractFormConfig $config
    ) {
        $this->config = $config;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [];
            foreach ($this->config->getAvailableForms() as $name) {
                $this->options[] = [
                    'label' => $this->config->getFormLabel($name),
                    'value' => $name,
                ];
            }
        }
        return $this->options;
    }
}
