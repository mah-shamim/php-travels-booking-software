<?php 
$filesArray = array("index.html","index.htm","home.html","home.htm","default.html","default.htm");
foreach($filesArray as $file){
@unlink("../../".$file);	
}

$myfile = fopen("../../index.php", "w");
$txt = "<?php
/********************************************************************************
// * PHPtravels - Travel Business Partner                                       *
// * Copyright (c) phptravels.com. All Rights Reserved                          *
// ******************************************************************************
//  * Email: info@phptravels.com                                                *
//  * Website: http://www.phptravels.com/                                       *
// ******************************************************************************
//  * This script is property of PHPtravels you are not allowed to rebuild      *
//  * customize, resell, use on multiple domains, change ownership for your     *
//  * interest, or copy codes from any part of this script, we will take        *
//  * legal action against anyone who broke our terms, respect to get respected *
//  * Thank you.                                                                *
// ******************************************************************************/


define('ENVIRONMENT', 'production');
if (defined('ENVIRONMENT')) {
  switch (ENVIRONMENT) {
    case 'development' :
      error_reporting(E_ALL);
      break;
    case 'production' :
      error_reporting(0);
      break;
    default :
      exit ('The application environment is not set correctly.');
  }
}
\$system_path = 'application/system';
\$application_folder = 'application';
if (defined('STDIN')) {
  chdir(dirname(__FILE__));
}
if (realpath(\$system_path) !== FALSE) {
  \$system_path = realpath( \$system_path) . '/';
}
\$system_path = rtrim( \$system_path, '/') . '/';
if (!is_dir( \$system_path)) {
  exit (\"Your system folder path does not appear to be set correctly. Please open the following file and correct this: \" . pathinfo(__FILE__, PATHINFO_BASENAME));
}
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('EXT', '.php');
define('BASEPATH', str_replace('\\\', '/', \$system_path));
define('FCPATH', str_replace(SELF, '', __FILE__));
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
if (is_dir(\$application_folder)) {
  define('APPPATH', \$application_folder . '/');
}
else {
  if (!is_dir(BASEPATH . \$application_folder . '/')) {
    exit (\"Your application folder path does not appear to be set correctly. Please open the following file and correct this: \" . SELF);
  }
  define('APPPATH', BASEPATH . \$application_folder . '/');
}
require_once BASEPATH . 'core/CodeIgniter.php';";
fwrite($myfile, $txt);
fclose($myfile);