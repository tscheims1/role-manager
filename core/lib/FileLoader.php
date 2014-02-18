<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
namespace RoleManager\Core\Lib;

use Core\Lib\Helper\FileHelper;

/**
 * This Class loads all 
 * Javascript and CSS files in the 
 * Standard script and stlye folders.
 */
class FileLoader
{
	/**
	 * Regex pattern for fetching the css files
	 * @var string
	 */
	private $styleRegexPattern = "!.*\.css$!";
	/**
	 * Regex pattern for fetching the js files
	 * @var string
	 */
	private $scriptRegexPattern ="!.*\.js$!";
	
	/**
	 * Relate File paths
	 * @var constant
	 */  
	const ADMINSCRIPTPATH = "admin/script/";
	const ADMINSTYLEPATH  = "admin/css/";
	const USERSCRIPTPATH  = "script/";
	const USERSTYLEPATH   = "css/";
	
	/**
	 * Stores all File Configurations
	 * eg.
	 * array(
	 * 			'Filename' => array(
	 * 				'deps' => array('jquery',jquery-ui','Path/to/own/script')
	 * 				'UserAgent' => array(
	 * 					'name' => 'Firefox',
	 * 					'version => ''
	 * 		))
	 * ));
	 * @var array
	 */
	private $fileConfig = array();
	
	/**
	 * Dependency Instance
	 * @var object
	 */
	private $dependencyManager;
	
	/*
	 * Singleton Design Pattern
	 */ 
	private function __construct($fileConfig)
	{
		$this->fileConfig = $fileConfig;
		$this->dependencyManager = \RoleManager\Core\Lib\Helper\DependencyHelper::getInstance($fileConfig);
		
	}
	private function __clone(){} 
	
	private static $instance = null;
	
	public static function getInstance($fileConfig = array())
	{
		if(self::$instance === null)
		{
			self::$instance = new FileLoader($fileConfig);
		}
		return self::$instance;
	}
	/***************************************/
	
	
	/**
	 * Include All Scripts in the Script Directory
	 */
	public function enqueueScripts()
	{
		
		$baseDir =  \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir();
		$baseDir .= MvcConfig::SCRIPT_DIR."/";
		
		if(!is_dir($baseDir))
			throw new \Exception("Script Directory dosen't exist");
			
		$scripts = scandir($baseDir);
		
		if(count($scripts))
			foreach($scripts as $script)
			{
				if(preg_match($this->scriptRegexPattern,$script) && !wp_script_is($script) && !$this->dependencyManager->hasLoadRestriction(self::USERSCRIPTPATH.$script))
				{
					wp_enqueue_script(self::USERSCRIPTPATH.$script,plugins_url()."/".\RoleManager\Core\Lib\Helper\FileHelper::getPluginName()."/"
						.MvcConfig::SCRIPT_DIR."/".$script,$this->dependencyManager->getFileDependency(self::USERSCRIPTPATH.$script));
				}
			}
	}
	/**
	 * Include all Scripts in the Admin Script Directory
	 */
	public function adminEnqueueScripts()
	{
		$baseDir =  \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir();
		$baseDir .= MvcConfig::ADMIN_SCRIPT_DIR."/";
		
		if(!is_dir($baseDir))
			throw new \Exception("Admin Script Directory dosen't exist");
		
		$scripts = scandir($baseDir);
		if(count($scripts))
			foreach($scripts as $script)
			{
				if(preg_match($this->scriptRegexPattern,$script) && !wp_script_is($script) && !$this->dependencyManager->hasLoadRestriction(self::ADMINSCRIPTPATH.$script))
				{
					
					wp_enqueue_script(self::ADMINSCRIPTPATH.$script,plugins_url()."/".\RoleManager\Core\Lib\Helper\FileHelper::getPluginName()."/".
						MvcConfig::ADMIN_SCRIPT_DIR."/".$script,$this->dependencyManager->getFileDependency(self::ADMINSCRIPTPATH.$script));
				}
			}
	}
	/**
	 * Include all Styles in the Styles Directory
	 */
	public function enqueueStyles()
	{
		
		$baseDir =  \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir();
		$baseDir .= MvcConfig::STYLE_DIR."/";

		if(!is_dir($baseDir))
			throw new \Exception("Style Directory dosen't exist");
		
		$styles = scandir($baseDir);
		if(count($styles))
			foreach($styles as $style)
			{
				if(preg_match($this->styleRegexPattern,$style) && !wp_style_is($style) && !$this->dependencyManager->hasLoadRestriction(self::USERSTYLEPATH.$script))
				{
					wp_enqueue_style(self::USERSTYLEPATH.$style,plugins_url()."/".\RoleManager\Core\Lib\Helper\FileHelper::getPluginName()."/"
						.MvcConfig::STYLE_DIR."/".$style,$this->dependencyManager->getFileDependency(self::USERSTYLEPATH.$script));
				}
			}
	}
	/**
	 * Include all Scripts in the Admin Style Directory
	 */
	public function adminEnqueueStyles()
	{
		$baseDir =  \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir();
		$baseDir .= MvcConfig::ADMIN_STYLE_DIR."/";
		
		
		if(!is_dir($baseDir))
			throw new \Exception("Admin Style Directory dosen't exist");
		
		$styles = scandir($baseDir);
		if(count($styles))
			foreach($styles as $style)
			{
				if(preg_match($this->styleRegexPattern,$style) && !wp_style_is($style) && !$this->dependencyManager->hasLoadRestriction(self::USERSTYLEPATH.$script))
				{
					
					wp_enqueue_style(self::ADMINSTYLEPATH.$style,plugins_url()."/".\RoleManager\Core\Lib\Helper\FileHelper::getPluginName()."/"
						.MvcConfig::ADMIN_STYLE_DIR."/".$style,$this->dependencyManager->getFileDependency(self::USERSTYLEPATH.$script));
				}
			}
	}
	
}
?>