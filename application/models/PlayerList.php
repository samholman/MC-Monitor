<?php

/**
 * Singleton player list model
 */
class Application_Model_PlayerList
{
	private static 
		$_instance;
		
	private
		$_players = array();
	
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
	private function __construct() {}
	
	/**
	 * Load the server player list
	 * 
	 * @return bool
	 */
	private function load()
	{
		$iterator = new DirectoryIterator(Zend_Registry::get('config')->get('minecraft')->get('worldPath') . '/world/players/');
		
		foreach ($iterator as $fileinfo)
		{
			if ($fileinfo->isFile())
			{
				$player = new Application_Model_Player();
				
				if ($player->load($fileinfo->getBasename('.dat'))) {
					$this->_players[] = $player;
				}
			}
		}
	}
	
	/**
	 * Returns a player iterator object
	 * 
	 * @return Application_Model_Iterator
	 */
	public function getIterator()
	{
		$iterator = new Application_Model_Iterator();
		$iterator->setItems($this->_players);
		
		return $iterator;
	}
}
