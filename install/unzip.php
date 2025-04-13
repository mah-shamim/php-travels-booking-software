<?php 

$zip = new ZipArchive;
$res = $zip->open('files.zip');
if ($res === TRUE) {
  $zip->extractTo('../');
  $zip->close();
  echo 'done';
} else {
  echo 'error';
}
