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
	function get_story_data()
	{
		return $this->mdl_story->get_story_data($this->_params);
	}
	
	function save_tempdesc_data()
	{
		return $this->mdl_story->save_tempdesc_data($this->_params);
	}
}
