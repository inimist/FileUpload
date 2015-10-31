/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload, .jqueryfileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        xhrFields: extraparams(),
        url: '/jquery_file_upload/handler'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload, .jqueryfileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload, .jqueryfileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload, .jqueryfileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload, .jqueryfileupload').addClass('fileupload-processing');
        //onsole.log($('#fileupload').fileupload('option', 'url'));

        

        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload, .jqueryfileupload').fileupload('option', 'url'),
            data: extraparams(),
            dataType: 'json',
            context: $('#fileupload, .jqueryfileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
    }

});

function extraparams()  {
  var extravars = []; var extraparams = '';
  if($('#fileupload input.extrafields, .jqueryfileupload input.extrafields').length>0) {
    $('#fileupload input.extrafields, .jqueryfileupload input.extrafields').each(function(n, o)  {
      extravars.push($(o).attr('name') + '=' + $(o).val());
    })
    extraparams = extravars.join('&');
  }
  return extraparams;
}
