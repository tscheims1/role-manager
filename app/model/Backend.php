<?php

namespace RoleManager\App\Model;

class Backend extends \RoleManager\Core\Model\BaseModel
{
	public function __construct($name = "")
	{
		parent::__construct($name);
	}
	/**
	 * This Method hook the WordPress init Action
	 */
	public function init()
	{
		add_role('geladen','geladen',array('read' => true));
		add_role('ungeladen','ungeladen',array('read' => true));
	}
	/**
	 * This Method will run, when the Plugin is actived
	 */ 
	public function activate()
	{
	}
	/**
	 * This Method will run, when the Plugin is deactived
	 */
	public function deactivate()
	{
	}
	/**
	 * This is the Uninstall Method
	 */
	public static function uninstall()
	{
		/*
		 * The Uninstall Script for the Plugin
		 */
		if(defined('WP_UNINSTALL_PLUGIN'))
		{
	//here you should delete options, tables or anything else.

		}
	}
}
?>