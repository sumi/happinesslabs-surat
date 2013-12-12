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
		
		unset($param['controller']);
		unset($param['action']);
		//unset($param['user_id']);
		
		$this->db->insert('tbl_story',$param);
		$result['data'] = $this->db->insert_id();
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
	
	function get_my_story($param)
	{

		$this->db->select('*');
		$this->db->where('user_id', $param['user_id']); 
		$this->db->from('tbl_story');
		$query = $this->db->get();
		
		$result['msg'] = 'data Found';
		$result['status'] = 1;
		$result['status_code'] = 200;
		$result['stories'] = $query->result_array();
	
	
		$i=0;
		foreach($result['stories'] as $list)
		{
			$val = $this->get_image_data($list['story_id']);
			$result['stories'][$i]['img_data'] = $val;
			$i++;
		}
		return $result;	
	}
	
	function get_story_data($param)
	{
		$this->db->select('*');
		$this->db->where('story_id', $param['story_id']); 
		$this->db->from('tbl_story');
		$query = $this->db->get();
		
		$result['msg'] = 'data Found';
		$result['status'] = 1;
		$result['status_code'] = 200;
		$result['stories'] = $query->result_array();
		
		$i=0;
		foreach($result['stories'] as $list)
		{
			$val = $this->get_image_data($list['story_id']);
			$result['stories'][$i]['img_data'] = $val;
			$i++;
		}
		return $result;
	}
	function get_all_stories($param)
	{
		$this->db->select('*');
		$this->db->from('tbl_story');
		$query = $this->db->get();
		
		$result['msg'] = 'data Found';
		$result['status'] = 1;
		$result['status_code'] = 200;
		$result['stories'] = $query->result_array();
		
		$i=0;
		foreach($result['stories'] as $list)
		{
			$val = $this->get_image_data($list['story_id']);
			$result['stories'][$i]['img_data'] = $val;
			$i++;
		}
		
		return $result;
	}
	function get_image_data($story_id)
	{
		$this->db->select('*');
		$this->db->where('story_id', $story_id); 
		$this->db->from('tbl_story_tempwise_desc');
		$query = $this->db->get();
		return $query->result_array();
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
		
		$img = $this->image_upload($param['story_desc_imgsrc'],'story_images',time().'.jpg');
		
		unset($param['controller']);
		unset($param['action']);
		unset($param['user_id']);
		unset($param['story_desc_imgsrc']);
		
		$param['story_desc_imgsrc'] = $img['path'];
	
		$this->db->insert('tbl_story_tempwise_desc',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	
	function image_upload($uploadFile,$folder,$file_name)
	{
		$upload_path = './uploads/'.$folder.'/';
	
		$binary = base64_decode($uploadFile);
		header('Content-Type: bitmap; charset=utf-8');
		$file = fopen('./'.$upload_path.'/'.$file_name.'', 'wb');
		fwrite($file, $binary);
		fclose($file);	
		
		$resultArr['path'] = "uploads/".$folder."/".$file_name;
		$resultArr['succsess'] = 1;
		return $resultArr;
	}
	
	function save_todo($param)
	{
		$user_data = array('todo_desc','story_id','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_tempdesc_todo',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	function save_comment($param)
	{
		$user_data = array('comment_desc','story_id','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_tempdesc_comment',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	function save_question($param)
	{
		$user_data = array('question_desc','story_id','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_tempdesc_questions',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	function save_answer($param)
	{
		$user_data = array('ans_desc','question_id','story_id','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_question_answers',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	function save_notes($param)
	{
		$user_data = array('note_desc','story_id','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_tempdesc_notes',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	function save_tags($param)
	{
		$user_data = array('tag_title','tag_type','tag_image','story_desc_id','user_id');
		$validation = $this->ParamValidation($user_data,$param);
		if($validation['error'])
		{
			$result['msg'] = $validation['msg'];
			$result['status'] = 0;
			$result['status_code'] = 202;
			return $result;	
		}
	
		$this->db->insert('tbl_tempdesc_tags',$param);
		$result['msg'] = 'data inserted successfully';
		$result['status'] = 1;
		$result['status_code'] = 200;
		
		return $result;
	}
	
		
}
