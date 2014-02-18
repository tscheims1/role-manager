<?php

class FileHelperTest extends WP_UnitTestCase
{
	public function setUp()
	{
		Core\Bootstrap::getInstance()->init();
	}
	public function testGetPluginName()
	{
		$this->assertEquals('mvc-base-plugin',Core\Lib\Helper\FileHelper::getPluginName());
	}
	public function testGetPluginBaseDir()
	{
		$this->assertNotContains('core',Core\Lib\Helper\FileHelper::getPluginBaseDir());
		
		
		//Add some more tests
	}
	
}