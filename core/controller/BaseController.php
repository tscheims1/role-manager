<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
namespace RoleManager\Core\Controller;




/**
 * This is the Base Class of the Controller
 */
class BaseController
{
	/**
	 * The current Action 
	 * @var string
	 */
	protected $action = "index";
	
	/**
	 * The View is  stored here
	 * @var BaseView
	 */
	protected $view;
	
	
	/**
	 * All Model Configurations are Stored here
	 * @var BaseModel
	 */
	protected $model;
	
	/**
	 * Name of the Plugin
	 * @var string
	 */
	protected  $name;
	
	
	/**
	 * The Condition to render the Template
	 * @var array
	 */
	protected $templateCondtions = null;
	
	/**
	 * Current Template to render
	 * @var string
	 */
	protected $currentTemplate = "";
	
	/**
	 * Constructor:
	 * Instance a View and a Model Object
	 */
	public function __construct($action = null,$view = null,$model = null)
	{
		/*
		 * Add a Shortcode for this Controller
		 */
		add_shortcode($this->name, array($this,'loadContent'));
		
		/*
		 * Initialize the View
		 */
		 if(is_subclass_of($view, '\RoleManager\Core\View\BaseView'))
		 {
		 	$this->view =  $view; 
		 }
		 else
		 {
		 	$this->view = new \RoleManager\Core\View\BaseView();
		 }
		
		/*
		 * Initialize the Model
		 */
		 if(is_subclass_of($model,'\RoleManager\Core\Model\BaseModel'))
		 {
		 	$this->model = $model;
			
			/*
			 * Register the Plugin Hooks for activating, deactivating und uninstalling
			 */
			 $baseFile = \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir().\RoleManager\Core\Lib\Helper\FileHelper::getPluginName().".php";			
			 register_activation_hook($baseFile,array($this->model,'activate'));
			 register_deactivation_hook($baseFile,array($this->model,'deactivate'));
			 register_uninstall_hook($baseFile, get_class($this->model).'::uninstall');
			 add_action('init',array($this->model,'init'));
			 
			 //Register Controller Plugin Hook for the INIT -Proccess
			 add_action('init',array($this,'init'));
			 
		 }
		 else
		 {
			throw new \Exception("Can't instantiate the Model Class");
		 }
		 
		 /*
		  * Set the current Action
		  */ 
		 if($action !== null)
		 	$this->acton = $action;

	}
	/**
	 * this Method will be hooked by the WP-Init-Action 
	 */
	public function init()
	{
		/*
		 * Add the Filters for the Tiny MCE shortcode button
		 */ 
		add_filter('mce_external_plugins',array($this->model,'addMcePlugin'));
		add_filter('mce_buttons',array($this->model,'registerMceButton'));
	}
	
	
	/**
	 * This Method will be invoked from a Shortcode call
	 * @param array
	 * @param string
	 * @param string
	 */
	public function loadContent($attr, $content = null,$tags = null)
	{
		
		if(isset($attr['action']))
			$this->action = $attr['action'];
		
		return $this->callAction();
	}
	
	/**
	 * This Method Call an Action
	 * @param string
	 * @throws Exception
	 */
	protected function callAction($action = null)
	{
		
		 $action = $this->action.'Action';
		 if(is_callable(array($this,$action)))
		 {
		 	return $this->$action();
		 }
		 else
		 	throw new \Exception("Action dosen't exist");
	}
	/**
	 * This Method Bind an Action to a Wordpress Action Hook (add_action function)
	 * @param string
	 * @param string
	 * @param int 
	 * @throws Exception if the Action Method dosen't exist
	 */
	public function bindAction($action,$wordpressAction,$priority =10)
	{
		if(is_callable(array($this,$action."Action")))
			add_action($wordpressAction,array($this,$action."Action"),$priority);
		else
			throw new \Exception("Action dosen't exist");
	}
	/**
	 * This Method Bind a filter to a WordPress Function 
	 * @param string
	 * @param sring
	 * @param int
	 * @throws Exception if the Action Method dosent exist
	 */
	 public function addFilter($action,$wordpressAction,$priority = 10)
	 {
	 	if(is_callable(array($this,$action."Action")))
			add_filter($wordpressAction,array($this,$action."Action"),$priority);
		else
			throw new \Exception("Action dosen't exist");
	 }
	
	/**
	 * This Method register a Template by the WP-Include_Template Hook if the
	 * Condtions are true
	 * Structure of the condition
     * array
	 * (
	 *		'wordpressConditionalTag' => 
	 * 			array(
	 * 				'param' => $parameter,
	 * 				'condition'),
	 * 		'wordpressConditionalTag2' => 
	 * 			array(
	 * 				'param' => $parameter,
	 * 				'condition'),
	 * );
	 * Worpress Conditional Tags: http://codex.wordpress.org/Conditional_Tags
	 * @param string
	 * @throws \Exception
	 * @param array
	 */
	public function registerTemplate($template)
	{
		include_once(\RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir()."core/controller/helper/TemplateConditionHelper.php");
		if(\RoleManager\Core\Controller\Helper\TemplateCondtionHelper::isConditionTrue($this->templateCondtions))
		{
			$filename = \RoleManager\Core\Lib\Helper\FileHelper::getPluginBaseDir()."app/view/".$this->name."View/templates/".$this->currentTemplate.".php";
			if(is_readable($filename))
			{
				return $filename;
			}
		}
		return $template;
		
	}
	/**
	 * Dispatch Method for AJAX Calls
	 * @deprecated: Will be Replaced soon
	 */
	public function dispatchAjax()
	{
		$this->action = $_POST['method'];
		
		$this->callAction();
	}
	/**
	 * Getter Method for the Model
	 * @return BaseModel
	 */
	public function getModel()
	{
		return $this->model;
	}
	
	/**
	 * Getter Method for the View
	 * @return BaseView
	 */
	public function getView()
	{
		return $this->view;
	}
} 