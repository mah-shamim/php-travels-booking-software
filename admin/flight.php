<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::listings;
include "_header.php";

if(isset($_POST['listing_id'])) { 

if(isset($_POST['featured'])){ $featured = 1; } else { $featured = 0; }
if(isset($_POST['status'])){ $status = 1; } else { $status = 0; }
if(isset($_POST['refundable'])){ $refundable = 1; } else { $refundable = 0; }

$id=(DECODE($_POST['listing_id']));
$params = array( 
    "refundable" => $refundable,
    "status" => $status,
    "featured" => $featured,
    "mapaddress" => $_POST['mapaddress'],
    "latitude" => $_POST['latitude'],
    "longitude" => $_POST['longitude'],
    "currency_id" => $_POST['currency_id'],
    "location_id" => $_POST['location_id'],
    "name" => $_POST['name'],
    "amenities" => json_encode($_POST['amenities']),
    "slug" => $_POST['slug'],
    "desc" => $_POST['desc'],
    "policy" => $_POST['policy'],
    "owned_by" => $_POST['owned_by'],
    "settings_type" => $_POST['settings_type'],
    "stars" => $_POST['stars'],
);
$data = UPDATE('listings',$params,$id);
ALERT_MSG('updated');

// INSERT TO LOGS
$user_id = $USER_SESSION->backend_user_id;    
$log_type = "listing";
$datetime = date("Y-m-d h:i:sa");
$desc = "listing details added - updated";
logs($user_id,$log_type,$datetime,$desc.json_encode($_REQUEST));

REDIRECT('listings.php?all_listings');
}

if(isset($_GET['listing_id'])) {
$params = array("id"=>$_GET['listing_id']);
$data = GET('listings',$params);
if (isset($data[0])){
$listing = $data[0];


// REDIRECT IF LISTING DO NOT BELONG TO USER OR ADMIN CAN VIEW IT ONLY
$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

if (isset($role[0]->type_name)) {
if (strtolower($role[0]->type_name) == "admin") { } else {
    if ($listing->owned_by != $seuser->backend_user_id) { 
        REDIRECT('listings.php?all_listings'); 
    }
}}

} else {
// REDIRECT IF THERE IS NO LISTING
REDIRECT('./listings.php?all_listings');
}

include "listings_manage.php";
include "_footer.php";
exit;
}

if(isset($_GET['listing'])) { 
        
        // DELETE IF FOUND DRAFT DATA
        $listing = $db->query("SELECT * FROM `listings` WHERE `name` LIKE ''")->fetchAll();
        if (isset($listing[0]['id'])){
            $params = array( "id" => $listing[0]['id']);
            $data = DELETE('listings',$params);
        } 

        if ($_GET['listing'] == $_GET['listing'] && $_GET['listing'] != "addnew"){

            $params = array( 
                "name" => "",
                "listing_type" => $_GET['listing'],
            );

            $data = INSERT('listings',$params);
            $listing = $db->query("SELECT * FROM `listings` WHERE `name` LIKE ''")->fetchAll();
            REDIRECT("./listings.php?listing_id=".$listing[0]['id']);

        }
        
}

// GET DATA
if(isset($_GET['listing'])) { 

// GET DATA FROM API
include "listings_manage.php";
include "_footer.php";
exit;
}

// GET DATA
if(isset($_GET['listings_settings'])) { 
include "listings_settings.php";
include "_footer.php";
exit;
}

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
             <p class="m-0 page_title"><?=T::flight?></p>
         </div>
        <div class="float-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#module_type" class="loading_effect btn btn-dark"><?=T::add?></a>
        </div>
    </div>
</div>


