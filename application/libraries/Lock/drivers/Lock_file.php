<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_file extends CI_Driver {

	protected $_lock_path;
	protected $_lock_fp_map = array();

	public function __construct()
	{
		$CI =& get_instance();
		$CI->load->helper('file');
		$path = $CI->config->item('lock_path');
		$this->_lock_path = ($path === NULL OR $path === '') ? APPPATH.'lock' : $path;
	}
	
	public function lock($id, $expire=5)
	{
		$lock_file = sprintf('%s/%s.%s.lock', $this->_lock_path, preg_replace('/[^a-z0-9\._-]+/i', '-', $id), md5($id));

		$fp = fopen($lock_file, 'w+');
		if ($fp === FALSE)
		{
			return FALSE;
		}

		$this->_lock_fp_map[$id] = array('fp' => $fp, 'name' => $lock_file);
		
		$result = flock($fp, LOCK_EX);
		return $result;
	}
	
	public function unlock($id)
	{
		if ( ! isset($this->_lock_fp_map[$id]))
		{
			return FALSE;
		}
		
		$lock_info = $this->_lock_fp_map[$id];
		
		$fp = $lock_info['fp'];
		flock($fp, LOCK_UN);
		fclose($fp);
		
		unset($this->_lock_fp_map[$id]);
		return TRUE;
	}
	
	public function is_supported()
	{
		return is_really_writable($this->_lock_path);
	}
}

