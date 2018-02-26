<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Config\Backend;

use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\Context;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;

/**
 * Form Config Value
 */
class Form extends ConfigValue
{
    /**
     * Popup String Constant
     */
    const POPUP_STRING_PATH = 'customer/recaptcha/popup';
    
    /**
     * Forms Config Path
     */
    const XML_PATH_FORMS = 'groups/recaptcha/fields/forms/value';

    /**
     * Config Value Factory
     *
     * @var \Magento\Framework\App\Config\ValueFactory
     */    
    protected $_configValueFactory;

    /**
	 * Initialize Model
	 *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ValueFactory $configValueFactory
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ValueFactory $configValueFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_configValueFactory = $configValueFactory;
        
        parent::__construct(
            $context, 
            $registry, 
            $config, 
            $cacheTypeList, 
            $resource, 
            $resourceCollection, 
            $data
        );
    }

    /**
     * Form Settings Save
     *
     * @return \Faonni\ReCaptcha\Model\Config\Backend\Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSave()
    {
		$value = (false === in_array('checkout_index_index', $this->getData(self::XML_PATH_FORMS))) ? 0 : 1;
        try {
            $this->_configValueFactory->create()->load(
                self::POPUP_STRING_PATH,
                'path'
            )->setValue(
                $value
            )->setPath(
                self::POPUP_STRING_PATH
            )->save();
        } 
        catch (\Exception $e) {
            throw new LocalizedException(
                __('We can\'t save the Form value.')
            );
        }
        return parent::afterSave();
    }
}
