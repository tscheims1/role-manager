<?php

namespace RoleManager\App\Controller;

class BackendController extends \RoleManager\Core\Controller\BaseController
{
	protected $name = "Backend";

	/**
	 * Sample IndexAction
	 */
	public function indexAction()
	{
		
	
		$this->view->render('index',array('sample' => 'Sample Text'));
	}
}
?>