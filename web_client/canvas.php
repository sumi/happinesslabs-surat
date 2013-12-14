<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Canvas Image Upload</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/fabric.js"></script>
<style>
body {
	padding-top: 40px;
}
#main {
	margin-top: 80px;
}
</style>
</head>
<body>
<header>
  <div class="topbar">
    <div class="fill">
      <div class="container"><a class="brand" href="canvas.php">Happyness labs - Caanvas</a></div>
    </div>
  </div>
</header>
<div id="main" class="container">
<form method="post">
<canvas id="myCanvas" width="256px" height="256px" style="border:1px solid #000000; float:right;">
<img id="photo_img" src="images/1.jpg" class="canvas-img" />
</canvas>
<br/>
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('1.jpg')" alt="" src="images/1.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('2.jpg')" alt="" src="images/2.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('3.jpg')" alt="" src="images/3.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('4.jpg')" alt="" src="images/4.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('5.jpg')" alt="" src="images/5.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('6.jpg')" alt="" src="images/6.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('7.jpg')" alt="" src="images/7.jpg" />
<img width="50" height="50" style="cursor:pointer" onclick="changeImage('8.jpg')" alt="" src="images/8.jpg" />
<br/>
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_1.png')" alt="" src="images/expertboard/background/clipart_love_1.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_2.png')" alt="" src="images/expertboard/background/clipart_love_2.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_3.png')" alt="" src="images/expertboard/background/clipart_love_3.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_4.png')" alt="" src="images/expertboard/background/clipart_love_4.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_5.png')" alt="" src="images/expertboard/background/clipart_love_5.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_6.png')" alt="" src="images/expertboard/background/clipart_love_6.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_7.png')" alt="" src="images/expertboard/background/clipart_love_7.png">
<img width="42" height="44" style="cursor:pointer" onclick="addClipart('clipart_love_8.png')" alt="" src="images/expertboard/background/clipart_love_8.png">
<br/>
<div class="clearfix">
<label>Add Text in Canvas</label>
<div class="input">
<textarea class="right_Upload_input_box" name="txtcomment" id="txtcomment">Enter your text.</textarea>
</div>
</div>
<br/>
<div class="clearfix">
<label>Add Text in Canvas</label>
<div class="input">
<select onchange="changeTextFont(this.value)" name="font_type" class="right_Upload_select" id="font_type">
        <option value="Arial" selected="selected">Arial</option>
        <option value="Times New Roman">Times NR</option>
        <option value="Verdana">Verdana</option>
        <option value="Courier New">Courier</option>
        </select>
        </div>
</div>
<br/>
<div class="clearfix">
<label>Add Text in Canvas</label>
<div class="input">
<select onchange="changeTextFontSize(this.value)" name="font_size" id="font_size" class="right_Upload_select">
        <option value="14" selected="selected">14px</option>
        <option value="16">16px</option>
        <option value="18">18px</option>
        <option value="24">24px</option>
        <option value="30">30px</option>
        <option value="45">45px</option>
        </select>
        </div>
</div>
<br/>
<div class="clearfix">
<label>Add Text in Canvas</label>
<div class="input">
<select class="right_Upload_select" onchange="changeTextFontColor(this.value)" name="font_color" id="font_color">
			<option value="white">White</option>
            <option value="black">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            </select>
            </div>
</div>
<br/>
<button onclick="return addTextCanvas();" class="btn primary">Add Text</button>
<br/><br/>
<button onclick="return saveCanvas();"  class="btn primary">Save Canvas</button>
<br/><br/>
<button onclick="return editCanvas();" class="btn primary">Edit Canvas</button>
<br/><br/>
<button id="remove_image" title="Delete" onclick="return removeText();" style="display: none;" class="btn primary">Delete Text or ClipArt</button>
   <input type="hidden" value="new_exp_photo" name="photoType" id="photoType" />
    <input type="hidden" value="1" name="pedit_photo_day" id="pedit_photo_day" />
    <input type="hidden" value="0" name="file_name" id="file_name" />
    <input type="hidden" value="90" name="rotate_degree" id="rotate_degree" />
    <input type="hidden" value="profile_slide/" name="load_dir" id="load_dir" />
    <input type="hidden" value="0" name="pedit_photo_id" id="pedit_photo_id" />
    <input type="hidden" name="jsonVal" id="jsonVal" />
	<input type="hidden" name="category" id="category" value="love"/>
	<input type="hidden" name="imgType" id="imgType" value="background"/>
