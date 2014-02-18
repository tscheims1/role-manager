<?php 

class BootstrapTest extends WP_UnitTestCase
{
	public function setUp()
	{
		
	}
	public function testBootstrap()
	{
		/*
		 * Test if the Bootstrap return the right instance
		 */ 
		$this->assertInstanceOf('Core\Bootstrap',Core\Bootstrap::getInstance());
		
		
		
		/*
		 * Test if the Return is not false
		 */
		$this->assertNotSame(false,Core\Bootstrap::getInstance()->init());
	}
	
	
	
}
