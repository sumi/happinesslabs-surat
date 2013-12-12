<?php
include_once('story.php');

$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$param['story_title'] = 'test_title';
$obj_story = new story($param);  

$result = $obj_story->save_story_data();
echo '<pre>';
print_r($result);

?>
