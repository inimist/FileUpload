<?php
class HandlerController extends JqueryFileUploadAppController {

	public $uses = array('JqueryFileUpload.Upload');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow("*");
		
	}

	public function index()
	{
		$this->layout = 'none';// nothing

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

    //$this->request->allowMethod('OPTIONS', 'HEAD', 'GET', 'POST', 'PUT', 'DELETE');

    /*$fp = fopen(WWW_ROOT . 'data.txt', 'a+');
    fwrite($fp, $this->Upload->get_server_var('REQUEST_METHOD'));
    fwrite($fp, print_r($_REQUEST, 1));
    fclose($fp);*/

		switch ($this->Upload->get_server_var('REQUEST_METHOD')) {
        case 'OPTIONS':
        case 'HEAD':
            $this->Upload->head();
            break;
        case 'GET':
            $this->Upload->get($this->Upload->options['print_response']);
            break;
        case 'PATCH':
        case 'PUT':
        case 'POST':
            $this->Upload->post($this->Upload->options['print_response']);
            break;
        case 'DELETE':
            $this->Upload->delete($this->Upload->options['print_response']);
            break;
        default:
            $this->Upload->header('HTTP/1.1 405 Method Not Allowed');
    }
    exit;
	}
}