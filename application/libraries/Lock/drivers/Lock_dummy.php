<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_dummy extends CI_Driver {
	
	public function lock($id, $expire=5)
	{
		return TRUE;
	}
	
	public function unlock($id)
	{
		return TRUE;
	}
	
	public function is_supported()
	{
		return TRUE;
	}
}