<div class="container-fluid">
        <div class="container mt-2">
            <div class="py-3 text-center h4 fw-bolder">Filghts Management</div>
        </div>

        <div class="container">
            
            <!-- heading  -->
            <div class="row m-0 text-bg-dark text-center fw-bold text-uppercase rounded-top-3">
                <div class="col-2">
                    <div class="px-3 py-3">type</div>
                </div>
                <div class="col-3">
                    <div class="px-3 py-3">city - airport</div>
                </div>
                <div class="col-3">
                    <div class="px-3 py-3">airline</div>
                </div>
                <div class="col-2">
                    <div class="px-3 py-3">flight No.</div>
                </div>
                <div class="col-1" style="width: max-content;">
                    <div class="px-3 py-3">flight time</div>
                </div>
            </div>

            <form action="">
                
                <!-- dynamic to add  -->
                <div class="d-none" id="add--more-transit">
                    <div class="alert alert-dismissible row align-items-center border-bottom m-0 px-0 py-3">
            
                        <div class="col-2 test">
                            <div>
                                <input class="form-control form-text w-100 text-muted" disabled type="text" name="" id="" value="Transit">
                            </div>
                        </div>
        
                        <!-- airport  -->
                        <div class="col-3">
                            <div>
                                <select class="form-select" name="depart--airport--val" id="depart--airport">
                                    <option value="">Lahore</option>
                                    <option value="">Sialkot</option>
                                    <option value="">Islamabad</option>
                                </select>
                            </div>
                        </div>
        
                        <!-- airline -->
                        <div class="col-3">
                            <div>
                                <select class="form-select" name="" id="depart--airline">
                                    <option value="">Delta</option>
                                    <option value="">Emirates</option>
                                    <option value="">Gulf Air </option>
                                </select>
                            </div>
                        </div>
        
                        <!-- flight no  -->
                        <div class="col-2">
                            <div>
                                <input class="form-control" type="text" name="depart--flight_no-val" id="" placeholder="Flight No">
                            </div>
                        </div>
        
                        <div class="col-1" style="width: calc((100% / (11)) + 40px );">
                            <div>
                                <input class="form-control" type="time" name="" id="" value="00:00">
                            </div>
                        </div> 
                        
                        <div class="col-1">
                            <button class="btn-close bg-danger py-2 mt-3" data-bs-dismiss="alert" type="button"></button>
                        </div>
                    </div>
                </div>

                <!-- here to add -->
                <div class="main">
                    <!-- 1 -->
                    <div class="row align-items-center border-bottom m-0 py-3">
        
                        <div class="col-2">
                            <div>
                                <input class="form-control form-text w-100 text-muted" disabled type="text" name="" id="" value="Departure">
                            </div>
                            <!-- <div class="bg-white rounded-1 px-3 py-2 text-muted fw-bold disabled" >Departure</div> -->
                        </div>
        
                        <!-- airport  -->
                        <div class="col-3">
                            <div>
                                <!-- <select class="form-select" name="depart--airport-val" id="depart--airport" onchange="hello()"> -->
                                <select class="form-select" name="depart--airport-val" id="depart--airport">
                                    <option value="lahore">Lahore</option>
                                    <option value="sialkot">Sialkot</option>
                                    <option value="islamabad">Islamabad</option>
                                </select>
                            </div>
                        </div>
        
                        <!-- airline -->
                        <div class="col-3">
                            <div>
                                <select class="form-select" name="depart--airline-val" id="depart--airline">
                                    <option value="elta">Delta</option>
                                    <option value="emirates">Emirates</option>
                                    <option value="gulf air">Gulf Air</option>
                                </select>
                            </div>
                        </div>
        
                        <!-- flight no  -->
                        <div class="col-2">
                            <div>
                                <input class="form-control" type="text" name="depart--flight_no-val" id="depart--flight_no" placeholder="Flight No">
                            </div>
                        </div>

                        <!-- time -->
                        <div class="col-1" style="width: calc((100% / (11)) + 40px );">
                            <div>
                                <input class="form-control" type="time" name="depart--time-val" id="depart--time" value="00:00">
                            </div>
                        </div>    
                    </div>

                    <!-- 2 -->
                    <div class="row align-items-center border-bottom mx-0 py-3">

                        <div class="col-2">
                            <div>
                                <input class="form-control form-text w-100 text-muted" disabled type="text"
                                    name="" id="" value="Arrival">
                            </div>
                            <!-- <div class="bg-white rounded-1 px-3 py-2 text-muted fw-bold disabled" >Departure</div> -->
                        </div>

                        <!-- airport  -->
                        <div class="col-3">
                            <div>
                                <select class="form-select" name="arrive--airport--val" id="arrive--airport">
                                    <option value="">Lahore</option>
                                    <option value="">Sialkot</option>
                                    <option value="">Islamabad</option>
                                </select>
                            </div>
                        </div>

                        <!-- airline -->
                        <div class="col-3">
                            <div>
                                <select class="form-select" name="arrive--airline-val" id="arrive--airline">
                                    <option value="">Delta</option>
                                    <option value="">Emirates</option>
                                    <option value="">Gulf Air </option>
                                </select>
                            </div>
                        </div>

                        <!-- flight no  -->
                        <div class="col-2">
                            <div>
                                <input class="form-control" type="text" name="arrive--flight_no-val" id="arrive--flight_no" placeholder="Flight No">
                            </div>
                        </div>

                        <div class="col-2" style="width: calc((100% / 11) + 40px);">
                            <div>
                                <input class="form-control" type="time" name="arrive--time-val" id="arrive--time" value="00:00">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="border-bottom py-3 text-center">
                    <button id="add--more-transit-btn" class="btn btn-outline-dark px-5 py-2 fw-bold" type="button">Add Transit</button>
                </div>

                <!-- main setting -->

                <div class="row m-0 mt-5">
                    <div class="col-4">

                        <div class="card rounded-2 overflow-hidden text-capitalize">
                    
                            <div class="card-header h5" style="font-weight: normal;">main settings</div>

                            <div class="card-body">

                                <!-- status  -->
                                <label class="form-check form-switch rounded-2 overflow-hidden p-0 mt-2 background--hover">
                                    <div class="row px-1 py-2 cursor--pointer">
                                        <div class="col-4">
                                            <span class="h6 fw-bold text-muted">Status</span>
                                        </div>
                                        <div class="col-8">
                                            <input class="cursor--pointer float-end form-check-input p-0 m-0" style="width: 2.5rem; height: 1.38rem;" type="checkbox" id="main--status" name="main--status-val" value="enabled" checked>
                                        </div>
                                    </div>
                                </label>
                                
                                
                                <!-- refundable  -->
                                <label class="form-check form-switch rounded-2 overflow-hidden p-0 background--hover">
                                    <div class="row px-1 py-2 cursor--pointer">
                                        <div class="col-4">
                                            <span class="h6 fw-bold text-muted">Refundable</span>
                                        </div>
                                        <div class="col-8">
                                            <input class="cursor--pointer float-end form-check-input" type="checkbox" name="main--refund-val" id="main--refund" value="refundable" style="width: 2.5rem; height: 1.38rem;">
                                        </div>
        
                                    </div>
                               </label>


                               <!-- bagage  -->
                               <div class="row align-items-center mt-2">
                                   <div class="col-12">
       
                                       <div class="dropdown">
       
                                           <div class="input-group border rounded-2 overflow-hidden get--focus" data-bs-toggle="dropdown">
                                               <div class="form-control border-0 p-0">
       
                                                   <div class="form-floating">
                                                       <input placeholder="Bagage @KGs" class="form-control border-0 get--focus-rm" type="number" name="main--bag-weight-val" id="main--bag-weight" autocomplete="off">
                                                       <label class="text-muted">Bagage @KGs</label>
                                                   </div>
                                                   
                                               </div>
       
                                               <span class="input-group-text border-0 fw-bold" style="padding-inline: 7px; font-size: 16px;">KGs</span>
                                           </div>
       
                 
                                           <div class="dropdown-menu weight--kgs w-100">
                                               <div class="dd-item d-flex flex-wrap justify-content-center py-2">
                                                   <div>
                                                       <span class="unit">5</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">10</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">15</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">20</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">25</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">30</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">35</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">40</span>
                                                       <span>KGs</span>
                                                   </div>
                                                   <div>
                                                       <span class="unit">50</span>
                                                       <span>KGs</span>
                                                   </div>
                                               </div>
                                           </div>
       
                                       </div>     
                                   </div>
                               </div>


                               <!-- hours  -->
                               <div class="row align-items-center border rounded-2 overflow-hidden m-0 mt-2 get--focus">
                                   <div class="col-12 p-0">
       
                                       <div class="input-group">
                                           <div class="form-control form-floating border-0 p-0">
                                               <input placeholder="Total @Hours" class="form-control border-0 get--focus-rm" type="text" name="main--hours-val" id="main--hours" autocomplete="off">
                                               <label class="text-muted">Total @Hours</label>
                                           </div>
       
                                           <span class="input-group-text border-0">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                           </span>
       
                                       </div>
       
                                   </div>
                               </div>

                               <!-- vat tax  -->
                               <div class="row align-items-center border rounded-2 overflow-hidden m-0 mt-2 get--focus">
                                   <div class="col-12 p-0">
       
                                       <div class="input-group">
                                           <div class="form-floating form-control border-0 p-0">
                                               <input type="text" class="form-control border-0 get--focus-rm" name="main--vatax-val" id="main--vatax"  placeholder="Vat @Tax">
                                               <label class="text-muted">Vat @Tax</label>
                                           </div>
                                           <span class="input-group-text border-0">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                                           </span>
                                       </div>
       
                                   </div>
       
                               </div>
       
                               <!-- deposite tax  -->
       
                               <div class="row align-items-center border rounded-2 overflow-hidden m-0 mt-2 get--focus">
                                   <div class="col-12 p-0">
                                       <div class="input-group">
                                           <div class="form-control border-0 p-0 form-floating">
                                               <input class="form-control border-0 get--focus-rm" name="main--deposite-val" id="main--deposite" placeholder="Deposite @Tax" type="text">
                                               <label class="text-muted">Deposite @Tax</label>
                                           </div>
       
                                           <span class="input-group-text border-0">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                                           </span>
                                       </div>
                                   </div>
                               </div>
       
       
                               <!-- flight type  -->
       
                               <div class="row mt-3">
                                   <div class="col-12">
                                       <div class="d-flex flex-wrap row-cols-2">
       
                                           <div class="form-check">
                                               <label class="form-check-label text-muted fw-bold h6 cursor--pointer" for="main--flight--e">Economy</label>
                                               <input class="form-check-input cursor--pointer" type="radio" name="main--flightype-val" id="main--flight--e" checked>
                                           </div>
                                           
                                           <div class="form-check">
                                               <label class="form-check-label text-muted fw-bold h6 cursor--pointer" for="main--flight--pe">Premium Economy </label>
                                               <input class="form-check-input cursor--pointer" type="radio" name="main--flightype-val" id="main--flight--pe">
                                           </div>
                                           
                                           <div class="form-check">
                                               <label class="form-check-label text-muted fw-bold h6 cursor--pointer" for="main--flight--bs">Business</label>
                                               <input class="form-check-input cursor--pointer" type="radio" name="main--flightype-val" id="main--flight--bs">
                                           </div>
                                           
                                           <div class="form-check">
                                               <label class="form-check-label text-muted fw-bold h6 cursor--pointer" for="main--flight--fs">First Class</label>
                                               <input class="form-check-input cursor--pointer" type="radio" name="main--flightype-val" id="main--flight--fs">
                                           </div>
       
                                       </div>
       
                                   </div>
                               </div>


                            </div>

                        </div>
              
                    </div>


                    <div class="col-8 h-100">
                        <div class="border rounded-3 overflow-hidden h-100" id="container">
                            <div id="editor"></div>
                        </div>
                    </div>
                </div>

                
            </form>

        </div>


    </div>

    <div style="height: 1000px;"></div>


    <!-- jquery  -->
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- bootstrap -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

    <!-- select 2  -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="index.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
    <!--
            Uncomment to load the Spanish translation
            <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/translations/es.js"></script>
        -->
    <script>
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
            toolbar: {
                items: [
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', 'removeFormat',
                    'alignment', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '-',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'undo', 'redo',
                    'link', 'blockQuote', 'insertTable', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            // Changing the language of the interface requires loading the language file using the <script> tag.
            // language: 'es',
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: '',
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
            // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            // Be careful with enabling previews
            // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
            htmlEmbed: {
                showPreviews: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
            mention: {
                feeds: [
                    {
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }
                ]
            },
            // The "super-build" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType
                'MathType'
            ]
        });
    </script>
    






<?php include "_footer.php"; ?>