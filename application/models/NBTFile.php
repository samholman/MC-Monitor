<?php

class Application_Model_NBTFile
{
	const
		TAG_END 		= 0,
		TAG_BYTE 		= 1,
		TAG_SHORT 		= 2,
		TAG_INT 		= 3,
		TAG_LONG 		= 4,
		TAG_FLOAT 		= 5,
		TAG_DOUBLE 		= 6,
		TAG_BYTE_ARRAY 	= 7,
		TAG_STRING 		= 8,
		TAG_LIST		= 9,
		TAG_COMPOUND 	= 10;
	/**
	 * Loads and parses the player data
	 * 
	 * @param string $path
	 */
	public function load($path)
	{
		$data = $this->getRawData($path);
		$data = str_split($data);
		$output = $this->parseData($data);
		print_r($data);
		print_r($output);
		
		var_dump(ord($data[29]));
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
	 * @param array $data
	 * @return array
	 */
	public function parseData(&$data)
	{
		//var_dump(key($data));
		$output = array();
		
		while ($char = current($data))
		{
			if (ord($char) == self::TAG_END) {
				return !empty($output) ? $output : null;
			}
			
			$name = $this->parseString($data);
			$output[$name] = $this->parseNextValue(ord($char), $data);
			
			next($data);
		}
		
		return $output;
	}
	
	private function parseNextValue($tag, &$data)
	{
		switch ($tag)
		{
			case self::TAG_COMPOUND;
				next($data);
				return $this->parseData($data);					
				break;
				
			case self::TAG_BYTE_ARRAY:	
			case self::TAG_STRING:
				
				return $this->parseString($data);
				break;
				
			case self::TAG_BYTE:
				return $this->parseInt($data, 1);
				break;
				
			case self::TAG_SHORT:
				return $this->parseInt($data, 2);
				break;
			
			case self::TAG_FLOAT:
			case self::TAG_INT:
				return $this->parseInt($data, 4);
				break;
			
			case self::TAG_DOUBLE:
			case self::TAG_LONG:
				return $this->parseInt($data, 8);
				break;
				
			case self::TAG_LIST:
				return $this->parseList($data);
				break;
		}
	}
	
	/**
	 * parse the next part of the file as a string
	 * 
	 * @param array $data
	 * @return string
	 */
	private function parseString(&$data)
	{
		next($data);
		var_dump(key($data));
		$length = ord(next($data));
		$string = '';
		
		for ($i=0; $i<$length; $i++) {
			$string .= next($data);
		}
		//var_dump($string);
		return $string;
	}
	
	/**
	 * parse the next part of the file as a int
	 * 
	 * @param array $data
	 * @param int $length
	 * @return int
	 */
	private function parseInt(&$data, $length)
	{
		$number = 0;
		
		for ($i=0; $i<$length; $i++) {
			$number += (next($data) * (($length - $i) * 512));
		}
		
		return $number;
	}
	
	/**
	 * parse the next part of the file as a list
	 * 
	 * @param array $data
	 * @return string
	 */
	private function parseList(&$data)
	{
		$output = array();
		$tag = ord(next($data));
		next($data);
		$length = ord(next($data));
		
		for ($i=0; $i<$length; $i++) {
			$output[] = $this->parseNextValue($tag, $data);
		}

		return $output;
	}
}

