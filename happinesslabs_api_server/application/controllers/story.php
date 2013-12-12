<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class story extends CI_Controller {

	function story($params)
	{	
		parent::__construct();
		$this->_params = $params;
		$this->load->model('mdl_story');
	}
	
	function check_user_authentication()
	{
		return $this->mdl_story->check_user_authentication($this->_params);	
	}
	function save_story_data()
	{
		return $this->mdl_story->save_story_data($this->_params);
	}
	function update_story_data()
	{
		return $this->mdl_story->update_story_data($this->_params);
	}
	function delete_story_data()
	{
		return $this->mdl_story->delete_story_data($this->_params);
	}
	function get_my_story()
	{
		return $this->mdl_story->get_my_story($this->_params);
	}
	function get_story_data()
	{
		return $this->mdl_story->get_story_data($this->_params);
	}
	function get_all_stories()
	{
		return $this->mdl_story->get_all_stories($this->_params);
	}
	
	function save_tempdesc_data()
	{
		return $this->mdl_story->save_tempdesc_data($this->_params);
	}
	
	function save_todo()
	{
		return $this->mdl_story->save_todo($this->_params);
	}
	function save_comment()
	{
		return $this->mdl_story->save_comment($this->_params);
	}
	function save_question()
	{
		return $this->mdl_story->save_question($this->_params);
	}
	function save_answer()
	{
		return $this->mdl_story->save_answer($this->_params);
	}
	function save_notes()
	{
		return $this->mdl_story->save_notes($this->_params);
	}
	function save_tags()
	{
		return $this->mdl_story->save_tags($this->_params);
	}
	function get_all_mission()
	{
		return $this->mdl_story->get_all_mission($this->_params);
	}
}
