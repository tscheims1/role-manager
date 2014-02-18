<?php

class MvcFctoryTest extends WP_UnitTestCase
{
	public function setUp()
	{
		Core\Bootstrap::getInstance()->init();
	}
	/**
	 * @expectedException Exception
	 */
	public function testFactorizeControllersFail()
	{
		$instance = Core\MvcFactory::factory('invalidClass');
		
	}
	/**
	 * @expectedException Exception
	 */
	public function testFactorizeControllersFail2()
	{
		$instance = Core\MvcFactory::factory('');
		
	}
	public function testFactorizeControllers()
	{
		$instance = Core\MvcFactory::factory('Example');
		
	}
	/**
	 * @expectedException Exception
	 * @expectedMessage Invalid Class Name
	 */
	public function testInvalidClassName()
	{
		$instance = Core\MvcFactory::factory('../../test');
		
	}
	
	
}