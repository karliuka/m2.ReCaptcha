<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model;

use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Faonni ReCaptcha Provider
 */
class Provider
{
    /**
     * ReCaptcha api url
     *
     * @var string
     */
    protected $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * RemoteAddress instance
     *
     * @var RemoteAddress
     */
    protected $remoteAddress;

    /**
     * Initialize model
     *
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        RemoteAddress $remoteAddress
    ) {
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * Checks whether captcha was guessed correctly by user
     *
     * @param string $recaptcha
     * @param string $secret
     * @return bool
     */
    public function validate($recaptcha, $secret)
    {
        $client = $this->getClient($this->url);
        $client->setParameterPost([
            'secret'   => $secret,
            'response' => $recaptcha,
            'remoteip' => $this->remoteAddress->getRemoteAddress(),
        ]);

        $response = $client->request(\Zend_Http_Client::POST);
        if ($response->isSuccessful()) {
            $json = json_decode($response->getBody());
            if (!empty($json->success) && true == $json->success) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the Zend Http Client
     *
     * @param string $url
     * @return \Zend_Http_Client
     */
    public function getClient($url)
    {
        return new \Zend_Http_Client($url, [
            'adapter'     => 'Zend_Http_Client_Adapter_Curl',
            'curloptions' => [CURLOPT_SSL_VERIFYPEER => false],
        ]);
    }
}
