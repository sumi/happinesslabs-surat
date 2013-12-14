<?php
error_reporting(0);
if($_POST['make_video_name'] == 'make video')
{
	//exec("mogrify -resize 800x600 images/*.JPG");
	//die;
	$videoFile = rand().'_out';
	
	$cmdvid = 'ffmpeg  -loop_input -frames:v 1 -i images/img001.jpg -t 10s -r 25 output/'.$videoFile.'.mp4 2>&1';
	//$cmdvid = "ffmpeg -f image2 -i images/img%03d.jpg -t 10s -r 25 output/output.mp4 2>&1";
	//$cmdvid = "ffmpeg -r 1/5 -f image2 -i 'images/img%03d.jpg' -r 25 output/".$videoFile.".mp4 2>&1";
	exec($cmdvid,$outvid,$returnvid);
	
	//$cmd1 = "ffmpeg  -i output/".$videoFile.".mpg output/".$videoFile.".mp4  2>&1";
	//exec($cmd1,$out1,$return1);
	
		
	//$cmd = "ffmpeg -i ".$videoFile." -c:v libx264 -ar 22050 -crf 28 output/out.flv 2>&1";
	
	//$cmd = 'ffmpeg -i images/img%03d.jpg output/out.mp4 2>&1';
	//exec($cmd,$output,$return);
	echo $cmdvid;
	echo "<br>";
	echo $cmd1;
	echo '<pre>';
	print_r($outvid);
	echo '</pre>';
	//echo "======";
	echo '<pre>';
	//print_r($out1);
	echo '</pre>';
	
	if($returnvid==0)
		$msg = "video created successfully...";
}?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>
<body>
<h1>ffmpeg</h1>
<table width="200" border="1">
  <tr>
    <td>image1</td>
    <td>image2</td>
  </tr>
  <tr>
    <td><img src="images/img001.png" name="img001" width="100" height="100"/></td>
    <td><img src="images/img002.png" name="img002" width="100" height="100"/></td>
  </tr>  
</table>
<form method="post" name="make_form">
<input type="submit" name="make_video_name" value="make video" id="make_video_btn"/>
</form>
<div class="msg"><?php echo $msg;?></div>
<div class="show_video">
<video width="320" height="240" controls autoplay>
  <source src="output/<?php echo $videoFile.'.mp4' ;?>" type="video/mp4" id="video">
</video>
</div>

</body>
</html>
