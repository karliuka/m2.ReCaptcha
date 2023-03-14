<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Model\Form;

use InvalidArgumentException;

/**
 * Faonni ReCaptcha abstract form config
 */
class AbstractFormConfig
{
    /**
     * Form config list
     *
     * @var mixed[]
     */
    private $config;

    /**
     * Validate format of forms configuration array
     *
     * @param mixed[] $config
     * @throws InvalidArgumentException
     */
    public function __construct(array $config)
    {
        /** @var string[] $formInfo */
        foreach ($config as $formName => $formInfo) {
            if (!is_string($formName) || empty($formName)) {
                throw new InvalidArgumentException('Name for a ReCaptcha form has to be specified.');
            }
            if (empty($formInfo['handle'])) {
                throw new InvalidArgumentException('Handle for a ReCaptcha form has to be specified.');
            }
            if (empty($formInfo['label'])) {
                throw new InvalidArgumentException('Label for a ReCaptcha form has to be specified.');
            }
        }
        $this->config = $config;
    }

    /**
     * Retrieve unique names of all available ReCaptcha forms
     *
     * @return string[]
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
        return $this->getFormData($formName)['post'] ?? null;
    }

    /**
     * Retrieve name of a handle that corresponds to form name
     *
     * @param string $formName
     * @return string|null
     */
    public function getFormHandle($formName)
    {
        return $this->getFormData($formName)['handle'] ?? null;
    }

    /**
     * Retrieve already translated label that corresponds to form name
     *
     * @param string $formName
     * @return string|null
     */
    public function getFormLabel($formName)
    {
        return $this->getFormData($formName)['label'] ?? null;
    }

    /**
     * Checks is Referer Url
     *
     * @param string $formName
     * @return bool
     */
    public function isReferer($formName)
    {
        return (bool)($this->getFormData($formName)['referer'] ?? false);
    }

    /**
     * Retrieve form data
     *
     * @param string $formName
     * @return string[]
     */
    private function getFormData($formName)
    {
        if (!empty($this->config[$formName]) &&
            is_array($this->config[$formName])
        ) {
            return $this->config[$formName];
        }
        return [];
    }
}
