<?php

if($_FILES)
{
	print_r($_FILES);
	
	$file_name="test_image";
	$a=file_Upload($_FILES,$file_name);
	echo json_encode($a);
	
}

function file_Upload($arr,$file_name,$file_var='photoimg') {
		$result = array();
		$result['code'] = 2;
		$result['message'] = 'File Not Post';
		$result['file_name'] = '';
		if (isset($arr[$file_var]['name'])) {
	
			$temp = explode('.', $arr[$file_var]['name']);
			$extention = end($temp);
	
			$file_name = $file_name . '.' . $extention;
			
			$path = 'uploads/';
			$file_path = $path . $file_name;
			if (move_uploaded_file($arr[$file_var]["tmp_name"], $file_path) > 0) {
				$result['file_name'] = $file_name;
				$result['code'] = 1;
				$result['message'] = 'succesfully uploaded';
			} else {
				$result['code'] = 3;
				$result['message'] = 'file Not Upload';
			}
		}
		return $result;
	}

?>