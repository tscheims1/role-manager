<?php
/**
 * This class helps to avoid multiple includes from identical Classes
 * @author James Schüpbach
 * @since 1.1.0
 * @version 1.1.0
 */
 
namespace RoleManager\Core\Lib\Helper; 
 
class IncludeHelper
{
	/**
	 * Include the specific file, if its necessary
	 * @param string
	 * @param string 
	 */
	public static function includeFile($className,$filepath)
	{
		//$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $filename);
		if(!class_exists($className))
		{
			include_once($filepath);
		}
	}
}
 
?>