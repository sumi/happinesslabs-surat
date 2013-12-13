<?php
session_start();
include_once 'apicaller.php';
$apicaller = new ApiCaller('APP001', '28e336ac6c9423d9', 'https://api.happinesslabs.com/happinesslabs_api_server/');
$my_storys = $apicaller->sendRequest(array(
    'controller' => 'story',
    'action' => 'get_my_story',
    'user_id' => 1
));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="css/flick/jquery-ui-1.8.16.custom.css" type="text/css" />
<link rel="stylesheet" href="css/happinesslab.css" type="text/css" />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<style>
body {
	padding-top: 40px;
}
#main {
	margin-top: 80px;
}
</style>
<title>Create Story</title>
</head>

<body>
<div class="topbar">
  <div class="fill">
    <div class="container"> <a class="brand" href="index.php">Happyness labs</a> </div>
  </div>
</div>
<div id="main" class="container">
  <ul class="link">
    <li><a href="storylist.php">All Story</a></li>
    <li><a href="mystorylist.php">My Story</a></li>
    <li><a href="createstoryform.php">Create New Story</a></li>
  </ul>
  <div id="storylist">
    <?php foreach($my_storys->stories as $story): ?>
    <h3><a href="createstoryform.php?story_id=<?php echo $story->story_id; ?>"><?php echo $story->story_title; ?></a></h3>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>