<?php
/**
 * @author James Schüpbach
 * @version 1.1
 */

namespace RoleManager\Core\Model;



/**
 * This is the BaseModel of the MVC Framework
 * It can be used for storing Configurations and Data 
 */
abstract class BaseModel
{
	/**
	 * Object for storing data and configuration
	 * @var array
	 */
	private $data = array();
	
	/**
	 * The Name of the Model
	 * this is required for several Registration filters 
	 * @var string
	 */
	protected $name = "";
	
	
	public function __construct($name = "")
	{
		$this->name = $name;
	}
	/**
	 * Abstract Method for 
	 * - Activate the Plugin
	 * - Deactivate the Plugin
	 * - Unstall the Plugin
	 */
	abstract public function activate();
	abstract public function deactivate();
	abstract public function init();
	static public function uninstall(){}
	
	/**
	 * Magic Method for store the data 
	 * @param string
	 * @param mixed
	 */
	public function __set($index,$value)
	{
		$this->data[$index] = $value;
	}
	
	/**
	 * Magic Method for get the stored data
	 * @param string
	 * @return mixed
	 * @throws Exception if the index dosent exist or is null
	 */
	public function __get($index)
	{
		if(array_key_exists($index,$this->data))
			return $this->data[$index];
		else 
		{
			//throw new \Exception("Data doesn't exist or is null");	
		}
	}
	
	/**
	 * Get Method for the whole data
	 * @return array
	 */
	 public function getData()
	 {
	 	return $this->data;
	 }
	 /**
	  * Add the Plugin to the MCE-Editor
	  * (This Method will be hooked by a Wordpress-Flter)
	  */
	 public function addMcePlugin($plugin_array)
	 {
	 	$path = plugins_url()."/".\RoleManager\Core\Lib\Helper\FileHelper::getPluginName()."/app/public/admin/script/".$this->name."-tinymce.js";
	 	

	 	$plugin_array[strtolower($this->name)] = $path;
		
		//print_r($plugin_array);
		return $plugin_array;
	 }
	 /**
	  * Register a Button in the Mce-Editor
	  * - This Method will be hookey by a WordPress-Filter
	  */
	 public function registerMceButton($buttons)
	 {
	 	$buttons[] = strtolower($this->name."_button");
	 	
  		 return $buttons;
	 }
}