</form>
<script type="text/javascript">
//START INITIALIZE CANVAS INSTANCE
var canvas=new fabric.Canvas('myCanvas',{
  hoverCursor:'pointer',
  selection:false
});
var imgElement=document.getElementById('photo_img');
var imgInstance=new fabric.Image(imgElement,{
  left: 128,
  top: 128,
  opacity: 1
});
canvas.add(imgInstance);
<!-- ADD CLIPART IN CANVAS -->
function addClipart(imgPhoto){
	fabric.Image.fromURL('images/expertboard/background/'+imgPhoto,function(img){
		img.set({
		  left: fabric.util.getRandomInt(50,190),
		  top: fabric.util.getRandomInt(50,190)
		});
		img.perPixelTargetFind=true;
		img.targetFindTolerance=4;
		img.hasControls=img.hasBorders=true;
		img.on('selected',function(){
		  document.getElementById('remove_image').style.display='block';
		});
		canvas.add(img).setActiveObject(img);
    });	 
}
//START FUNCTION CHANGE IMAGE
function changeImage(file_name){
	canvas.clear().renderAll();
	document.getElementById("photo_img").src='images/'+file_name;
	document.getElementById('file_name').value=file_name;
	document.getElementById("load_dir").value='background/';
	<!-- Start Fabric JS Code -->
	canvas.on('object:selected',function(){
	  document.getElementById('remove_image').style.display='none';
	});	
	fabric.Image.fromURL('images/'+file_name,function(img){
		img.set({
		  left:128,
		  top:128,
		  opacity: 1,
		  height:256,
		  width:256
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
//START ADD TEXT IN CANVAS FUNCTION
function addTextCanvas(){
	var txtComment=document.getElementById('txtcomment').value;
	var addText=new fabric.Text(txtComment, {
		left: 97,
		top: 97,
		fontSize: 14,
		fill: 'white',
		fontFamily:'arial'
	});
	addText.on('selected',function(){
	  document.getElementById('remove_image').style.display='block';
	});
	canvas.add(addText).setActiveObject(addText);
	return false;
}
function changeTextFontColor(font_color){
	var txtComment=document.getElementById('txtcomment').value;
	canvas.getActiveObject().set("fill",font_color);
	canvas.renderAll();  	
}
function changeTextFont(font_name){
	var txtComment=document.getElementById('txtcomment').value;
	canvas.getActiveObject().set("fontFamily",font_name);
	canvas.renderAll();
}
function changeTextFontSize(text_size){
	var txtComment=document.getElementById('txtcomment').value;
	canvas.getActiveObject().set("fontSize",text_size);
	canvas.renderAll();
}
function removeText(){
	if(confirm('Are you sure to delete Clipart/Text?')){
	   canvas.remove(canvas.getActiveObject());
	   canvas.renderAll();
	   document.getElementById('remove_image').style.display='none';
	}
	return false;
}
//START SAVE CANVAS FUNCTION
function saveCanvas(){	
	canvas.deactivateAllWithDispatch().renderAll();
	var json=JSON.stringify(canvas);
	document.getElementById('jsonVal').value=json;	
	var dataURL=canvas.toDataURL();	
	canvas.clear().renderAll();
	fabric.Image.fromURL(dataURL,function(img){
		img.set({
		  left:128,
		  top:128,
		  opacity: 1,
		  height:256,
		  width:256
		});
		img.perPixelTargetFind=false;
		img.targetFindTolerance=4;
		img.evented=img.selectable=false;
		img.hasControls=img.hasBorders=false;
		canvas.add(img);
    });
	return false;
}
//START EDIT CANVAS FUNCTION
function editCanvas(){
	var json=document.getElementById('jsonVal').value;
	canvas.loadFromJSON(json);
	canvas.renderAll();
	canvas.calcOffset();
	var dataURL=canvas.toDataURL();
	canvas.clear().renderAll();
	fabric.Image.fromURL(dataURL,function(img){
		img.set({
		  left:128,
		  top:128,
		  opacity: 1,
		  height:256,
		  width:256
		});
		img.perPixelTargetFind=true;
		img.targetFindTolerance=4;
		img.evented=img.selectable=true;
		img.hasControls=img.hasBorders=true;
		canvas.add(img);
    });
	return false;
}
</script>
</div>
</body>
</html>