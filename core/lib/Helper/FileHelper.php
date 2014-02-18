<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
namespace RoleManager\Core\Lib\Helper;
/**
 * Helper for getting the Plugin Directory in Deep Directories.
 */
class FileHelper
{
	/**
	 * This Method gets the absolut BaseDir of the current Plugin
	 * @TODO: Fix the Bug with the Basepath
	 * @return string
	 */
	static function getPluginBaseDir()
	{
	
		$baseName = self::getPluginName();
		
		
		/*
		 * Workarround for getting the absolute Plugin Basepath
		 * 
		 */ 
		
		$rc = new \ReflectionClass('\RoleManager\Core\Bootstrap');
		$path =  plugin_dir_path($rc->getFileName());
		
		return preg_replace('!(.*)(core\/)$!', "$1", $path);
		
	}
	
	/**
	 * this Method get the Name of the current Plugin
	 * @return string
	 */
	static function getPluginName()
	{
		$base = plugin_basename(__FILE__);
		
		return  preg_replace("!(.*?)(\/.*)!", "$1", $base);
	}
}