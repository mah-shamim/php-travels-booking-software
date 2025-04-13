  <script type="text/javascript">
    var apiUrl = '<?= $apiUrl ?>';
    var hotel_id = '<?= $hotel_id ?>';
    hotel_id = (hotel_id != '')?hotel_id:39;
  </script>
  <script src="<?= base_url('assets/room_calender/js/jquery-1.4.2.min.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/dhtmlxscheduler.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_limit.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_collision.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_timeline.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_editors.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_minical.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/ext/dhtmlxscheduler_tooltip.js') ?>"></script>
  <script src="<?= base_url('assets/room_calender/js/scripts.js') ?>"></script>
  <link rel='stylesheet' href="<?= base_url('assets/room_calender/lib/dhtmlxScheduler/dhtmlxscheduler.css') ?>">
  <link rel='stylesheet' href="<?= base_url('assets/room_calender/css/styles.css') ?>">
  <style type="text/css">
    .dhx_matrix_scell img {
        width: 80px;
        height: 48px;
    }
    #search-panel {
        margin: 100px 4px 8px 8px;
    }
    #scheduler_here {
        margin: 50px 8px 8px 0;
    }
    .form-control {
        width: 857px;
    }
    .select2-container {
        position: absolute !important;
        top: 35px;
        left: 235px;
    }
    #scheduler_here {
        position: absolute;
        top: 0px;
    }
    .wrapper {
        width: 100%;
    }
    .search-sidebar {
        overflow: hidden;
    }
    #search-panel {
        position: absolute;
        left: 0px;
        top: 0px;
    }
    #lightboxStatus {
        text-transform: capitalize;
    }
    .dhtmlx-success div {
        color: #3c763d !important;
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
    }
    .social-sidebar {
     display : none !important;
    }
    .main {
    margin-left: 0px !important;
    margin-top: 0px !important;
    }
    .main .container {
    padding : 0px !important;
    }
    .navbar-default {display:none }
    #sidebar {display:none }
    #content {padding:0px !important;}
    .navbar-brand { background: #292929;}
    .navbar-brand:hover { background: #000 !important;}

  </style>

<nav class="navbar navbar-inverse" style="margin-top:-45px">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url('admin/hotels') ?>"><i class="fa fa-chevron-left"></i> &nbsp;Back</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="javascript:void(0)">Refresh Timer : <strong><span id="countdown_timer"></span></strong></a></li>
            <li><a href="javascript:void(0)" id="headerHotelTitle"><?= $hotel_title ?></a></li>
        </ul>
    </div>
</nav>

<div id="wrapper">
    <div id="search-panel" style="display: none;">
        <form>
            <div class="search_form">
                    <div class="controls">
                        <fieldset class="type_filter">
                            <legend>Type:</legend>
                            <div id="type-options"></div>
                        </fieldset>
                        <fieldset class="price_filter">
                        <legend>Price:</legend>
                            <div id="price-options"></div>
                        </fieldset>

                        <div class="pick_up_filter">
                            <span class="search_title">Pick Up Date:</span>
                            <div class="date_time_selector">
                                <img src="<?= base_url('assets/room_calender/content/calendar.svg') ?>" class="date_calendar" id="minicalIconTo"
                                    onclick="show_minical(this, 'dateFrom')"/>
                                <input id="dateFrom" name="dateFrom" type="text" value="" placeholder="22/05/2017"
                                    onclick="show_minical(this, 'dateFrom')"/>
                                <div class="select">
                                    <select id="timeFrom" name="timeFrom" onchange="updateSections()"></select>
                                    <span class="select_layout"></span>
                                </div>
                            </div>
                        </div>
                        <div class="drop_off_filter">
                            <span class="search_title">Drop Off Date:</span>
                            <div class="date_time_selector">
                                <img src="<?= base_url('assets/room_calender/content/calendar.svg') ?>" class="date_calendar" id="minicalIconFrom" onclick="show_minical(this, 'dateTo')"/>
                                <input id="dateTo" name="dateTo" type="text" value="" placeholder="24/05/2017"
                                    onclick="show_minical(this, 'dateTo')"/>
                                <div class="select">
                                    <select id="timeTo" name="timeTo" onchange="updateSections()"></select>
                                    <span class="select_layout"></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="check_dates">
                            <label>
                                <div class="checkbox">
                                    <input checked="checked" data-val="true" data-val-required="The Boolean field is required." id="dateFilter" name="dateFilter" type="checkbox" value="true" onchange="updateSections()" />
                                    <span class="checkbox_marker"></span>
                                </div>
                            Only available
                            </label>
                        </div>

                    </div>
                </div>
        </form>
    </div>

    <div id="scheduler_here" class="dhx_cal_container">
        <div class="dhx_cal_navline">
            <div class="dhx_nav_container">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
            </div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            <div class="dhx_cal_tab dhx_cal_tab_first" name="week_timeline_tab"></div>
            <div class="dhx_cal_tab" name="two_week_timeline_tab"></div>
            <div class="dhx_cal_tab dhx_cal_tab_last" name="month_timeline_tab"></div>
        </div>
        <div class="dhx_cal_header">
        </div>
        <div class="dhx_cal_data">
        </div>      
    </div>

    <div id="lightbox_form">
        <div class="lightbox_left_section">
            <label>Name</label>
        </div>
        <div class="lightbox_right_section">
            <input id="lightboxName" type="text" class="lightbox_text_field" readonly>
        </div>
        <div class="lightbox_left_section">
            <label>Email</label>
        </div>
        <div class="lightbox_right_section">
            <input id="lightboxEmail" type="text" class="lightbox_text_field" readonly>
        </div>
        <div class="lightbox_left_section">
            <label>Room</label>
        </div>
        <div class="lightbox_right_section">
            <div class="select lightbox_select_field">
                <select id="lightboxCar"></select>
                <span class="select_layout"></span>
            </div>
        </div>
        <div class="lightbox_left_section">
            <label>Status</label>
        </div>
        <div id="lightboxStatus" class="lightbox_right_section">

        </div>
        <div style="display:none">
            <div class="lightbox_left_section">
                <label>Checkin</label>
            </div>
            <div id="lightboxPickUpDate" class="lightbox_right_section lightbox_date_select">
                <img src="<?= base_url('assets/room_calender/content/calendar.svg') ?>" id="lightboxFromIcon" class="date_calendar"/>
                <input id="lightboxFromDate" name="dateFrom" type="text" class="date_text" value="" disabled/>
                <div class="select">
                    <select id="lightboxFromTime" name="timeFrom" disabled></select>
                    <span class="select_layout"></span>
                </div>
            </div>
            <div class="lightbox_left_section">
                <label>Checkout</label>
            </div>
            <div id="lightboxDropOffDate" class="lightbox_right_section lightbox_date_select">
                <img src="<?= base_url('assets/room_calender/content/calendar.svg') ?>" id="lightboxToIcon" class="date_calendar"/>
                <input id="lightboxToDate" name="dateTo" type="text" class="date_text" value="" disabled/>
                <div class="select">
                    <select id="lightboxToTime" name="timeTo" disabled></select>
                    <span class="select_layout"></span>
                </div>
            </div>
        </div>


    <div class="col-md-12">
    <div class="col-md-4">
    <div class="row">
        <button type="button" class="btn btn-danger btn-block" onclick="close_form()">Cancel</button>
    </div>
    </div>

        <div class="col-md-4">
    <div class="row">
     <a class="btn btn-primary btn-block" href="#" id="lightboxHrefInvoice" target="_blank" rel="noopener noreferrer">INVOICE</a>
    </div>
    </div>

        <div class="col-md-4">
    <div class="row">
        <button type="button" onclick="save_form()" class="btn btn-success btn-block">Save</button>
    </div>
    </div>
</div>
    </div>
</div>

<script src="<?= base_url('assets/room_calender/js/mock_backend.js') ?>"></script>
<script type="text/javascript">
    // Get todays date and time
    var now = new Date().getTime() + ((1000 * 60) * 5);
    // Set the date we're counting down to
    var countDownDate = new Date(now).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="countdown_timer"
        // document.getElementById("countdown_timer").innerHTML = minutes + " " + seconds + "";
        document.getElementById("countdown_timer").innerHTML = seconds + "";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown_timer").innerHTML = "Reloading";
            window.location.reload();
        }
    }, 1000);
</script>
