<?php
/**
 * @author James Schüpbach
 * @version 1.0
 */
 
 /**
  * This Class sould improve the Plugin Build Proccess.
  * It generate Skeleton Controllers, Views and Models.
  */
class Generator 
{
	const CONTROLLER_CLASS_DIR = "app/controller/";
	const VIEW_CLASS_DIR = "app/view/";
	const MODEL_CLASS_DIR = "app/model/";
	const ADMIN_JS_DIR ="app/public/admin/script/";
	const VIEW_DIR = "app/view/";
	const ACCESS_MODE = 755;
	
	const REPLACE_TOKEN = "%%NAME%%";
	const REPLACE_TOKEN_LOWERCASE = "%%LNAME%%";

	
	const CONTROLLER_SUFIX = "Controller";
	const VIEW_SUFIX = "View";
	const MODEL_SUFIX ="";
	
	/**
	 * This Method generate the Model, Controller and View Skeleton
	 * @param array All Commandline options
	 */
	public static function generateSkeleton($options)
	{
		
		if(!isset($options[0]) || $options[0] != "core/generator/Generator.php")
		{
			echo "You must call the Generator from the Pluginroot directory";
			exit;
		}


		if(!preg_match("!^[A-Z][a-zA-z]+$!",$options[1]))
		{
			echo "Invalid Classname\n";
			exit;
			
		}
			
		self::generateFolders($options[1]); 
		self::renderTemplates($options[1]);
		
		echo "Files successful created\n";
	}
	/**
	 * This Method generate all necessary Folders
	 * @param string
	 */
	private static function generateFolders($name)
	{
	
		if(is_dir(self::VIEW_DIR.$name.self::VIEW_SUFIX))
		{
			echo "Class already exists\n";
			exit;
		}
		mkdir(self::VIEW_DIR.$name.self::VIEW_SUFIX);
		mkdir(self::VIEW_DIR.$name.self::VIEW_SUFIX."/templates");
	}
	
	/**
	 * This Method render the Template File
	 * @param string
	 */
	private static function renderTemplates($name)
	{
		$view = file_get_contents("core/generator/templates/view.tmpl");
		$model = file_get_contents("core/generator/templates/model.tmpl");
		$controller = file_get_contents("core/generator/templates/controller.tmpl");
		$sampleView = file_get_contents("core/generator/templates/sampleView.tmpl");
		$tinyMceJs = file_get_contents("core/generator/templates/tinymce.tmpl");
		
		$view = str_replace(self::REPLACE_TOKEN,$name,$view);
		$model = str_replace(self::REPLACE_TOKEN, $name,$model);
		$controller = str_replace(self::REPLACE_TOKEN,$name,$controller);
		$tinyMceJs = str_replace(self::REPLACE_TOKEN_LOWERCASE, strtolower($name), $tinyMceJs);
		$tinyMceJs = str_replace(self::REPLACE_TOKEN, $name, $tinyMceJs);
		
		
		file_put_contents(self::CONTROLLER_CLASS_DIR.$name.self::CONTROLLER_SUFIX.".php", $controller);
		file_put_contents(self::MODEL_CLASS_DIR.$name.self::MODEL_SUFIX.".php", $model);
		file_put_contents(self::VIEW_CLASS_DIR.$name.self::VIEW_SUFIX.".php", $view);
		file_put_contents(self::VIEW_DIR.$name.self::VIEW_SUFIX."/index.php", $sampleView);	
		file_put_contents(self::ADMIN_JS_DIR.$name."-tinymce.js",$tinyMceJs);
	
	}
	
	
}

Generator::generateSkeleton($argv);