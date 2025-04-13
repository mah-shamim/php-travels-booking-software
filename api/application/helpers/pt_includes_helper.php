<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('pt_jquery_upload_files'))
{
    function pt_jquery_upload_files()
    {

  ?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/jquery-uploader/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/jquery-uploader/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/jquery-uploader/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/jquery-uploader/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/jquery-uploader/css/jquery.fileupload-ui-noscript.css"></noscript>




<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/load-image.min.js"></script>
<!-- blueimp Gallery script -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.blueimp-gallery.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload-image.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload-video.js"></script>

<!-- The File Upload validation plugin -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo base_url(); ?>assets/include/jquery-uploader/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

<?php

 }
}