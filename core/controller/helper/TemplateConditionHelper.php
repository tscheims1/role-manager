<?php

/**
 * @author James Schüpbach
 * @version 1.1
 */
 
 namespace RoleManager\Core\Controller\Helper;
 /**
  *This Class helps to check the condition if a Template should be inclucuded or not
  */
 class TemplateCondtionHelper
 {
 	
	/**
	 * check if the Templatecondition is true
	 * @param array
	 * @return boolean
	 */
 	public static function isConditionTrue($conditions)
	{
	 		if(is_array($conditions))
		{
			foreach($conditions as $key => $condition)
			{
				if(function_exists($key))
				{
					if(isset($condition['param']))
					{
						if(isset($condition['condition']))
						{
							if($key($condition['param']) != $condition['condition'])
								return false;
							
						}
						else
						{
							throw new \Exception("Condition of the Conditional Tag ".$key." is missed");	
						}
					}
					else 
					{
						if(isset($condition['condition']))
						{
							if($key() != $condition['condition'])
								return false;
						}
						else
						{
							throw new \Exception("Condition of the Conditional Tag ".$key." is missed");	
						}
					}
				}
				else
				{
					throw new \Exception("Worpress Conditionalfunction dosen't exist");
				}
			}
		}
		return true;
	}
 }