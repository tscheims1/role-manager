<?php
/**
 * @author James Schüpbch
 * @version 1.0
 */
namespace RoleManager\Core;

/**
 * The Bootstrap Factory of the MVC Framework
 */
class MVCFactory
{
	/**
	 * All Classes that are built with the Factory Class are Stored Here
	 * @var Object
	 */
	private static $instances = array();

	
	
	/**
	 * Facotry Method for Include and Create all necessary Classes
	 * @return Object
	 */
	public static function factory($name,$args = null)
	{
		if(!isset(self::$instances[$name]))
		{
			if(!self::isClassNameValid($name))	
				throw new \Exception("Invalid Class Name");
			
			self::includeClasses($name);
			
			$controllerName = "\\RoleManager\\App\\Controller\\".$name."Controller";
			$viewName = "\\RoleManager\\App\\View\\".$name."View";
			$modelName = "\\RoleManager\\App\\Model\\".$name;
			
			self::$instances[$name] = new $controllerName('index',new $viewName(),new $modelName($name));
		}
		return self::$instances[$name];
	}
	/**
	 * Include all necessary Classes
	 * @param string
	 * @throws Exceptions if class Files arent readable
	 */
	private static function includeClasses($name)
	{	
		$absPath = plugin_dir_path(__DIR__);
		

		
		/*
		 * Throw an Exception if one Class File is not readable
		 */
		if(!is_readable($absPath."app/controller/".$name."Controller.php"))
		{
			throw new \Exception("Class file dosen't exist: ".$absPath."app/controller/".$name."Controller.php");
			
		}
		if(!is_readable($absPath."app/model/".$name.".php"))
		{
			throw new \Exception("Class file dosen't exist: ".$absPath."app/model/".$name.".php");
		}
	
	    if(!is_readable($absPath."app/view/".$name."View.php"))
	    {
			throw new \Exception("Class file dosen't exist: ".$absPath."app/view/".$name."View.php");
		}
		
		include_once $absPath."app/controller/".$name."Controller.php";
		include_once $absPath."app/model/".$name.".php";
		include_once $absPath."app/view/".$name."View.php";
	}
	/**
	 * Validate the Classname
	 * @TODO: Exclude in Helper Class
	 * @param string
	 * @return boolean
	 */
	private static function isClassNameValid($name)
	{
		return preg_match("!^[\w]+$!",$name);
			
	}
}