<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock_redis extends CI_Driver {
	
	protected static $_default_config = array(
		'socket_type' => 'tcp',
		'host' => '127.0.0.1',
		'password' => '',
		'port' => 6379,
		'timeout' => 0
	);
	
	protected $_redis = NULL;
	
	protected $_key_value_map = array();
	
	public function __construct()
	{
		if ( ! extension_loaded('redis'))
		{
			log_message('error', 'Lock: Failed to create Redis object; extension not loaded?');
			return;
		}
		
		$CI =& get_instance();

		if ($CI->config->load('redis', TRUE, TRUE))
		{
			$config = array_merge(self::$_default_config, $CI->config->item('redis'));
		}
		else
		{
			$config = self::$_default_config;
		}

		$this->_redis = new Redis();

		try
		{
			if ($config['socket_type'] === 'unix')
			{
				$success = $this->_redis->connect($config['socket']);
			}
			else // tcp socket
			{
				$success = $this->_redis->connect($config['host'], $config['port'], $config['timeout']);
			}

			if ( ! $success)
			{
				log_message('error', 'Lock: Redis connection failed. Check your configuration.');
				throw new \RedisException('connection failed');
			}

			if (isset($config['password']) && ! $this->_redis->auth($config['password']))
			{
				log_message('error', 'Lock: Redis authentication failed.');
				throw new \RedisException('authentication failed');
			}
		}
		catch (RedisException $e)
		{
			log_message('error', 'Lock: Redis connection refused ('.$e->getMessage().')');
			$this->_redis->close();
			unset($this->_redis);
			$this->_redis = NULL;
		}
	}
	
	public function __destruct()
	{
		if ($this->_redis)
		{
			$this->_redis->close();
		}
	}
	
	public function lock($id, $expire=10)
	{
		if ( ! $this->_redis)
		{
			return FALSE;
		}

		$value = mt_rand();
		$this->_key_value_map[$id] = $value;
		$is_lock = $this->_redis->set($id, $value, ["nx", "ex" => $expire]);

		while ( ! $is_lock)
		{
			usleep(100000);
			$is_lock = $this->_redis->set($id, $value, ["nx", "ex" => $expire]);
		}

		return TRUE;
	}
	
	public function unlock($id)
	{
		if ( ! $this->_redis)
		{
			return FALSE;
		}
		
		$value = $this->_redis->get($id);
		if ( isset($this->_key_value_map[$id]) && $value == $this->_key_value_map[$id])
		{
			unset($this->_key_value_map[$id]);
			return $this->_redis->del($id);
		}
		
		return TRUE;
	}
	
	public function is_supported()
	{
		if ($this->_redis)
		{
			return TRUE;
		}
		return FALSE;
	}
}
