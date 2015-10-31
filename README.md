# JqueryFileUpload - CakePHP v 0.1
---
Using the jQueryFileUpload from blueimp in CakePHP 2.5.5

You can find the documentation [here][fileupload]
[fileupload]: https://github.com/blueimp/jQuery-File-Upload

 **100% working with latest version of above plugin.

#### [Demo][]
[Demo]: http://blueimp.github.com/jQuery-File-Upload/


## Quick start
- Download this plugin and move to `app/Plugins/JqueryFileUpload`

- Create a table named `uploads` in your database with the following structure:

<pre>CREATE TABLE uploads (
id int(11) NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL,
size int(11) NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
</pre>

- Include the plugin in your `app/Config/bootstrap.php` file

<pre>CakePlugin::load('JqueryFileUpload');</pre>

Upload from anywhere in your form in your VIEW. For exmaple

	$this->UploadForm->load(array('embeded'=>true, 'extrafields'=>array('alias'=>'Control', 'foreign_key'=>$this->request->data['Control']['id'])));

Specify 'class'=>'jqueryfileupload' in the $this->Form->create() options in your view file to support multiple instances of the embeded form. In independent forms it works with ID "#fileupload" only.

New Features
--------------------
While Model and foreign_key passed in extrafields options it would create separate folders for each of your model/ID. This will help you keep your upload separate and show only the record specific uploads. As, with original plugin it will upload all files to single folder.


