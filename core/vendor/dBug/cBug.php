<?php

/**
 * Wrapper for the dBug Class, that render the Debug output at the of the Current page
 * @author James Schüpbach
 * @version 1.1.0
 * @since   1.1.0
 */
 class cBug
{
	/**
	 * Here is the whole Debug oupt stored
	 * @var array
	 */
	private static $output = array();
	
	/**
	 * Variable to check if the action is already registered
	 * @var boolean
	 */
	private static $isRegistred = false;
	
	/**
	 * Generates a new Debug Output
	 * @param mixed
	 * @param string
	 * @param booean
	 */
	public function __construct($var,$forceType="",$bCollapsed=false)
	{
		/*
		 * Register the Output function once
		 */ 
		if(self::$isRegistred === false)
		{
			add_action('shutdown','\cBug::renderOutput');
			self::$isRegistred = true;
		}
	
		/*
		 * add the debug Output variables 
		 */
		 self::$output[] = array($var,$forceType,$bCollapsed);

	}
	/**
	 * Render the whole Debug output, after the page is loaded
	 */
	public static function renderOutput()
	{
		
		foreach(self::$output as $output)
		{
			new \dBug($output[0],$output[1],$output[2]);
		}
	}
}