<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Model\Config\Source\Form;

use Magento\Framework\Option\ArrayInterface;
use Faonni\ReCaptcha\Model\Form\AbstractFormConfig;

/**
 * Source of option values in a form of value-label pairs
 */
class AbstractForm implements ArrayInterface
{
    /**
     * @var AbstractFormConfig
     */
    private $config;

    /**
     * Options as value-label pairs
     *
     * @var mixed[]
     */
    private $options;

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
     * @return mixed[]
     */
    public function toOptionArray()
    {
        if (null === $this->options) {
            $this->options = [];
            foreach ($this->config->getAvailableForms() as $name) {
                $this->options[] = [
                    'label' => $this->config->getFormLabel($name),
                    'value' => $name
                ];
            }
        }
        return $this->options;
    }
}
