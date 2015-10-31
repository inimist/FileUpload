<?php  
App::uses('AppHelper', 'View/Helper');

/**
* Helper to load the upload form
*
* NOTE: If you want to use it out of this plugin you NEED to include the CSS files in your Application.
* The files are loaded in `app/Plugins/JqueryFileUpload/View/Layouts/default.ctp` starting at line 16
*
*/
class UploadFormHelper extends AppHelper {

   var $helpers = array('Html');

   var $options = array();

   var $embeded = false;

   private function setOptions($options = array()) {
    $this->options = array_merge($this->options, $options);
   }

	/**
	*	Load the form
	* 	@access public
	*	@param String $url url for the data handler
	*   @param Boolean $loadExternal load external JS files needed
	* 	@return void
	*/
	public function load($options = array(),  $url = '/jquery_file_upload/handler', $loadExternal = true)
	{
    
    $this->setOptions($options);

		// Remove the first `/` if it exists.
	    if( $url[0] == '/' )
	    {
	        $url = substr($url, 1);
	    }

		$this->_loadScripts();

		$this->_loadTemplate( $url );

		if( $loadExternal )
		{
			$this->_loadExternalJsFiles();	
		}
		
	}

	/**
	*	Load the scripts needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadScripts()
	{
		echo '<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?\'data-gallery\':\'\'%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields=\'{"withCredentials":true}\'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>';

	}

	/**
	*	Load the entire form structure.
	* 	@access private
	* 	@return void
	*/
	private function _loadTemplate( $url = null )
	{

    $HTML = '';

		$HTML .= '<div class="container">';

    if(isset($this->options['embeded']) && $this->options['embeded'])  {
      $this->embeded = true;
    }
  
    if( !$this->embeded )  {
      $HTML .= '<form id="fileupload" action="'.Router::url('/', true). $url .'" method="POST" enctype="multipart/form-data">';
    }

    if(isset($this->options['extrafields']))  {
      foreach($this->options['extrafields'] as $name=>$value) {
        $HTML .= '<input type="hidden" class="extrafields" name="'.$name.'" value="'.$value.'" />';
      }
    }

    $HTML .= '<div class="row fileupload-buttonbar">
	            <div class="span7">
	                <span class="btn btn-success fileinput-button">
	                    <i class="glyphicon glyphicon-paperclip"></i>
	                    <span>Attach files...</span>
	                    <input type="file" name="files[]" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Start upload</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancel upload</span>
	                </button>
	                <button type="button" class="btn btn-danger delete">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Delete</span>
	                </button>
	                <!-- <input type="checkbox" class="toggle"> -->
	            </div>
	            <div class="span5">
	                <div class="progress progress-success progress-striped active fade">
	                    <div class="bar" style="width:0%;"></div>
	                </div>
	            </div>
	        </div>
	        <div class="fileupload-loading"></div>
	        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>';

    if( !$this->embeded )  {
	    $HTML .= '</form>';
    }

	  $HTML .= '</div>';

   echo $HTML;
	}

	/**
	*	Load external JS files needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadExternalJsFiles()
	{

    $file_upload_root = Router::url('/', true).'jquery_file_upload';

    $source = '';
    //$source = $this->Html->css('/app/webroot/bootstrap/css/bootstrap.min');
    $source .= $this->Html->css($file_upload_root . '/css/style.css');
    $source .= '<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">';
    $source .= '<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->';
    $source .= $this->Html->css($file_upload_root . '/css/jquery.fileupload.css');
    $source .= $this->Html->css($file_upload_root . '/css/jquery.fileupload-ui.css');
    $source .= '<noscript>' . $this->Html->css($file_upload_root . '/css/jquery.fileupload-noscript.css') .'</noscript>';
    $source .= '<noscript>' . $this->Html->css($file_upload_root . '/css/jquery.fileupload-ui-noscript.css') . '</noscript>';

    $source .= $this->Html->script($file_upload_root .'/js/vendor/jquery.ui.widget.js') . "\n";
    $source .= '<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>' . "\n";
    $source .= '<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>' . "\n";
    $source .= '<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>' . "\n";

    $source .= $this->Html->script($file_upload_root .'/js/jquery.iframe-transport.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-process.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-image.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-audio.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-video.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-validate.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/jquery.fileupload-ui.js') . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/main.js') . "\n";
    $source .= '<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 --><!--[if (gte IE 8)&(lt IE 10)]>' . "\n";
    $source .= $this->Html->script($file_upload_root .'/js/cors/jquery.xdr-transport.js') . "\n";
    $source .= '<![endif]-->' . "\n";
    echo $source;
	}
}