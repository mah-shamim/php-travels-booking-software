<?php
require_once '_config.php';
auth_check();

$title = T::bookings;
include "_header.php";

// Split the REQUEST_URI into an array of strings using the forward slash (/) character as the separator
$uri = explode('/', $_SERVER['REQUEST_URI']);

// Check if the HTTP_HOST value matches the string "localhost"
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Set the root variable to the concatenation of the protocol (http or https), the current HTTP_HOST value, and the first component of the REQUEST_URI array
    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/' . $uri[1];
} else {
    // Set the root variable to the concatenation of the protocol (http or https) and the current HTTP_HOST value
    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
}

if(!empty($_GET['booking_edit']) && $_GET['booking_edit'] == "edit"){
    include_once "booking_update.php";
    die;
}
function compareByTimeStamp($time1, $time2)
{
    if (strtotime($time1['booking_date']) < strtotime($time2['booking_date']))
        return 1;
    else if (strtotime($time1['booking_date']) > strtotime($time2['booking_date']))
        return -1;
    else
        return 0;
}
?>

    <div class="page_head">
        <div class="panel-heading">
            <div class="float-start">
                <p class="m-0 page_title"><?=T::bookings?></p>
            </div>
            <div class="float-end">
                <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
            </div>
        </div>
    </div>

    <div class="mt-1">

    <div class="p-3">


        <div class="card p-3 mb-2">

            <form class="row g-2" id="search">

                <div class="col-md-2">
                    <div class="form-floating">
                        <input class="form-control booking_id" type="text" name="booking_id" value="<?=$_GET['booking_id'] ?? ''?>">
                        <label for=""><?=T::booking?> ID</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-floating">
                        <select id="search_type" name="module" class="form-select module">
                            <option value="">select type</option>
                            <option value="hotels" <?= ($_GET['module'] ?? '') === "hotels" ? "selected" : "";?> ><?=T::hotels?></option>
                            <option value="flights" <?= ($_GET['module'] ?? '') === "flights" ? "selected" : "";?> ><?=T::flights?></option>
                            <option value="tours" <?= ($_GET['module'] ?? '') === "tours" ? "selected" : "";?> ><?=T::tours?></option>
                            <option value="cars" <?= ($_GET['module'] ?? '') === "cars" ? "selected" : "";?>><?=T::cars?></option>
                        </select>
                        <label for=""><?=T::module?></label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-floating">
                        <select id="search_type" name="booking_status" class="form-select booking_status">
                            <option value="">select type</option>
                            <option value="pending" <?= ($_GET['booking_status'] ?? '') === "pending" ? "selected" : "";?>><?=T::pending?></option>
                            <option value="confirmed" <?= ($_GET['booking_status'] ?? '') === "confirmed" ? "selected" : "";?>><?=T::confirmed?></option>
                            <option value="cancelled" <?= ($_GET['booking_status'] ?? '') === "cancelled" ? "selected" : "";?>><?=T::cancelled?></option>
                        </select>
                        <label for=""><?=T::booking?> <?=T::status?></label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-floating">
                        <select id="search_type" name="payment_status" class="form-select payment_status">
                            <option value="">select type</option>
                            <option value="paid" <?= ($_GET['payment_status'] ?? '') === "paid" ? "selected" : "";?>><?=T::paid?></option>
                            <option value="unpaid" <?= ($_GET['payment_status'] ?? '') === "unpaid" ? "selected" : "";?>><?=T::unpaid?></option>
                            <option value="refunded" <?= ($_GET['payment_status'] ?? '') === "refunded" ? "selected" : "";?>><?=T::refunded?></option>
                        </select>
                        <label for=""><?=T::payment?> <?=T::status?></label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-floating">
                        <input class="form-control booking_date calendar" type="text" name="" value="<?=$_GET['booking_date'] ?? ''?>">
                        <label for=""><?=T::booking?> <?=T::date?></label>
                    </div>

                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 h-100 rounded-4" style="border-radius: 8px !important;"><?=T::search?></button>
                </div>

            </form>
        </div>

        <script>
            $("#search").submit(function() {
                event.preventDefault()

                 var booking_id = $(".booking_id").val();
                 var module = $(".module").val();
                 var booking_status = $(".booking_status").val();
                 var payment_status = $(".payment_status").val();
                 var booking_date = $(".booking_date").val();

                window.location.href = "<?=$root?>/admin/bookings.php?booking_id="+booking_id+"&module="+module+"&booking_status="+booking_status+"&payment_status="+payment_status+"&booking_date="+booking_date;

            });
        </script>
        <?php
        // Query for the Hotel table
        $hotel_data = $db->select("hotels_bookings", "*");
        $flight_data = $db->select("flights_bookings", "*");
        $cars_data = $db->select("cars_bookings", "*");
        $tours_data = $db->select("tours_bookings", "*");
        $data = array_merge($hotel_data,$flight_data,$tours_data,$cars_data);
        $is_search=false;

        if(isset($_GET['booking_id']) || isset($_GET['module']) || isset($_GET['booking_status']) || isset($_GET['payment_status']) || isset($_GET['booking_date'])){
            if(!empty($_GET['booking_date'])){
                $date = date('Y-m-d',strtotime($_GET['booking_date']));
            }else{
                $date = '';
            }
            $parm = [
                  'booking_ref_no[~]' => $_GET['booking_id'] ?? '',
                  'module_type[~]' => $_GET['module'] ?? '',
                  'booking_status[~]' => $_GET['booking_status'] ?? '',
                  'booking_date[~]' => $date,
            ];
            if(empty( $_GET['payment_status'])){
                $parm['payment_status[~]'] = $_GET['payment_status'] ?? '';
            }else{
                $parm['payment_status'] = $_GET['payment_status'] ?? '';
            }

            $hotel_data = $db->select("hotels_bookings", "*",$parm);
            $flight_data = $db->select("flights_bookings", "*",$parm);
            $cars_data = $db->select("cars_bookings", "*",$parm);
            $tours_data = $db->select("tours_bookings", "*",$parm);
            $data =  array_merge($hotel_data,$flight_data,$tours_data,$cars_data);
            $is_search=true;
        }

        $itemsPerPage = $is_search ? count($data) : 25;
        $totalItems = count($data);
        $totalPages = count($data) >0 ? ceil($totalItems / $itemsPerPage) : 1;
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $startIndex = ($currentPage - 1) * $itemsPerPage;
        $paginatedArray = array_slice($data, $startIndex, $itemsPerPage);
        usort($paginatedArray, "compareByTimeStamp");

        foreach ($paginatedArray as $key=>$value){
        $userdata = json_decode($value['user_data']);
        ?>

        <div>
            <figure class="border p-3 card" style="border-left: 5px solid #0d6efd !important;border-radius:0 !important">
                <blockquote class="blockquote">
                    <p class="d-flex gap-5 justify-content-between">
                        <span> <?=T::booking?> ID <br /> <strong><?=$value['booking_ref_no']?></strong></span>
                        <span> <?=T::booking?> <?=T::date?>  <br /> <strong><?=date("d-m-Y",strtotime($value['booking_date']))?></strong></span>
                        <span> <?=T::module?>  <br /> <strong><?=$value['supplier']?></strong></span>
                        <span> <?=T::guest_booking?>  <br /> <strong><?=$userdata->first_name ." ". $userdata->last_name?></strong></span>
                        <span> <?=T::email?>  <br /> <strong><?=$userdata->email?></strong></span>
                        <span><?=T::booking?> <?=T::status?> <br /> <strong class="rounded-2 status_btn btn btn-outline-danger p-2" style="min-width:100px"><?=$value['booking_status']?></strong></span>
                        <span><?=T::payment?> <?=T::status?> <br /> <strong class="text-dark rounded-2 status_btn btn btn-warning p-2" style="min-width:100px"><?=$value['payment_status']?></strong></span>
                        <span> <?=T::total?> <br /> <strong> <?=$value['currency_markup']." ".$value['price_markup']?></strong></span>
                    </p>
                </blockquote>

                <blockquote class="blockquote border-top my-1 py-3 pb-0" style="border-top: 1px solid #e4e4e4!important">

                    <div class="d-flex gap-5 justify-content-between">

                        <p class="d-flex gap-5 justify-content-start mb-0">
                            <?php if($value['module_type'] == 'hotels'){?>
                                <span> <?=T::hotels_checkin?> <br /> <strong><?=$value['checkin']?></strong></span>
                                <span> <?=T::hotels_checkout?> <br /> <strong><?=$value['checkout']?></strong></span>
                                <span> <?=T::listing?> <br /> <strong><?=$value['hotel_name']?></strong></span>
                            <?php } ?>

                            <?php if($value['module_type'] == 'flights'){?>
                                <span> <?=T::flights_departuredate?> <br /> <strong><?=$value['checkin'];?></strong></span>
                                <span> <?=T::flights_arrivaldate?> <br /> <strong><?=$value['checkout'];?></strong></span>
                            <?php } ?>
                        </p>
                        <?php if($value['module_type'] == 'flights'){
                            if($value['pnr'] == 'Your booking on Hold'){
                                $payload = [
                                    'booking_ref_no' => $value['booking_ref_no'],
                                    'booking_status' => $value['booking_status'],
                                    'payment_status' => $value['payment_status'],
                                    'payment_date' => $value['payment_date'],
                                    'currency' => $value['currency_original'],
                                    'price' => $value['price_original'],
                                    'desc' => 'Invoice ID'. $value['booking_ref_no'],
                                    'client_email' => (json_decode($value['user_data'])->email),
                                    'invoice_url' => $root."/flights/invoice/".$value['booking_ref_no'],
                                    'type' => 'invoice',
                                    'user_id' => $value['user_id'],
                                    'module_type' => $value['module_type'],
                                ];
                                $rand =date('Ymdhis').rand();
                                $_SESSION['bookingkey'] = $rand;
                                $success_url = ($root).'/payment/success/?token='.base64_encode(json_encode($payload))."&key=".$rand."&type=1";
                                ?>
                                <span> <button class="generate--prn btn btn-info">Generate PRN</button></span>
                                <script>
                                    document.querySelector(".generate--prn").addEventListener('click', function() {
                                        (confirm("Do You want to Generate PRN") === true) && (
                                            location.replace("<?=$success_url?>")
                                        );
                                    });
                                </script>
                            <?php } } ?>
                        <span>
                            <a href="<?=$root."/admin/bookings.php?booking_edit=edit&booking=".$value['booking_ref_no']."&module=".$value['module_type']?>" class="btn btn-info"><?=T::edit?>  <?=T::booking?> </a>
                            <a href="<?=$root."/".$value['module_type']."/invoice/".$value['booking_ref_no']?>" target="_blank" class="btn btn-info"><?=T::booking?> <?=T::details?></a>
                        </span>

                    </div>

                </blockquote>

            </figure>
            <?php }

            ?>
            <nav aria-label="">
                <ul class="pagination justify-content-start">

                    <?php
                    if(count($paginatedArray) != 0) {
                        for ($page = 1; $page <= $totalPages; $page++) {
                            echo '<li class="page-item">';

                            if ($page == $currentPage) {
                                echo '<a class="page-link active" href="#"><strong>' . $page . '</strong></a>';
                            } else {
                                echo '<a class="page-link" href="?all_bookings&page=' . $page . '">' . $page . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
            </nav>

        </div>
    </div>

<?php include "_footer.php" ?>
