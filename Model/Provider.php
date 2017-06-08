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
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */    
    protected $_remoteAddress;
    
    /**
     * Initialize model
     * 
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress 
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
 
