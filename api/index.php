<?php
/********************************************************************************
// * PHPTRAVELS - Travel Technology Partner                                       *
// * Copyright (c) phptravels.com. All Rights Reserved                          *
// ******************************************************************************
//  * Email: info@phptravels.com                                                *
//  * Website: http://www.phptravels.com/                                       *
// ******************************************************************************
//  * This script is property of PHPTRAVELS you are not allowed to rebuild      *
//  * customize, resell, use on multiple domains, change ownership for your     *
//  * interest, or copy codes from any part of this script, we will take        *
//  * legal action against anyone who broke our terms, respect to get respected *
//  * Thank you.                                                                *
// ******************************************************************************/

// Software Enviroments
define('ENVIRONMENT', 'production');

require "application/vendor/autoload.php";
Sentry\init(['dsn' => 'https://f2d192f459554c9eb1d1965ab4f5f299@o537404.ingest.sentry.io/5655555' ]);

// page loading function
// if (ob_get_level() == 0) ob_start(); include "load.php"; ob_end_clean();

if (!file_exists(".htaccess")) {
echo "<style>body{font-family:calibri;padding:0px;margin:25px}.alert{background:red}.box{height:24px;width:10%;position:relative:display:block}</style>";
echo "The .htaccess file does not exist on main directory of your site.<br>";
echo "If you can't see this file, you can create a new file named \".htaccess\" in the main directory of your site and you can add these codes to inside this file:<br>";
echo "<pre>RewriteEngine On<br>";
echo "<code>RewriteCond %{REQUEST_FILENAME} !-f<br>";
echo "RewriteCond %{REQUEST_FILENAME} !-d<br>";
echo "RewriteRule ^(.*)$ index.php?/$1 [L]</code>";
echo "<br><br><br>";
echo "<strong>If you have SSL installed use this code instead</strong><br><br>";
echo "RewriteEngine on<br>";
echo "DirectoryIndex load.php index.php<br>";
echo "RewriteCond %{HTTPS} !=on<br>";
echo "RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]<br>";
echo "RewriteCond %{REQUEST_FILENAME} !-f<br>";
echo "RewriteCond %{REQUEST_FILENAME} !-d <br>";
echo "RewriteRule ^(.*)$ index.php/$1 [L]<br>";
exit();
}
$php_version = explode('.', phpversion());
if ($php_version[0] < 7) { include_once './assets/fix/php.php'; die(); }

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

$system_path = 'system';
$application_folder = 'application';
$view_folder = '';

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
    // Ensure there's a trailing slash
    $system_path = strtr(
        rtrim($system_path, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir($application_folder)) {
    if (($_temp = realpath($application_folder)) !== FALSE) {
        $application_folder = $_temp;
    } else {
        $application_folder = strtr(
            rtrim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
    }
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
    $application_folder = BASEPATH . strtr(
        trim($application_folder, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    );
} else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// The path to the "views" directory
if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
    if (($_temp = realpath($view_folder)) !== FALSE) {
        $view_folder = $_temp;
    } else {
        $view_folder = strtr(
            rtrim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
    }
} elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . strtr(
        trim($view_folder, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    );
} else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);
require_once BASEPATH . 'core/CodeIgniter.php';