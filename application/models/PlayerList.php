<?php

/**
 * Singleton player list model
 */
class Application_Model_PlayerList
{
	private static 
		$_instance;
	
	/**
	 * Returns an instantiated and loaded player list model instance
	 * 
	 * @return Application_Model_PlayerList::
	 */
	public static function get()
	{
		if (!self::$_instance)
		{
			self::$_instance = new Application_Model_PlayerList();
			self::$_instance->load();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Constructs a new player list
	 * 
	 * @return void
	 */
	private function __construct()
	{
		
	}
	
	/**
	 * Load the server player list
	 * 
	 * @return bool
	 */
	private function load()
	{
		
	}
	
	/**
	 * Returns a player iterator object
	 * 
	 * @return unknown
	 */
	public function getIterator()
	{
		
	}
}
