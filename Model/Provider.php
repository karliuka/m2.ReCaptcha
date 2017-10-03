<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
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
    protected $_url = 'https://www.google.com/recaptcha/api/siteverify';
    
    /**
     * RemoteAddress instance
     * 	
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */    
    protected $_remoteAddress;
    
    /**
     * Initialize model
     * 
     * @param RemoteAddress $remoteAddress 
     */
    public function __construct(
        RemoteAddress $remoteAddress   
    ) {
        $this->_remoteAddress = $remoteAddress;       
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
		$client = $this->getClient($this->_url);
		$client->setParameterPost(array(
			'secret'   => $secret,
			'response' => $recaptcha,
			'remoteip' => $this->_remoteAddress->getRemoteAddress(),
		));
		
		$response = $client->request(\Zend_Http_Client::POST);
		if($response->isSuccessful()){
			$json = json_decode($response->getBody());
			if(!empty($json->success) && true == $json->success){
				return true;
			}		
		}
		return false;
    }
    	
    /**
     * Returns the Zend Http Client
	 *
     * @param string $url	 
     * @return Zend_Http_Client
     */
    public function getClient($url) 
	{
		return new \Zend_Http_Client($url, array(
			'adapter'     => 'Zend_Http_Client_Adapter_Curl',
			'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false),
		));
    }	
} 
 
