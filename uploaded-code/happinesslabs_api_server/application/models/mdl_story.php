<?php
class mdl_story extends CI_Model
{

	function mdl_story()
	{
		parent::__construct();
		//date_default_timezone_set('Asia/Calcutta');
	}
	function ParamValidation($paramarray,$data)
	{
		$NovalueParam='';
		foreach($paramarray as $val)
		{
			if(!array_key_exists($val,$data))
			{				
				$NovalueParam[]=$val;
			}
		}
		if(is_array($NovalueParam) && count($NovalueParam)>0)
		{
			$returnArr['error']=true;
			$returnArr['msg']='Sorry, that is not valid input. You missed '.implode(',',$NovalueParam).' parameters';
			return $returnArr;
		}
		else
		{
			return false;
		}
	}
	
	function check_user_authentication($param)
	{
		$this->db->select('*');
		$this->db->where('user_id',$param['user_id']);
		$this->db->where('del_in',0);
		$query = $this->db->get('tbl_user');
		$val = $query->row_array();
		if(!$val)
		{
			$result['msg'] = 'user not found';
			$result['status'] = 0;
			$result['status_code'] = 201;
			return $result;
		}
		else
		{	$result['status'] = 1;
			return $result;
		}
		
	}
	
	function save_story_data($param)
	{	
		$user_data = array('story_title','story_description','story_price','story_access','story_template_id','story_template_no','story_cat_id','story_mission_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_story',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	
	function update_story_data($param)
	{
		$story_id = $param['story_id'];
		$this->db->where('story_id',$todo_id);
		$this->db->update('tbl_story',$param);
		$result['msg'] = 'data updated successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		return $result;
	}
	
	function delete_story_data($param)
	{
		$story_id = $param['story_id'];
		$data['del_in'] = 1;
		$this->db->where('story_id',$todo_id);
		$this->db->update('tbl_story',$data);
		$result['msg'] = 'data deleted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		return $result;
	}
	
	function get_story_data($param)
	{
		$this->db->select('*');
		$query = $this->db->get('tbl_story');
		$result['msg'] = 'data Found';
		$result['status'] = 1;
		$result['status_code'] = 200;
		$result['data'] = $query->result_array();
		return $result;
	}
	
	
	function uploadFile($uploadFile,$filetype,$folder,$fileName='')
	{
		$resultArr = array();
		
		$config['max_size'] = '1024000';
		if($filetype == 'img') 	$config['allowed_types'] = 'gif|jpg|png|jpeg';
		if($filetype == 'All') 	$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|zip|xls';
		if($filetype == 'swf') 	$config['allowed_types'] = 'swf';
		if($filetype == 'html') 	$config['allowed_types'] = 'html|htm';
		
		if($filetype == 'video') 	$config['allowed_types'] = 'csv|mp4|3gp|vob|flv';
		if($filetype == 'DOC') 	$config['allowed_types'] = 'doc|docx';
		if($filetype == 'XLS') 	$config['allowed_types'] = 'xls|xlsx';
		if($filetype == 'PPT') 	$config['allowed_types'] = 'ppt';
		if($filetype == 'PDF') 	$config['allowed_types'] = 'pdf';

		if(substr($folder,0,17)=='application/views')
			$config['upload_path'] = './'.$folder.'/';
		else
			$config['upload_path'] = './uploads/'.$folder.'/';
			
		if($fileName != "")
			$config['file_name'] = $fileName;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($uploadFile))
		{
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}	
		else
		{
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			if(substr($folder,0,17)=='application/views')
				$resultArr['path'] = $folder.'/'.$resArr['file_name'];
			else
				$resultArr['path'] = "uploads/".$folder."/".$resArr['file_name'];
		}
		return $resultArr;
	}
	
	function save_tempdesc_data($param)
	{
		$user_data = array('story_desc_name','story_desc_imgtitle','story_desc_imgsrc','story_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_story_tempwise_desc',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	
		
}
	 
