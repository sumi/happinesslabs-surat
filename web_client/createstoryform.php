<?php
session_start();
include_once 'apicaller.php';
$apicaller = new ApiCaller('APP001', '28e336ac6c9423d9', 'https://api.happinesslabs.com/happinesslabs_api_server/');

$get_all_mission = $apicaller->sendRequest(array(
    'controller' => 'story',
    'action' => 'get_all_mission'
));

if ($_POST){
	//print_r($_FILES); die;
	//print_r($_POST); die;
$todo_items = $apicaller->sendRequest(array(
	'controller' => 'story',
'action' => 'save_story_data',
'story_title' => $_POST['story_title'],
'story_description' => $_POST['story_description'],
'story_price' => $_POST['story_price'],
'story_access' => $_POST['story_access'],
'story_template_id' =>  $_POST['story_template_id'],
'story_template_no' =>  $_POST['story_template_no'],
'story_cat_id' =>  $_POST['story_cat_id'],
'story_mission_id' => $_POST['story_mission_id'],
'user_id' =>  $_POST['user_id']
));

for($j=1; $j<=$_POST['story_template_no']; $j++)
{
	$path = $_FILES['image_upload_'.$j.'']['tmp_name'];
    $imgbinary = fread(fopen($path, "r"), filesize($path));
    $img_str = base64_encode($imgbinary);
	//print_r($img_str);
	$todo_items_desc = $apicaller->sendRequest(array(
         'controller' => 'story',
		'action' => 'save_tempdesc_data',
		'story_desc_name' => 'Daytitle',
		'story_desc_imgtitle' => 'Imagetitle',
		'story_desc_imgsrc' =>$img_str,
		'story_id' => $todo_items->data,
		'user_id' => 1));
};
}

if ($_GET){
$story_datas = $apicaller->sendRequest(array(
    'controller' => 'story',
    'action' => 'get_story_data',
    'story_id' => $_GET['story_id']
));
$story = $story_datas->stories;
//print_r($story);
}

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
<script type="text/javascript">

function fileupload(j)
{
	$('#'+j+'-file').live("change", function()
	{
		var oFReader = new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		console.log(this.files[0]);
		oFReader.onload = function (oFREvent) 
		{
			$('#'+j+'-preview').html('<img src="'+oFREvent.target.result+'">');
		};
	}); 
}

function add_story_box() 
{
	var option_val = $('.story_template_no option:selected').val();
	$('#newbox').html('');
	//if (option_val > 3) {alert("You are using MSIE")}; 
	for(var i=1 ; i<=option_val; i++) 
	{
		$('<li class="day_'+i+' day"><h1>Day '+i+'</h1><div class="daybox"><div class="boxtitle">Happinesslabs</div><div class="boxsub"><div class="smile"><img src="images/Career_icon.png" title="Smile" /></div><div class="center">Day '+i+'</div><div class="boxreward">+10</div></div><div class="clear">&nbsp;</div><div class="boximage"><div class="imageupload '+i+'-preview"><div id="'+i+'-preview"><img src="images/Day_'+i+'.png" title="Upload Day '+i+' Image"/></div><input class="'+i+'-imgupload imgupload" name="image_upload_'+i+'" type="file" id="'+i+'-file" onclick="fileupload('+i+')" value=""/></div></div><div class="todo">To Do</div><div class="comments">Comments</div><div class="questions">Questions</div><div class="notes">Notes</div></div></li>').appendTo("#newbox");
		
	} 
}

function add_cat_id() 
{
	var mission_id = $('.story_mission_id option:selected').attr('title');
	document.getElementById('story_cat_id').value = mission_id ; 
	
}
</script>
<style>
body {
	padding-top: 40px;
}
#main {
	margin-top: 80px;
}
</style>
<title>Create Story Form</title>
</head>

<body>
<header>
  <div class="topbar">
    <div class="fill">
      <div class="container"><a class="brand" href="index.php">Happyness labs</a></div>
    </div>
  </div>
</header>
<section id="content">
  <div id="main" class="container">
    <ul class="link">
      <li><a href="storylist.php">All Story</a></li>
      <li><a href="mystorylist.php">My Story</a></li>
      <li><a href="createstoryform.php">Create New Story</a></li>
    </ul>
    <form action="" id="create-story" name="create-story" enctype="multipart/form-data" method="post">
      <h1>
        <?php if (!$_GET){ echo 'Please Create New Story'; } else { echo 'View Your Story';} ?>
      </h1>
      <div class="clearfix">
        <label>1) Select Story Template :</label>
        <div class="input">
          <select size="1" id="story_template_id" name="story_template_id" class="story_template_id" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>>
            <option <?php if ($_GET && $story[0]->story_template_id == 1){ echo 'selected="selected"';} ?> value="1">Day By Day</option>
            <option <?php if ($_GET && $story[0]->story_template_id == 2){ echo 'selected="selected"';} ?> value="2">Item By Item</option>
            <option <?php if ($_GET && $story[0]->story_template_id == 3){ echo 'selected="selected"';} ?> value="3">Step By Step</option>
            <option <?php if ($_GET && $story[0]->story_template_id == 4){ echo 'selected="selected"';} ?> value="4">Narration By Date</option>
          </select>
        </div>
      </div>
      <div class="clearfix">
        <label>2) Select Happy Mission :</label>
        <div class="input">
          <select size="1" id="story_mission_id" name="story_mission_id" class="story_mission_id" onchange="add_cat_id()" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>>
            <option value="0">Select Happy Mission</option>
            <?php foreach($get_all_mission->mission as $mission): ?>
            <option title="<?php echo $mission->story_cat_id; ?>" <?php if ($_GET && $story[0]->story_mission_id == $mission->story_mission_id){ echo 'selected="selected"';} ?> value="<?php echo $mission->story_mission_id; ?>"><?php echo $mission->story_mission_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="clearfix">
        <label>3) Story Title :</label>
        <div class="input">
          <input name="story_title" id="story_title" class="story_title" value="<?php if ($_GET){echo $story[0]->story_title;}else { echo 'Enter story title';} ?>" type="text" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>/>
        </div>
      </div>
      <div class="clearfix">
        <label>4) Story Description :</label>
        <div class="input">
          <textarea name="story_description" id="story_description" class="story_description" <?php if ($_GET){ echo 'disabled="disabled"'; } ?> ><?php if ($_GET){ echo $story[0]->story_description; } else { echo 'Enter story description';}?>
