<?php

class Application_Model_Iterator implements Iterator
{
	private
		$_items = array();
	
	/**
	 * Set an array of items to iterate over
	 * 
	 * @param array $items
	 * @return void
	 */
	public function setItems(array $items)
	{
		$this->_items = $items;
	}
	
	public function current()
	{
		return current($this->_items);
	}
	
	public function next()
	{
		return next($this->_items);
	}
	
	public function key()
	{
		return key($this->_items);
	}
	
	public function valid()
	{
		$key = key($this->_items);
		$var = ($key !== null && $key !== false);
		return $var;
	}
	
	public function rewind()
	{
		reset($this->_items);
	}
}
