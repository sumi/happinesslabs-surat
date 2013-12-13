<?php
class ApiCaller
{
	//some variables for the object
	private $_app_id;
	private $_app_key;
	private $_api_url;
	
	//construct an ApiCaller object, taking an
	//APP ID, APP KEY and API URL parameter
	public function __construct($app_id, $app_key, $api_url)
	{
		$this->_app_id = $app_id;
		$this->_app_key = $app_key;
		$this->_api_url = $api_url;
	}
	
	//send the request to the API server
	//also encrypts the request, then checks
	//if the results are valid
	public function sendRequest($request_params)
	{
		//print_r($request_params);die;
		//encrypt the request parameters
		
		$enc_request = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_app_key, json_encode($request_params), MCRYPT_MODE_ECB));
		
		//create the params array, which will
		//be the POST parameters
		$params = array();
		$params['enc_request'] = $enc_request;
		$params['app_id'] = $this->_app_id;
		
		//echo $this->_api_url;die;
		//print_r($params);die;
		//$params = json_encode($params);
		
		//initialize and setup the curl handler
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_api_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request
		$result = curl_exec($ch);
		
		//json_decode the result
		$result = @json_decode($result);
		//print_r($result);die;
		
		//check if we're able to json_decode the result correctly
		//if( $result == false || isset($result->success) == false ) {
			//throw new Exception('Request was not correct');
		//}
		
		//if there was an error in the request, throw an exception
		//if( $result->success == false ) {
			//throw new Exception($result->errormsg);
		//}
		//print_r($result);die;
		//if everything went great, return the data
		return $result;
	}
}