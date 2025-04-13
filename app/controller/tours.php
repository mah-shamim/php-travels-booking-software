<?php

use Curl\Curl;

// tours search page
$router->get(tours, function() {

    $title = T::hotels_search_hotels;
    $meta_title = T::hotels_search_hotels;
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/tours/tours.php";
    include layout;

});

// tours listing page
$router->get($session_langcur.tours.'(.*)', function() {
    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 8) { echo ""; }

    $language = $url[0];
    $currency = $url[1];
    $city = $url[3];
    $date = $url[4];
    $adults = $url[5];
    $childs = $url[6];

    // seo and meta tags
    $title = "Tours in " .$city;
    $meta_title = "Tours in " .$city;
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // adding search credentials to session
    $_SESSION['tours_location']=$city;
    $_SESSION['tours_date']=$date;
    $_SESSION['tours_adults']=$adults;
    $_SESSION['tours_childs']=$childs;

    // generate logs
    logs($SearchType = "tours Search");

    // adding search to session
    SEARCH_SESSION($MODULE=T::tours_tours,$CITY=$city);

    $req = new Curl();
     $req->post(api_url . 'api/tour/search?appKey=' . api_key, array(
    'loaction' => $city,
    'start_date' => $date,
    'end_date' => $date,
    // 'c1' => "28fdcf77-82bf-4389-9295-6afdd1828002",
    // 'country' => ""
     ));

    $tours_data = $req->response;
    $nights = 10;
 
    //  dd($tours_data);
    //  die();

    $_SESSION['tours_data'] = $tours_data;

    $body = views."modules/tours/listing.php";
    include layout;
});


// tours details page
$router->get($session_langcur.'tour(.*)', function() {
$url = explode('/', $_GET['url']);
$count = count($url);
if ($count < 8) { echo ""; }

$language = $url[0];
$currency = $url[1];
$city = $url[3];
$tour_name = $url[4];
$tour_id = $url[5];
$date = $url[6];
$adults = $url[7];
$childs = $url[8];

$req = new Curl();
// $req->post(root.'tours.json', array(
// $req->post(api_url . 'api/hotel/book?appKey=' . api_key, array(
$req->post('https://travelapi.co/modules/tours/viator/api/v1/detail', array(
'tour_id' => $tour_id,
'c1' => "28fdcf77-82bf-4389-9295-6afdd1828002"
));

$tour = $req->response;

// dd($tour);

$link = implode(" ",$url);

// seo and meta tags
$title = $tour->name;
$meta_title = $tour->name;
$meta_appname = "";
$meta_desc = strip_tags($tour->desc);
$meta_img = $tour->img[0];;
$meta_url = root.str_replace(' ', '/', $link);
$meta_author = "PHPTRAVELS";
$meta = "1";

logs($SearchType = "tours details");

$body = views."modules/tours/details.php";
include layout;
});

$router->post('tours/booking', function() {
$tour = json_decode(base64_decode($_POST['payload']));

// seo and meta tags
$title = "Booking ". $tour->name;
$meta_title = "Booking ". $tour->name;
$meta_appname = "";
$meta_desc = "";
$meta_img = "";
$meta_url = "";
$meta_author = "PHPTRAVELS";
$meta = "1";

// user session check
if (isset($_SESSION['user_login']) == true) {
$req = new Curl();
$req->post(api_url . 'api/login/get_profile?appKey=' . api_key, array('id' => $_SESSION['user_id'], ));
$profile = json_decode($req->response);
$profile_data = $profile->response;
// dd($profile_data);
} else {}

// dd($_POST);
// dd($tour);

logs($SearchType = "tours booking");

$body = views."modules/tours/booking.php";
include layout;

});

$router->post('tours/book', function() {
$payload = json_decode(base64_decode($_POST['payload']));

function user_id()
{ if (isset($_SESSION['user_login']) == true) {
return $_SESSION['user_id'];} else { return "0";}
} $user_id = user_id();

$travellers = $payload->travellers;
$data = [];
 for ($i = 1; $i <= $travellers; $i++) {
    array_push($data, (object) array(
        'title'=>$_POST["title_".$i],
        'first_name'=>$_POST["firstname_".$i],
        'last_name'=>$_POST["lastname_".$i]
    ));
  }
$guest = json_encode($data);

$req = new Curl();
$req->post(api_url . 'api/tour/book?appKey=' . api_key, array(
'country' => ""
));

echo '
<script>window.open("'.root.'");</script>
<script>window.open("'.$payload->redirect.'");</script>
';

});

