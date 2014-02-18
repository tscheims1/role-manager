<?php

/**
 * @author James Schüpbch
 * @version 1.1
 */
 
 namespace RoleManager\Core\Lib;
 
 class ImportHelper
 {
 	/**
	 * This Method Imports a Class and get the reference of this class
	 * @param $string
	 * @throws \Exception
	 * @return object
	 */
	public static function import($classname)
	{
		
		$path = str_replace("\\", "/", $classname);
		$path = preg_replace("!.+(\/App.+)!","$1",$path);
		$file = \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir().$path.".php";
		if(!is_readable($file))
			throw new \Exception("ImportHepler: Classfile dosen't exists: ".$file);
		
		
		include_once(\RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir().$path.".php");
		
		return new $classname;
	}
 }