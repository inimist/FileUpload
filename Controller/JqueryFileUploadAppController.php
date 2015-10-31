<?php
class JqueryFileUploadAppController extends AppController {
	public $components = array(
		'JqueryFileUpload.Upload' // By Default your files will be stored in `app/webroot/files` . Check the docs in upload component for options
	);

	public $helpers = array(
		'JqueryFileUpload.UploadForm'
	);
}
?>