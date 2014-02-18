<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
 
namespace Debug;
 
/**
 * This Class Help  is a helper for the debuging
 */ 
class Debug
{
	/**
	 * This Method dump an object readable
	 * @param mixed
	 */
	public static function dump($object)
	{
		echo "<pre>";
		print_r($object);
		echo "</pre>";
	}
	
}


?>