<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model\Form;

/**
 * Faonni ReCaptcha abstract form config
 */
class AbstractFormConfig
{
    /**
     * Form config list
     *
     * @var array
     */
    protected $config;

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
        $this->config = $config;
    }

    /**
     * Retrieve unique names of all available ReCaptcha forms
     *
     * @return array
     */
    public function getAvailableForms()
    {
        return array_keys($this->config);
    }

    /**
     * Retrieve name of a form post that corresponds to form name
     *
     * @param string $formName
     * @return string|null
     */
    public function getFormPost($formName)
    {
        if (isset($this->config[$formName]['post'])) {
            return $this->config[$formName]['post'];
        }
        return null;
    }

    /**
     * Retrieve name of a handle that corresponds to form name
     *
     * @param string $formName
     * @return string|null
     */
    public function getFormHandle($formName)
    {
        if (isset($this->config[$formName]['handle'])) {
            return $this->config[$formName]['handle'];
        }
        return null;
    }

    /**
     * Retrieve already translated label that corresponds to form name
     *
     * @param string $formName
     * @return \Magento\Framework\Phrase|null
     */
    public function getFormLabel($formName)
    {
        if (isset($this->config[$formName]['label'])) {
            return __($this->config[$formName]['label']);
        }
        return null;
    }

    /**
     * Checks is Referer Url
     *
     * @param string $formName
     * @return bool
     */
    public function isReferer($formName)
    {
        if (isset($this->config[$formName]['referer'])) {
            return (bool)$this->config[$formName]['referer'];
        }
        return false;
    }
}
