<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Canvas</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/fabric.js"></script>
</head>
<body>
<canvas id="myCanvas" width="400" height="400" style="border:1px solid #000000;">
<img id="photo_img" src="images/1.jpg" class="canvas-img">
</canvas>
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('1.jpg')" alt="" src="images/1.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('2.jpg')" alt="" src="images/2.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('3.jpg')" alt="" src="images/3.jpg" />
   <input type="hidden" value="new_exp_photo" name="photoType" id="photoType" />
    <input type="hidden" value="1" name="pedit_photo_day" id="pedit_photo_day" />
    <input type="hidden" value="0" name="file_name" id="file_name" />
    <input type="hidden" value="90" name="rotate_degree" id="rotate_degree" />
    <input type="hidden" value="profile_slide/" name="load_dir" id="load_dir" />
    <input type="hidden" value="0" name="pedit_photo_id" id="pedit_photo_id" />
    <input type="hidden" name="jsonVal" id="jsonVal" />
	<input type="hidden" name="category" id="category" value="love"/>
	<input type="hidden" name="imgType" id="imgType" value="background"/>

<script type="text/javascript">
//START FUNCTION CHANGE IMAGE
function changeImage(file_name){
	//canvas.clear().renderAll();
	document.getElementById("photo_img").src='images/'+file_name;
	document.getElementById('file_name').value=file_name;
	document.getElementById("load_dir").value='background/';
	<!-- Start Fabric JS Code -->
	canvas.on('object:selected',function(){
	  document.getElementById('remove_image').style.display='none';
	});	
	fabric.Image.fromURL('images/'+file_name,function(img){
		img.set({
		  left:97,
		  top:97,
		  opacity: 0.85,
		  height:192,
		  width:192
		});
		img.perPixelTargetFind=false;
		img.targetFindTolerance=4;
		img.evented=img.selectable=false;
		img.hasControls=img.hasBorders=false;
		canvas.add(img);
		canvas.renderAll();
		canvas.calcOffset();
    });	
}
</script>
</body>
</html>