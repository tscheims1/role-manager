<?php

class ExampleControllerText extends WP_UnitTestCase
{
	public function setUp()
	{
			Core\Bootstrap::getInstance()->init();
	}
	public function testConstruct()
	{
		$instance =  Core\MvcFactory::factory('Example');
		
		$this->assertTrue(is_subclass_of($instance, 'Core\Controller\BaseController'));
		
		$this->assertTrue(is_subclass_of($instance->getModel(), 'Core\Model\BaseModel'));
		$this->assertTrue(is_subclass_of($instance->getView(), 'Core\View\BaseView'));
		
		$this->assertTrue($instance instanceof App\Controller\ExampleController);
		
		$this->assertTrue($instance->getModel() instanceof App\Model\Example);
		
		$this->assertTrue($instance->getView() instanceof App\View\ExampleView);
	}
	
}
