<?php
error_reporting(0);
if($_POST['make_video_name'] == 'make video')
{
	$cmd = 'ffmpeg -r 1/2 -i images/img%03d.jpg output/out.mp4 2>&1';
	exec($cmd,$output,$return);
	echo '<pre>';
	print_r($output);
	echo '</pre>';
	echo $return;
	if($return==0)
	{
		$msg = "video created successfully...";
	}
	else
	{
		$msg = "video already exist";
	}
}?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>
<body>
<table width="200" border="1">
  <tr>
    <td>image1</td>
    <td>image2</td>
  </tr>
  <tr>
    <td><img src="images/img000.jpg" name="img000" width="100" height="100"/></td>
    <td><img src="images/img001.jpg" name="img001" width="100" height="100"/></td>
  </tr>  
</table>
<form method="post" name="make_form">
<input type="submit" name="make_video_name" value="make video" id="make_video_btn"/>
</form>
<div class="msg"><?php echo $msg;?></div>
<div class="show_video">
<video width="320" height="240" controls autoplay>
  <source src="output/out.mp4" type="video/mp4" id="video">
</video>
</div>

</body>
</html>
