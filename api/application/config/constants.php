<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

    function my_baseURL(){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $tmplt = "%s://%s%s";
            $end = $dir;
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';
        return $base_url;
    }
    $mybaseurl = my_baseURL();

   	define('PT_BASE_URL', $mybaseurl);
   	define('DEFLANG', "en");
    define('EANSLUG', "properties/");
   	define('CHECKIN_SPAN', 0); //SET THE DEFAULT CHECKIN SPAN IF THE CHECK-IN DATE IS NOT SELECTED - 0 means checkin should be from today, 1 means checkin will be from tomorrow and so on
   	define('CHECKOUT_SPAN', 1); //SET THE DEFAULT CHECKOUT SPAN IF THE CHECK-OUT DATE IS NOT SELECTED - 1 means checkout should be from tomorrow, 2 means checkin will be at day after tomorrow and so on
    // Note: CHECKOUT_SPAN should be greater than CHECKIN_SPAN

    define('FILE_READ_MODE', 0644);
    define('FILE_WRITE_MODE', 0666);
    define('DIR_READ_MODE', 0755);
    define('DIR_WRITE_MODE', 0777);

    define('FOPEN_READ',							'rb');
    define('FOPEN_READ_WRITE',						'r+b');
    define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
    define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
    define('FOPEN_WRITE_CREATE',					'ab');
    define('FOPEN_READ_WRITE_CREATE',				'a+b');
    define('FOPEN_WRITE_CREATE_STRICT',				'xb');
    define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

    defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
    defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
    defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
    defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
    defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
    defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
    defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
    defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
    defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
    defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

    /*******My constants*******/
  
    define('UPDATES_ROOT_URL', "http://phptravels.com.co/updates/"); //remote url for updates list
    define('UPDATES_LIST_URL', "http://phptravels.com.co/functions.php"); //remote url for updates list
    define('UPDATES_DETAIL_URL', 'http://phptravels.com.co/detail.php'); //remote url for updates Details

    define('MAX_IMAGE_UPLOAD', 2050); // Maximum size in KB
    define('THUMB_WIDTH', 720);
    define('THUMB_HEIGHT', 480);
    define('PT_RIGHTS', 'PHPTRAVELS');
    define('PT_VERSION', 'v8');
    define('PT_LINK', 'http://phptravels.com');
    define('PT_SHOW', '1');
    define('PT_STARS_ICON', "<i class='fa fa-star'></i>");
    define('PT_EMPTY_STARS_ICON', "<i class='fa fa-star-o'></i>");
    define('PT_BLANK', PT_BASE_URL.'uploads/global/default/blank.jpg');
    define('PT_BLANK_IMG', 'blank.jpg');
    define('PT_DEFAULT_IMAGE', PT_BASE_URL.'uploads/global/default/');
    define('PT_GLOBAL_IMAGES_FOLDER', PT_BASE_URL.'uploads/global/');
    define('PT_GLOBAL_UPLOADS_FOLDER', 'uploads/global/');
    define('PT_USERS_IMAGES', PT_BASE_URL.'uploads/images/users/');
    define('PT_USERS_IMAGES_UPLOAD', 'uploads/images/users/');
    define('PT_SQL_UPLOAD', 'backups/');

    /****** Flag Images ******/
    define('PT_FLAG_IMAGES', PT_BASE_URL.'uploads/images/flags/');
    define('PT_FLAG_IMAGES_UPLOAD', 'uploads/images/flags/');
    /****** End Flag Images ******/

    // Airlines Logos
    define('PT_AIRLINE_LOGOS', PT_BASE_URL.'uploads/global/airlines/');
    // Airlines Logos End

   /****** Language Image ******/
    define('PT_LANGUAGE_IMAGES', PT_BASE_URL.'uploads/images/language/');
   /****** End Language Image ******/

    /*** Social Images ***/
    define('PT_SOCIAL_IMAGES', PT_BASE_URL.'uploads/images/social/');
    define('PT_SOCIAL_IMAGES_UPLOAD', 'uploads/images/social/');
    /*** End Social Images ***/

    /*** Slider Images ***/
    define('PT_SLIDER_IMAGES', PT_BASE_URL.'uploads/images/slider/');
    define('PT_SLIDER_IMAGES_THUMBS', PT_BASE_URL.'uploads/images/slider/thumbs/');
    define('PT_SLIDER_IMAGES_UPLOAD', 'uploads/images/slider/');
    define('PT_SLIDER_IMAGES_UPLOAD_THUMBS', 'uploads/images/slider/thumbs/');
    /*** End Slider Images ***/

    /*** Hotel Images ***/
    define('PT_HOTELS_SLIDER', PT_BASE_URL.'uploads/images/hotels/slider/');
    define('PT_HOTELS_SLIDER_UPLOAD', 'uploads/images/hotels/slider/');
    define('PT_HOTELS_SLIDER_THUMBS', PT_BASE_URL.'uploads/images/hotels/slider/thumbs/');
    define('PT_HOTELS_SLIDER_THUMBS_UPLOAD', 'uploads/images/hotels/slider/thumbs/');

    define('PT_HOTELS_ICONS', PT_BASE_URL.'uploads/images/hotels/amenities/');
    define('PT_HOTELS_ICONS_UPLOAD', 'uploads/images/hotels/amenities/');
    /*** End Hotel Images ***/

    /*** Hotel Videos ***/
    define('PT_HOTELS_VIDEOS', PT_BASE_URL.'uploads/videos/hotels/');
    define('PT_HOTELS_VIDEOS_UPLOAD', 'uploads/videos/hotels/');
    /*** End Hotel Videos ***/

    /*** Room Images ***/
    define('PT_ROOMS_IMAGES', PT_BASE_URL.'uploads/images/hotels/rooms/photos/');
    define('PT_ROOMS_IMAGES_UPLOAD', 'uploads/images/hotels/rooms/photos/');

    define('PT_ROOMS_THUMBS', PT_BASE_URL.'uploads/images/hotels/rooms/thumbs/');
    define('PT_ROOMS_THUMBS_UPLOAD', 'uploads/images/hotels/rooms/thumbs/');
    /*** End Room Images ***/

    /*** Tour Images ***/
    define('PT_TOURS_MAIN_THUMB', PT_BASE_URL.'uploads/images/tours/');
    define('PT_TOURS_MAIN_THUMB_UPLOAD', 'uploads/images/tours/');

    define('PT_TOURS_SLIDER_THUMB', PT_BASE_URL.'uploads/images/tours/slider/thumbs/');
    define('PT_TOURS_SLIDER_THUMB_UPLOAD', 'uploads/images/tours/slider/thumbs/');
    define('PT_TOURS_SLIDER', PT_BASE_URL.'uploads/images/tours/slider/');
    define('PT_TOURS_SLIDER_UPLOAD', 'uploads/images/tours/slider/');

    define('PT_TOURS_ICONS', PT_BASE_URL.'uploads/images/tours/icons/');
    define('PT_TOURS_ICONS_UPLOAD', 'uploads/images/tours/icons/');

    /*** End Tour Images ***/


    /*** Rentals Images ***/
    define('PT_RENTALS_MAIN_THUMB', PT_BASE_URL.'uploads/images/rentals/');
    define('PT_RENTALS_MAIN_THUMB_UPLOAD', 'uploads/images/rentals/');

    define('PT_RENTALS_SLIDER_THUMB', PT_BASE_URL.'uploads/images/rentals/slider/thumbs/');
    define('PT_RENTALS_SLIDER_THUMB_UPLOAD', 'uploads/images/rentals/slider/thumbs/');
    define('PT_RENTALS_SLIDER', PT_BASE_URL.'uploads/images/rentals/slider/');
    define('PT_RENTALS_SLIDER_UPLOAD', 'uploads/images/rentals/slider/');

    define('PT_RENTALS_ICONS', PT_BASE_URL.'uploads/images/rentals/icons/');
    define('PT_RENTALS_ICONS_UPLOAD', 'uploads/images/rentals/icons/');

    /*** End Rentals Images ***/

    /*** Boats Images ***/
    define('PT_BOATS_MAIN_THUMB', PT_BASE_URL.'uploads/images/boats/');
    define('PT_BOATS_MAIN_THUMB_UPLOAD', 'uploads/images/boats/');

    define('PT_BOATS_SLIDER_THUMB', PT_BASE_URL.'uploads/images/boats/slider/thumbs/');
    define('PT_BOATS_SLIDER_THUMB_UPLOAD', 'uploads/images/boats/slider/thumbs/');
    define('PT_BOATS_SLIDER', PT_BASE_URL.'uploads/images/boats/slider/');
    define('PT_BOATS_SLIDER_UPLOAD', 'uploads/images/boats/slider/');

    define('PT_BOATS_ICONS', PT_BASE_URL.'uploads/images/boats/icons/');
    define('PT_BOATS_ICONS_UPLOAD', 'uploads/images/boats/icons/');

    /*** End Boats Images ***/

    /*** Tour Videos ***/
    define('PT_TOURS_VIDEOS', PT_BASE_URL.'uploads/videos/tours/');
    define('PT_TOURS_VIDEOS_UPLOAD', 'uploads/videos/tours/');
    /*** End Tour Videos ***/

     /*** Car Images ***/
    define('PT_CARS_MAIN_THUMB', PT_BASE_URL.'uploads/images/cars/');
    define('PT_CARS_MAIN_THUMB_UPLOAD', 'uploads/images/cars/');

    define('PT_CARS_SLIDER_THUMB', PT_BASE_URL.'uploads/images/cars/slider/thumbs/');
    define('PT_CARS_SLIDER_THUMB_UPLOAD', 'uploads/images/cars/slider/thumbs/');
    define('PT_CARS_SLIDER', PT_BASE_URL.'uploads/images/cars/slider/');
    define('PT_CARS_SLIDER_UPLOAD', 'uploads/images/cars/slider/');
    /*** End Car Images ***/

    /*** extras Images ***/
    define('PT_EXTRAS_IMAGES', PT_BASE_URL.'uploads/images/hotels/extras/');
    define('PT_EXTRAS_IMAGES_UPLOAD', 'uploads/images/hotels/extras/');

    define('PT_TOURS_EXTRAS_IMAGES', PT_BASE_URL.'uploads/images/tours/extras/');
    define('PT_TOURS_EXTRAS_IMAGES_UPLOAD', 'uploads/images/tours/extras/');

    define('PT_RENTALS_EXTRAS_IMAGES', PT_BASE_URL.'uploads/images/rentals/extras/');
    define('PT_RENTALS_EXTRAS_IMAGES_UPLOAD', 'uploads/images/rentals/extras/');

    define('PT_BOATS_EXTRAS_IMAGES', PT_BASE_URL.'uploads/images/boats/extras/');
    define('PT_BOATS_EXTRAS_IMAGES_UPLOAD', 'uploads/images/boats/extras/');


    define('PT_DEFAULT_ADULTS_COUNT', 1);
    define('PT_CARS_EXTRAS_IMAGES', PT_BASE_URL.'uploads/images/cars/extras/');
    define('PT_CARS_EXTRAS_IMAGES_UPLOAD', 'uploads/images/cars/extras/');
    /*** End  extras Images ***/

    /*** Special offer Images ***/
    define('PT_OFFERS_IMAGES', PT_BASE_URL.'uploads/images/offers/');
    define('PT_OFFERS_IMAGES_UPLOAD', 'uploads/images/offers/');
    define('PT_OFFERS_THUMBS', PT_BASE_URL.'uploads/images/offers/thumbs/');
    define('PT_OFFERS_THUMBS_UPLOAD', 'uploads/images/offers/thumbs/');
    /*** Special offer Images  ***/

    /*** Hotel Images ***/
    define('PT_FLIGHTS_SLIDER', PT_BASE_URL.'uploads/images/flights/slider/');
    define('PT_FLIGHTS_SLIDER_UPLOAD', 'uploads/images/flights/slider/');
    define('PT_FLIGHTS_AIRLINES_UPLOAD', 'uploads/images/flights/airlines/');
    define('PT_FLIGHTS_AIRLINES', PT_BASE_URL.'uploads/images/flights/airlines/');

    /*** Things to do Images ***/
    define('PT_THINGS_IMAGES', PT_BASE_URL.'uploads/images/thingstodo/');
    define('PT_THINGS_IMAGES_UPLOAD', 'uploads/images/thingstodo/');
    /*** End  Things to do Images ***/

    /*** Payment Gateways Images ***/
    define('PT_PAYMENT_GATEWAY_IMAGES',  PT_BASE_URL.'uploads/global/Payment-Gateways/');
    /*** End  Payment Gateways Images ***/

    /*** Blog Images ***/
    define('PT_BLOG_IMAGES', PT_BASE_URL.'uploads/images/blog/');
    define('PT_BLOG_IMAGES_UPLOAD', 'uploads/images/blog/');
    /*** End  Blog Images ***/

    define("LOADING_ICON","assets/img/loader.gif'");

    /*** Bootstrap Constants ***/
    define('PT_GOBACK', 'javascript:window.history.back();');
    /*** Bootstrap Constants ***/

    /*** admin page main body ***/
    define('body', 'panel-body');
    /*** page main body ***/

    /*
    |--------------------------------------------------------------------------
    | Admin Views side constants
    |--------------------------------------------------------------------------
    */

    define('NOTIFY','<script type="text/javascript"> $(function(){ $.notify("Changes Saved","info"); }) </script>');
    define('PT_ADD','<span data-toggle="tooltip" data-placement="top" title="Add New" class="btn btn-xs btn-success"><i class="fa fa-plus-square"></i> Add New</span>');
    define('PT_DEL_SELECTED','<span data-toggle="tooltip" data-placement="top" title="Delete Selected" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>');
    define('PT_DIS_SELECTED','<span data-toggle="tooltip" data-placement="top" title="Disable Selected" class="btn btn-xs btn-info"><i class="fa fa-minus-square"></i></span>');
    define('PT_ENA_SELECTED','<span data-toggle="tooltip" data-placement="top" title="Enable Selected" class="btn btn-xs btn-enable"><i class="fa fa-check-square-o"></i></span>');
    define('PT_ADV_SEARCH','<span data-toggle="tooltip" data-placement="top" title="Advance Search" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></span>');
    define('PT_BACK','<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="btn btn-xs btn-warning"><i class="fa fa-share-square-o"></i> Back</a>');
    define('PT_DEL','<span data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</span>');
    define('PT_EDIT','<span data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</span>');
    define('PT_UNFEATURED','<i class="featured-star fa fa-star-o" data-toggle="tooltip" data-placement="right" data-original-title="Not Featured"></i>');
    define('PT_FEATURED','<i class="featured-star fa fa-star" data-toggle="tooltip" data-placement="right" data-original-title="Featured"></i>');
    define('PT_ENABLED','<span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span>');
    define('PT_DISABLED','<span class="times"><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disabled"></i></span>');
    define('LOAD_BG','<div class="matrialprogress"><div class="indeterminate"></div></div>');
    /*******My constants*******/
    /* End of file constants.php */
    /* Location: ./application/config/constants.php */
