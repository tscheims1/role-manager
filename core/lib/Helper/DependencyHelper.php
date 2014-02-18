<?php


/**
 * This Class helps to manage the dependency with files and User Agents
 * @author James Schüpbach
 * @since 1.1
 */
  
 namespace RoleManager\Core\Lib\Helper;
 
 class DependencyHelper
 {
 	/**
	 * Singleton designPattern - single instance
	 * @var object
	 */
 	private static $instance;
	
	/**
	 * The Dependency ConfigArray
	 * @var array
	 */
	private $depsArray = array();
	
	/**
	 * Constructor must be privat
	 * @param array
	 */
	private function __construct($args)
	{
		$this->depsArray = $args;
	}
	private function __clone(){} 
	/**
	 * Sinleton Design pattern
	 * @param array
	 * @return object
	 */
	public static  function getInstance($args =array())
	{
		if(self::$instance === null)
		{
			self::$instance = new DependencyHelper($args);		
		}
		return self::$instance;
	}
	/**
	 * This method get the File dependency
	 * @param string
	 * @return array
	 */
	public function getFileDependency($filename)
	{
		
		if(isset($this->depsArray[$filename]))
			return $this->depsArray[$filename]['deps'];
		return array();
	}
	/**
	 * This method will check if the current File 
	 * has load restriciton.
	 * Return true if the file should not be loaded
	 * @param string
	 * @return array
	 */
	public function hasLoadRestriction($filename)
	{
		if(!isset($this->depsArray[$filename]['userAgent']['name']))
			return false;
		
		$bc = new \RoleManager\Core\Vendor\Browscap\Browscap( \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir()."/core/vendor/Browscap/cache");
		
		$userAgent = $bc->getBrowser(null,true);
		
		
		if(preg_match("!".$userAgent['Browser']."!i", $this->depsArray[$filename]['userAgent']['name']))
		{
			if(!isset($this->depsArray[$filename]['userAgent']['version']))
				return false;
			
			if($userAgent['MajorVer'] == $this->depsArray[$filename]['userAgent']['version'])
				return false;
			return true;
		}
		return true;
	}		
 }