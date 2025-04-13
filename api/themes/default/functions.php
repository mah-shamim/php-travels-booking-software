<?php
    //Wish list global function for all modules
    if (!function_exists('wishListInfo')) {
      function wishListInfo($module, $id) {
        $inwishlist = pt_isInWishList($module, $id);
        if ($inwishlist) {
          $html = '<div title="' . trans('028') . '" data-toggle="tooltip" data-placement="left" id="' . $id . '" data-module="' . $module . '" class="wishlist wishlistcheck ' . $module . 'wishtext' . $id . ' fav"><a  class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"><span class="' . $module . 'wishsign' . $id . ' fav">-</span></a></div>';
        }
        else {
          $html = '<div  title="' . trans('029') . '" data-toggle="tooltip" data-placement="left" id="' . $id . '" data-module="' . $module . '" class="wishlist wishlistcheck ' . $module . 'wishtext' . $id . '"><a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"><span class="' . $module . 'wishsign' . $id . '">+</span></a></div>';
        }
        return $html;
      }
    }

    //Tours locations part on home page    iconspane-lg -41
    if (!function_exists('toursWithLocations')) {
      function toursWithLocations() {
        $appObj = appObj();
        $toursLib = $appObj->load->library('Tours/Tours_lib');
        $totalLocations = 7;
        $locationData = $toursLib->toursByLocations($totalLocations);
        return $locationData;
      }
    }

    //Tours locations part on home page
    if (!function_exists('searchForm'))
    {
        function searchForm($module = "hotels", $data = NULL)
        {
            $appObj = appObj();
            $themeData = (object) $appObj->theme->_data;
            //$themeData->checkin = date($themeData->app_settings[0]->date_f,strtotime('+'.CHECKIN_SPAN.' day', time()));
            $themeData->checkinMonth = strtoupper(date("F", convert_to_unix($themeData->checkin)));
            $themeData->checkinDay = date("d", convert_to_unix($themeData->checkin));
            //$themeData->checkout = date($themeData->app_settings[0]->date_f, strtotime('+'.CHECKOUT_SPAN.' day', time()));
            $themeData->checkoutMonth = strtoupper(date("F", convert_to_unix($themeData->checkout)));
            $themeData->checkoutDay = date("d", convert_to_unix($themeData->checkout));
            $themeData->eancheckin = date("m/d/Y", convert_to_unix($themeData->eancheckin, "m/d/Y"));
            $themeData->eancheckout = date("m/d/Y", convert_to_unix($themeData->eancheckout, "m/d/Y"));
            $themeData->eancheckinMonth = strtoupper(date("F", convert_to_unix($themeData->eancheckin, "m/d/Y")));
            $themeData->eancheckinDay = date("d", convert_to_unix($themeData->eancheckin, "m/d/Y"));
            $themeData->eancheckoutMonth = strtoupper(date("F", convert_to_unix($themeData->eancheckout, "m/d/Y")));
            $themeData->eancheckoutDay = date("d", convert_to_unix($themeData->eancheckout, "m/d/Y"));
            $themeData->ctcheckin = date("m/d/Y", strtotime("+1 days"));
            $themeData->ctcheckout = date("m/d/Y", strtotime("+2 days"));
            $tourType = @ $_GET['type'];

            if (isModuleActive($module))
            {
               // ** Hotels ** //
               if ($module == "hotels") {  $search = $data; require $themeurl.'views/modules/hotels/search.php'; }
               if ($module == "ean") { require $themeurl.'views/modules/hotels/expedia/search.php'; }
               if ($module == "Juniper") { $juniper_data = $data; include 'views/modules/juniper/main_search.php'; }
               if ($module == "hotelbeds") { include 'views/modules/hotelbeds/main_search.php'; }
               if ($module == "Travelport_hotels") { include 'views/modules/travelport/hotel/search_form.php'; }
               if ($module == "TravelhopeHotels") { include 'views/modules/hotels/search.php'; }

               // ** Flights ** //
               if ($module == "flights") { require $themeurl.'views/modules/flights/standard/search.php'; }
               if ($module == "Amadeus") {
                   $search = $data; include 'views/modules/flights/search.php';
               }
               if ($module == "TravelPayoutsFlightsAPI") { $search = $data; require $themeurl.'views/modules/flights/search.php'; }
               if ($module == "wegoflights") { $url = $data; require $themeurl.'views/modules/flights/wegoflights/search.php'; }
               if ($module == "TravelhopeFlights") { $route ="travelhope"; $searchForm = $data; include 'views/modules/flights/search.php'; }
               if ($module == "travelport_flight") { $travelportSearchFormData = $data; include 'views/modules/travelport/flight/search_form.php'; }
               if ($module == "FlightTarco") { $search = $data; include 'views/modules/tarco_flight/search_form.php'; }
               if ($module == "iati_flight") { $iatiSearchFormData = $data; include 'views/modules/iati_flight/search_form.php'; }
               if ($module == "Sabre") { $searchForm = $data; include 'views/modules/sabre/main_search.php'; }

               // ** Tours ** //
               if ($module == "tours") {$toursearch = $data; require $themeurl.'views/modules/tours/standard/search.php'; }
               if ($module == "Viator") {$toursearch = $data; require $themeurl.'views/modules/tours/viator/search.php'; }

               // ** Rentals ** //
                if ($module == "rentals") { $rentalssearch = $data; require $themeurl.'views/modules/rentals/search.php'; }

                // ** Boats ** //
                if ($module == "boats") { $boatssearch = $data; require $themeurl.'views/modules/boats/search.php'; }

               // ** Cars ** //
               if ($module == "cars") { require $themeurl.'views/modules/cars/standard/search.php'; }
               if ($module == "cartrawler") { include 'views/modules/cars/cartrawler/search.php'; }
               if ($module == "Kiwitaxi") { $searchForm = $data; include 'views/modules/cars/kiwitaxi/search.php'; }
               if ($module == "Iwaystransfer") { $searchForm = $data; include 'views/modules/cars/iwaystransfer/search.php'; }

               // ** Visa ** //
               if ($module == "ivisa") { $search = $data; include 'views/modules/visa/search.php'; }
            }
        }
    }
    if (!function_exists('Search_Form'))
    {
        function Search_Form($module , $folder_name)
            {
            $ci = get_instance();
            $ci->load->model($module."/".ucfirst($folder_name).'SearchModel');
            $search = unserialize($ci->session->userdata(strtolower($module)));
            if(empty($search))
            {
                if($folder_name == "hotels")
                {
                    $search = new HotelsSearchModel();
                }else{
                    $search = new FlightsSearchModel();
                }
            }
            require "views/modules/$folder_name/search.php";

        }
    }
?>