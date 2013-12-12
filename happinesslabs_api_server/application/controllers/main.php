<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

	function main()
	{	
		parent::__construct();
	}
	
	function index()
	{
		$applications = array('APP001' => '28e336ac6c9423d9');
		
		//$_REQUEST['enc_request'] = 'fuLYDfFLzTwALQwln4XU9FsBseZ4WuU3OkiY37rn2rJxp6cjwFYJ/StmUyfhqlfpNvCTxzkLPBIdAjJwYcfK9BDMKIhuZ1L/PfUYal8saP6TG+jl0IXMjQH5Ff/a4P6U+noWFVxK2oo4p4++9E/BpvsZqY/9ybfK7Qm3rxZIYH0FlZo0j5IL5D6ISgCSXX1H7EAG+UsCykMEmcITCU4Q9bUgWSkPU8WJvoIJ17MbWkO8vUpvWy2jZ/DpJ040hR+QwvrGndJFNJA6GmPuVhqQkYDcTM0QsCSAqjGgRIDU4tJKSkBmuKjvd27k+YipPCnM';
		//$_REQUEST['app_id'] = 'APP001';
		if(@$_REQUEST['enc_request'])
		{
			//get the encrypted request
			$enc_request = $_REQUEST['enc_request'];
			//get the provided app id
			$app_id = $_REQUEST['app_id'];
			
			//check first if the app id exists in the list of applications
			if( !isset($applications[$app_id]) ) {
				$result['msg'] = 'Application does not exist!';
				$result['status'] = 0;
				$result['status_code'] = 401;
				echo json_encode($result);die;
			}
			
			//decrypt the request
			$params = json_decode(trim(mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $applications[$app_id], base64_decode($enc_request), MCRYPT_MODE_ECB )));
			
			//check if the request is valid by checking if it's an array and looking for the controller and action
			if( $params == false || isset($params->controller) == false || isset($params->action) == false ) {
				$result['msg'] = 'Request is not valid';
				$result['status'] = 0;
				$result['status_code'] = 400;
				echo json_encode($result);die;
				
			}
			//cast it into an array
			$params = (array) $params;
			
			//get the controller and format it correctly so the first
			 $controller = strtolower($params['controller']);
			
			//get the action and format it correctly so all the
			 $action = strtolower($params['action']);
			
			//check if the controller exists. if not, throw an exception
			if(file_exists(APPPATH."controllers/{$controller}.php") ) {
				include_once "$controller.php";
			} 
			else 
			{
				$result['msg'] = 'Controller is invalid.';
				$result['status'] = 0;
				$result['status_code'] = 403;
				echo json_encode($result);die;
			}
		
			//create a new instance of the controller, and pass
			//it the parameters from the request
			$controller = new $controller($params);
			
			//check if the action exists in the controller. if not, throw an exception.
			if( method_exists($controller, $action) === false ) {
				$result['msg'] = 'Action is invalid.';
				$result['status'] = 0;
				$result['status_code'] = 404;
				echo json_encode($result);die;
			}
			
			//check for user exists in database or not.
			//$user_auth = $controller->check_user_authentication();
			
			
		//	if($user_auth['status'] == 1)
			//{
				//execute the action
				$result = $controller->$action();
		//	}
		//	else
			//	$result = $user_auth;
			
			echo json_encode($result);
			exit();
		}
		else
		{
			$result['msg'] = 'You missed parameter enc_request.';
			$result['status'] = 0;
			$result['status_code'] = 405;
			echo json_encode($result);
		}
	}
}
