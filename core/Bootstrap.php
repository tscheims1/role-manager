<?php
/**
 * @author James Schüpbch
 * @version 1.0
 */
namespace RoleManager\Core;

/**
 * The Bootstrap Factory of the MVC Framework
 */
class Bootstrap
{

	
	/**
	 * Instance must be Private (Singleton Pattern)
	 * @var object
	 */
	private static $instance = null;
	
	/**
	 * Here are the Plugin Configuration stored
	 * @var array
	 */
	private $confArrary;
	
	/**
	 * Private Constructor for the Singleton Pattern
	 */
	private function __construct($confArgs =array())
	{
		
		$this->confArrary = $confArgs;
	}
	private function __clone(){}
	
	/**
	 * Static Getter Method: if an instance exists: return this instance
	 * if not: create a new one
	 * @return Bootstrap
	 */
	public static  function getInstance($confArgs = array())
	{
		if(!self::$instance)
		{
			self::$instance = new Bootstrap($confArgs);
		}
		return self::$instance;
	}
	/**
	 * Include and initialize all necessary Files and classes 
	 * for the Framework
	 * @TODO: inclucde automatic the files
	 */
	public function init()
	{
		include_once(plugin_dir_path(__FILE__)."controller/BaseController.php");
		include_once(plugin_dir_path(__FILE__)."view/BaseView.php");		
		include_once(plugin_dir_path(__FILE__)."model/BaseModel.php");
		include_once(plugin_dir_path(__FILE__)."MVCFactory.php");
		include_once(plugin_dir_path(__FILE__)."lib/MvcConfig.php");
		include_once(plugin_dir_path(__FILE__)."lib/FileLoader.php");
		include_once(plugin_dir_path(__FILE__)."lib/Helper/FileHelper.php");
		include_once(plugin_dir_path(__FILE__)."lib/ImportHelper.php");
		include_once(plugin_dir_path(__FILE__)."lib/Helper/ConfigHelper.php");
		include_once(plugin_dir_path(__FILE__)."lib/Helper/DependencyHelper.php");
		include_once(plugin_dir_path(__FILE__)."vendor/Browscap/Browscap.php");
		include_once(plugin_dir_path(__FILE__)."lib/Helper/IncludeHelper.php");
		
		/*
		 * Load Debug Libraries
		 */
		 \RoleManager\Core\Lib\Helper\IncludeHelper::includeFile('\\cBug',plugin_dir_path(__FILE__).'vendor/dBug/cBug.php'); 
		  \RoleManager\Core\Lib\Helper\IncludeHelper::includeFile('\\dBug',plugin_dir_path(__FILE__).'vendor/dBug/dBug.php'); 
		
		add_action('init',array($this,'includeTextdomain'));
		
		/*
		 * TODO: check if the includes and preparation should be called in the constructor
		 * prepare the ConfigArray
		 */ 
		$this->confArrary =  \RoleManager\Core\Lib\Helper\ConfigHelper::prepareConfigArray($this->confArrary);
		
		$fileLoader = \RoleManager\Core\Lib\FileLoader::getInstance($this->confArrary['files']);
		
		add_action('wp_enqueue_scripts',array($fileLoader,'enqueueScripts'));
		add_action('admin_enqueue_scripts',array($fileLoader,'adminEnqueueScripts'));
		add_action('wp_enqueue_scripts',array($fileLoader,'enqueueStyles'));
		add_action('admin_enqueue_scripts',array($fileLoader,'adminEnqueueStyles'));
	}
	/**
	 * include all Location Files
	 * @return boolean
	 */
	public function includeTextdomain()
	{
			/*
			 * Workaround for get Name of the current plugin
			 */
			$pluginDir = plugin_dir_path(__DIR__);
			$matches = array();
			preg_match("!.*\/(.*)\/$!", $pluginDir,$matches);
		 	
		 	load_plugin_textdomain($matches[1],false, $matches[1].'/app/locale/languages/');
		 	
		
	}
}