</textarea>
        </div>
      </div>
      <div class="clearfix">
        <label>5) Price :</label>
        <div class="input">
          <input name="story_price" id="story_price" class="story_price" value="<?php if ($_GET){ echo $story[0]->story_price;} else { echo '0';}?>" type="text" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>/>
        </div>
      </div>
      <div class="clearfix">
        <label>6) Story Access :</label>
        <div class="input">
          <input name="story_access" id="story_access" checked="checked" value="<?php if ($_GET){ echo $story[0]->story_access;} else { echo '0';}?>" type="radio" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>/>
          Public &nbsp;
          <input name="story_access" id="story_access" value="<?php if ($_GET){ echo $story[0]->story_access;} else { echo '1';}?>" type="radio" <?php if ($_GET){ echo 'disabled="disabled"'; } ?>/>
          Private</div>
      </div>
      <div class="clearfix">
        <label>7) Number of Days :</label>
        <div class="input">
          <select size="1" id="story_template_no" name="story_template_no" class="story_template_no" <?php if (!$_GET){ echo 'onChange="add_story_box()"';} ?> <?php if ($_GET){ echo 'disabled="disabled"'; } ?>>
            <option value="0">Select Number of Days</option>
            <?php for ($i=1; $i<=30; $i++) {?>
            <option <?php if ($_GET && $story[0]->story_template_no == $i){ echo 'selected="selected"';} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="clearfix">
        <ul class="dayrow" id="newbox">
          <?php if ($_GET){ ?>
          <?php for ($i=1; $i<=$story[0]->story_template_no; $i++) {?>
          <li class="day_<?php echo $i; ?> day">
            <h1><?php if ($_GET && $story[0]->story_template_id == 1){ echo 'Day';} ?><?php if ($_GET && $story[0]->story_template_id == 2){ echo 'Item';} ?><?php if ($_GET && $story[0]->story_template_id == 3){ echo 'Step';} ?><?php if ($_GET && $story[0]->story_template_id ==4){ echo 'Narration';} ?> <?php echo $i; ?></h1>
            <input type="hidden" name="story_desc_name" class="story_desc_name" id="story_desc_name" value="" />
            <div class="daybox">
              <div class="boxtitle">Happinesslabs</div>
              <div class="boxsub">
                <div class="smile"><img src="images/Career_icon.png" title="Smile" /></div>
                <div class="center">Day <?php echo $i; ?></div>
                <div class="boxreward">+10</div>
              </div>
              <div class="clear">&nbsp;</div>
              <div class="boximage">
                <div class="imageupload <?php echo $i; ?>-preview">
                  <div id="<?php echo $i; ?>-preview"><img src="images/Day_<?php echo $i; ?>.png" title="Upload Day <?php echo $i; ?> Image"/></div>
                  <input class="<?php echo $i; ?>-imgupload imgupload" name="image_upload_<?php echo $i; ?>" type="file" id="<?php echo $i; ?>-file" onClick="fileupload('<?php echo $i; ?>')" value=""/>
                </div>
              </div>
              <div class="todo">To Do</div>
              <div class="comments">Comments</div>
              <div class="questions">Questions</div>
              <div class="notes">Notes</div>
            </div>
          </li>
          <?php } ?>
          <?php } else { ?>
          <?php for ($i=1; $i<=3; $i++) {?>
          <li class="day_<?php echo $i; ?> day">
            <h1>Day <?php echo $i; ?></h1>
            <div class="daybox">
              <div class="boxtitle">Happinesslabs</div>
              <div class="boxsub">
                <div class="smile"><img src="images/Career_icon.png" title="Smile" /></div>
                <div class="center">Day <?php echo $i; ?></div>
                <div class="boxreward">+10</div>
              </div>
              <div class="clear">&nbsp;</div>
              <div class="boximage">
                <div class="imageupload <?php echo $i; ?>-preview">
                  <div id="<?php echo $i; ?>-preview"><img src="images/Day_<?php echo $i; ?>.png" title="Upload Day <?php echo $i; ?> Image"/></div>
                  <input class="<?php echo $i; ?>-imgupload imgupload" name="image_upload_<?php echo $i; ?>" type="file" id="<?php echo $i; ?>-file" onClick="fileupload('<?php echo $i; ?>')" value=""/>
                </div>
              </div>
              <div class="todo">To Do</div>
              <div class="comments">Comments</div>
              <div class="questions">Questions</div>
              <div class="notes">Notes</div>
            </div>
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      <div class="clearfix">
        <input id="story_cat_id" class="story_cat_id" name="story_cat_id" type="hidden" value="0" />
        <input id="user_id" class="user_id" name="user_id" type="hidden" value="1" />
        <?php if (!$_GET){echo '<input type="submit" title="Create" class="btn primary" value="Create"/>';}?>
      </div>
    </form>
  </div>
</section>
<footer> </footer>
</body>
</html>