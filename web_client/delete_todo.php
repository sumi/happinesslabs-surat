<?php
session_start();
include_once 'apicaller.php';

$apicaller = new ApiCaller('APP001', '28e336ac6c9423d9', 'http://dev.ishaexports.co.in/Code_Api_Centric/');

$new_item = $apicaller->sendRequest(array(
	'controller' => 'login',
	'action' => 'delete',
	'todo_id' => $_GET['todo_id'],
	'username' => $_SESSION['username'],
	'userpass' => $_SESSION['userpass']
));

header('Location: todo.php');
exit();
?>