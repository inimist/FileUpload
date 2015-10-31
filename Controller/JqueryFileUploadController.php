<?php
class JqueryFileUploadController extends JqueryFileUploadAppController {

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow("*");
	}

	public function index()
	{
		
	}
}

?>