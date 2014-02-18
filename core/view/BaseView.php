<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
namespace RoleManager\Core\View;

/**
 * BaseView of the MVC Framework
 * The view include the view-Files and render the content.
 */
class BaseView
{
	/**
	 * Viewdata from the controller
	 * @var array
	 */
	private $data = array();
	
	
	/**
	 * Magic Function to Set the Viewdata
	 */
	public function __set($name,$value)
	{
		$this->data[$name] = $value;
	}
	
	/**
	 * Magic Method for Access to the viewdata
	 * @throws Execption if the index dosen't exist or is null
	 * @param string
	 * @return mixed
	 */
	public function __get($name)
	{
		/**
		 * Check if Variable exists
		 */
		
		if (array_key_exists($name,$this->data))
			return $this->data[$name];
		else {
			throw new \Exception("Data dosen't exist or is null");
		}
	}
	/**
	 * Empty Constructor
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * This method Render the specific view and 
	 * Save the data from the controller for the view-element
	 * @param string
	 * @param array
	 * @throws Exeption if View dosent exists
	 */
	public function render($action,$data = null)
	{
		
		/*
		 * TODO: REGEX Check
		 */
		$viewLocation = new \ReflectionClass(get_called_class());
		$location = $viewLocation->getFileName();
		$name = $viewLocation->getShortName();
	
		
			
		if(file_exists(plugin_dir_path($location).$name."/".$action.".php"))
		{
			
			$this->data = $data;
			
			ob_start();
			$str =  file_get_contents( plugin_dir_path($location).$name."/".$action.".php");
			require_once (plugin_dir_path($location).$name."/".$action.".php");
			$str = ob_get_contents();
			ob_end_clean();
			return $str;
			
		}
		else
		{
			throw new \Exception("View dosen't extist");
		}
	}
}