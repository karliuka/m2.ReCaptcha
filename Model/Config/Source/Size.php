<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source of option values in a form of value-label pairs
 */
class Size implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return mixed[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'compact', 'label' => __('Compact')],
            ['value' => 'normal' , 'label' => __('Normal')]
        ];
    }
}
