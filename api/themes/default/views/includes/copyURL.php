<script>
function copyToClipboard() {
var textBox = document.getElementById("value");
textBox.select();
document.execCommand("copy");
}
</script>
<textarea name="value" class="form-control input-lg d-none d-md-block btn-copy-input mt-3 mb-2" id="value" cols="5" rows="1" readonly>

<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo $link;
?>
</textarea>
<button onclick="copyToClipboard()" class="btn btn-primary float-right btn-copy d-none d-md-block"><?=lang('0644')?> <i class="fa fa-code"></i></button>
