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
namespace Faonni\ReCaptcha\Model\Form\Adminhtml;

use Faonni\ReCaptcha\Model\Form\FormConfig as AbstractForm;

/**
 * Faonni ReCaptcha form config 
 */
class FormConfig extends AbstractForm
{
    /**
     * Validate format of forms configuration array
     *
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config)
    {
        foreach ($config as $formName => $formInfo) {
            if (!is_string($formName) || empty($formName)) {
                throw new \InvalidArgumentException('Name for a ReCaptcha form has to be specified.');
            }            
            if (empty($formInfo['handle'])) {
                throw new \InvalidArgumentException('Handle for a ReCaptcha form has to be specified.');
            }
            if (empty($formInfo['label'])) {
                throw new \InvalidArgumentException('Label for a ReCaptcha form has to be specified.');
            }          
        }
        $this->_config = $config;
    }
} 
