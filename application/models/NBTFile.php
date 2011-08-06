<?php

class Application_Model_NBTFile
{
	const
		TAG_END = 0,
		TAG_BYTE = 1,
		TAG_SHORT = 2,
		TAG_INT = 3,
		TAG_LONG = 4,
		TAG_FLOAT = 5,
		TAG_DOUBLE = 6,
		TAG_BYTE_ARRAY = 7,
		TAG_STRING = 8,
		TAG_LIST = 9,
		TAG_COMPOUND = 10;
	/**
	 * Loads and parses the player data
	 * 
	 * @param string $path
	 */
	public function load($path)
	{
		$data = $this->getRawData($path);
		$this->parseData($data);
	}

	/**
	 * Gets the unziped contents of the players data file
	 * 
	 * @param string $path
	 * @return string
	 */
	private function getRawData($path)
	{
		$file = gzopen($path, 'rb');
		if ($file)
		{ 
			$data = ''; 
			while (!gzeof($file)) { 
				$data .= gzread($file, 1024); 
			} 
			gzclose($file); 
		}
		
		return $data;
	}
	
	/**
	 * Parse the NBT file in to an array
	 * 
	 * @param string $data
	 * @return array
	 */
	public function parseData($data)
	{
		$return = array();
		
		$data = str_split($data); 
		
		foreach ($data as $char)
		{
			switch (ord($char))
			{
				case self::TAG_COMPOUND;
					break;
				
				case self::TAG_STRING:
					$return[] = $this->parseString($data);
					break;
			}
		}
		
		return $return;
	}
	
	/**
	 * parse the next part of the file as a string
	 * 
	 * @param array $data
	 * @return array
	 */
	private function parseString(&$data)
	{
		
	}
}

