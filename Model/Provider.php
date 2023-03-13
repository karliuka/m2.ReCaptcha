<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\ReCaptcha\Model;

use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Psr\Log\LoggerInterface;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Http\Client;
use Exception;

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
    private $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize model
     *
     * @param RemoteAddress $remoteAddress
     * @param LoggerInterface $logger
     * @param Client $httpClient
     */
    public function __construct(
        RemoteAddress $remoteAddress,
        LoggerInterface $logger,
        Client $httpClient
    ) {
        $this->remoteAddress = $remoteAddress;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
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
        try {
            $response = $this->getResponse($recaptcha, $secret);
            if ($response->isSuccess()) {
                $json = json_decode($response->getBody());
                if (!empty($json->success) && true == $json->success) {
                    return true;
                }
            }
        } catch (Exception $e) {
            $this->logger->critical($e);
        }
        return false;
    }

    /**
     * Retrieve service response
     *
     * @param string $recaptcha
     * @param string $secret
     * @return Response
     */
    private function getResponse($recaptcha, $secret)
    {
        return $this->getClient()->setUri($this->url)
            ->setMethod(Request::METHOD_POST)
            ->setParameterPost($this->getParameterPost($recaptcha, $secret))
            ->send();
    }

    /**
     * Retrieve post parameters
     *
     * @param string $recaptcha
     * @param string $secret
     * @return mixed[]
     */
    private function getParameterPost($recaptcha, $secret)
    {
        return [
            'secret'   => $secret,
            'response' => $recaptcha,
            'remoteip' => $this->remoteAddress->getRemoteAddress(),
        ];
    }

    /**
     * Retrieve http client
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->httpClient;
    }
}
