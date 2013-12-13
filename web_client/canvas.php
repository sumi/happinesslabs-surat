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
<canvas id="myCanvas" width="400" height="400" style="border:1px solid #000000;"></canvas>
<img src="images/1.jpg" id="my-image"/>
<img width="42" height="44" style="cursor:pointer" onclick="changeImage('1.jpg')" alt="" src="images/1.jpg" />

<script type="text/javascript">
//START INITIALIZE CANVAS INSTANCE
var canvas=new fabric.Canvas('myCanvas',{
  hoverCursor:'pointer',
  selection:false
});
var imgElement=document.getElementById('photo_img');
var imgInstance=new fabric.Image(imgElement,{
  left: 97,
  top: 97,
  opacity: 0.85
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
//START SET CATEGORY VALUE FUNCTION
function setCategoryVal(catVal,divName){
	document.getElementById('category').value=catVal;
	var div_content='';
	var imgType=document.getElementById('imgType').value;
	if(imgType=='background'){
		for(var i=1;i<=6;i++){
			div_content+='<img src="images/background_'+catVal+'_'+i+'.png" width="42" height="44"  alt="" onclick="changeImage(\'background_'+catVal+'_'+i+'.png\')" style="cursor:pointer" />';
		}
	}else{
		var totalClipart=0;
		if(catVal=="love"){totalClipart=84;
		}else if(catVal=="wellness"||catVal=="beauty"){totalClipart=200;
		}else if(catVal=="fun"){totalClipart=166;
		}else{totalClipart=4;}
		for(var i=1;i<=totalClipart;i++){
			div_content+='<img src="images/expertboard/background/clipart_'+catVal+'_'+i+'.png" width="42" height="44"  alt="" onclick="addClipart(\'clipart_'+catVal+'_'+i+'.png\')" style="cursor:pointer" />';
		}
	}
	document.getElementById(divName).innerHTML=div_content;	
}
//START REFRESH DIV FUNCTION
function reloadDivContent(divName,imgType){
	var div_content='';
	var category=document.getElementById('category').value;
	document.getElementById('imgType').value=imgType;
	if(imgType=='background'){
		for(var i=1;i<=6;i++){
			div_content+='<img src="images/background_'+category+'_'+i+'.png" width="42" height="44"  alt="" onclick="changeImage(\'background_'+category+'_'+i+'.png\')" style="cursor:pointer" />';
		}
	}else{
		var totalClipart=0;
		if(category=="love"){totalClipart=84;
		}else if(category=="wellness"||category=="beauty"){totalClipart=200;
		}else if(category=="fun"){totalClipart=166;
		}else{totalClipart=4;}
		for(var i=1;i<=totalClipart;i++){
			div_content+='<img src="images/expertboard/background/clipart_'+category+'_'+i+'.png" width="42" height="44"  alt="" onclick="addClipart(\'clipart_'+category+'_'+i+'.png\')" style="cursor:pointer" />';
		}
	}
	document.getElementById(divName).innerHTML=div_content;
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
//START SAVE CANVAS FUNCTION
function saveCanvas(){	
	canvas.deactivateAllWithDispatch().renderAll();
	var json=JSON.stringify(canvas);
	document.getElementById('jsonVal').value=json;	
	var dataURL=canvas.toDataURL();	
	canvas.clear().renderAll();
	fabric.Image.fromURL(dataURL,function(img){
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
    });
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
		  left:97,
		  top:97,
		  opacity: 0.85,
		  height:192,
		  width:192
		});
		img.perPixelTargetFind=true;
		img.targetFindTolerance=4;
		img.evented=img.selectable=true;
		img.hasControls=img.hasBorders=true;
		canvas.add(img);
    });
}
//START EDIT PHOTO CODE
function openEditPhotoEditor(photoType,photo_id,photo_path,photo_name){
	toggleDiv('photo_editor');	
	document.getElementById('photoType').value=photoType;
	document.getElementById('photo_img').src=photo_path;
	document.getElementById('pedit_photo_id').value=photo_id;
	document.getElementById('file_name').value=photo_name;
	//ADD EDIT IMAGE IN CANVAS	
	$.ajax({
		type: "POST",
		url: "save_canvas_image.php",
		data: {file_name: photo_name}
	}).done(function(json){
		//alert(json);
		canvas.loadFromJSON(json);
	});
	canvas.on('object:selected',function(){
	  document.getElementById('remove_image').style.display='block';
	});
	canvas.renderAll();
	canvas.calcOffset();		
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
}
//START SAVE CANVAS IMAGE FUNCTION
function saveUploadImage(cbid){
	showLoadingImg('rotate_img');	
	canvas.deactivateAllWithDispatch().renderAll();
	var json=JSON.stringify(canvas);
	var dataURL= canvas.toDataURL();
	// use jQuery to POST the dataUrl to you php server
	$.ajax({
		type: "POST",
		url: "save_canvas_image.php",
		data: {object: json,image: dataURL}
	}).done(function(fileName){
		uploadPhotoEditor(cbid,fileName);
	});
}
</script>
</body>
</html>