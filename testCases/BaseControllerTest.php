<?php

class BaseControllerTest extends WP_UnitTestCase
{
	public function setUp()
	{
			Core\Bootstrap::getInstance()->init();
	}
	public function testConstruct()
	{
		//$instance = new Core\Controller\BaseController();
	}
	
}
