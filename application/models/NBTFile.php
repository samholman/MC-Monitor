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
		$output = array();
		$data = $this->getRawData($path);
		$data = str_split($data);
		$this->parseData($data, $output);
		print_r($data);
		print_r($output);
		
		//var_dump(ord($data[18]));
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
	public function parseData(&$data, &$current)
	{
		while ($char = current($data))
		{
			if (ord($char) == self::TAG_END) {
				return;
			}
			
			$name = $this->parseTagName($data);
			$this->parseNextValue(ord($char), $data, $current, $name);
			
			next($data);
		}
	}
	
	private function parseNextValue($tag, &$data, &$current, $name)
	{
		switch ($tag)
		{
			case self::TAG_COMPOUND;
				$current[$name] = array();
				next($data);
				$this->parseData($data, $current[$name]);					
				break;
				
			case self::TAG_BYTE_ARRAY:	
			case self::TAG_STRING:
				$current[$name] = $this->parseString($data);
				break;
				
			case self::TAG_BYTE:
				$current[$name] = $this->parseInt($data, 1);
				break;
				
			case self::TAG_SHORT:
				$current[$name] = $this->parseInt($data, 2);
				break;
			case self::TAG_INT:
				$current[$name] = $this->parseInt($data, 4);
				break;
			case self::TAG_LONG:
				$current[$name] = $this->parseInt($data, 8);
				break;
				
			case self::TAG_LIST:
				$current[$name] = $this->parseList($data);
				break;
		}
	}
	
	/**
	 * parse the tagname from the data array
	 * 
	 * @param array $data
	 * @return string
	 */
	private function parseTagName(&$data)
	{
		next($data);
		$length = ord(next($data));
		$string = '';
		
		for ($i=0; $i<$length; $i++) {
			$string .= next($data);
		}

		return $string;
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
		$length = ord(next($data));
		$string = '';
		
		for ($i=0; $i<$length; $i++) {
			$string .= next($data);
		}
		
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
		next($data);
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
		$length = ord(next($data));
		
		for ($i=0; $i<$length; $i++)
		{
			//$output[] = 
		}

		return $output;
	}
}

