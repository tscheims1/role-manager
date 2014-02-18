<?php

/**
 * This Class helps to prepare the Configuration Array
 * After the preparion the configuration array can provide to every necessary class
 * @author James Schüpbach
 * @since 1.1
 */
 
namespace RoleManager\Core\Lib\Helper;
 
class ConfigHelper
{
	/**
	 * This Method prepare the config Array
	 * @param array
	 * @return array
	 */
	public static function prepareConfigArray($configArray)
	{
		$configArray = self::prepareFileConfig($configArray);
		return $configArray;
	} 
	
	/**
	 * This Method preprare the File specific part of the config array
	 * @param array
	 * @return array
	 */
	private static function prepareFileConfig($configArray)
	{
		if(!isset($configArray['files']))
			$configArray['files'] = array();
		return $configArray;
	}
}
?>