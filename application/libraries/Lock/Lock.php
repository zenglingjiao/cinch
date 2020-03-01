<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock extends CI_Driver_Library {
	
	protected $valid_drivers = array(
		'dummy',
		'file',
		'redis',
	);
	
	protected $_adapter = 'dummy';

	protected $_backup_driver = 'file';

	public $key_prefix = '';
	
	public function __construct($config = array())
	{
		isset($config['adapter']) && $this->_adapter = $config['adapter'];
		isset($config['backup']) && $this->_backup_driver = $config['backup'];
		isset($config['key_prefix']) && $this->key_prefix = $config['key_prefix'];

		if ( ! $this->is_supported($this->_adapter))
		{
			if ( ! $this->is_supported($this->_backup_driver))
			{
				log_message('error', 'Lock adapter "'.$this->_adapter.'" and backup "'.$this->_backup_driver.'" are both unavailable. Lock is now using "Dummy" adapter.');
				$this->_adapter = 'dummy';
			}
			else
			{
				// Backup is supported. Set it to primary.
				log_message('debug', 'Lock adapter "'.$this->_adapter.'" is unavailable. Falling back to "'.$this->_backup_driver.'" backup adapter.');
				$this->_adapter = $this->_backup_driver;
			}
		}
	}
	
	public function lock($id, $expire=5)
	{
		return $this->{$this->_adapter}->lock($this->key_prefix.$id, $expire);
	}
	
	public function unlock($id)
	{
		return $this->{$this->_adapter}->unlock($this->key_prefix.$id);
	}
	
	public function is_supported($driver)
	{
		static $support;

		if ( ! isset($support, $support[$driver]))
		{
			$support[$driver] = $this->{$driver}->is_supported();
		}

		return $support[$driver];
	}
}