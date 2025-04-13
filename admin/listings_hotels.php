<div class="row g-4">
    <div class="col-md-8">

        <div class="form-floating mb-2">
            <input required type="text" placeholder="name" name="name" id="name"
                value="<?php if (isset($listing)){echo $listing->name;}?>" class="form-control slugger-source">
            <label for="name"><?=T::name?></label>
        </div>

        <div class="form-floating mb-2 d-none">
            <input required type="text" placeholder="slug_url" name="slug" id="slug_url"
                value="<?php if (isset($listing)){echo $listing->slug;}?>" class="form-control slugger-target">
            <label for="slug_url"><?=T::slug_url?></label>
        </div>

        <div class="card">
            <div class="card-header">
                <strong><?=T::description?></strong>
            </div>
            <div class="card-body">
                <textarea style="max-height:100px" name="desc" class="editor" cols="30" rows="10"
                    class=""><?php if (isset($listing)){echo $listing->desc;}?></textarea>
                <label for="" class="mt-3 mb-2"><strong><?=T::policy?></strong></label>
                <div class="form-floating mb-2 mt-1">
                    <textarea name="policy" class="form-control" placeholder=" " id=""
                        style="height: 150px"><?php if (isset($listing)){echo $listing->policy;}?></textarea>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::images?></strong>
            </div>
            <div class="card-body">

                <div class="uploader">
                    <input type="file" name="file" class="filepond" multiple data-allow-reorder="true"
                        data-max-file-size="2MB" data-max-files="10"
                        accept="image/png, image/jpeg, image/gif, image/jpg">
                </div>

                <?php 
                $params = array("image_listing_id"=>$listing->id);
                $images = GET('listings_images',$params);                          
                if (isset($images)) {
                if (!empty($images)) { 
                ?>

                <div class="p-2 border border-2 mb-2 rounded text-dark d-flex align-items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>

                    <?=T::last_picture_will_be_considered_as_a_thumbnail?>
                </div>
                <?php 
                } 
            } 
            ?>


        <?php 

        // dd($images);

        if (isset($images)) { ?>
                <script>
                let counter = <?=count($images)?>;
                </script>

                <div class="row mb-1">
                    <?php foreach ($images as $i => $image) { ?>
                    <div class="col-1" style="min-width:85px;">

                        <div class="MuiListItem-root MuiListItem-gutters MuiListItem-padding css-1a7yq8u"
                            style="opacity: 1; transform: none;"><span class="MuiBox-root css-1vboz2"><span
                                    class="wrapper lazy-load-image-background blur lazy-load-image-loaded"
                                    style="display: inline-block;">
                                    <img class="MuiBox-root css-6jrdpz" alt="preview"
                                        src="../uploads/<?=$image->image_name?>" sx="[object Object]"></span></span>
                            <button
                                class="dell_<?=$image->image_id?> MuiButtonBase-root MuiIconButton-root MuiIconButton-sizeSmall css-vp5vtz"
                                tabindex="0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="MuiBox-root css-0 iconify iconify--eva"
                                    sx="[object Object]" width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29l-4.3 4.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l4.29-4.3l4.29 4.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42Z">
                                    </path>
                                </svg><span class="MuiTouchRipple-root css-w0pj6f"></span></button>
                        </div>

                    </div>

                    <script>
                    $('.dell_<?=$image->image_id?>').click(function() {
                        let text = "Are you sure you want to delete this image?";
                        if (confirm(text) == true) {
                            let counter = <?=$image->image_id?> - 1;
                            $.ajax({
                                url: './_post.php',
                                type: 'POST',
                                data: {
                                    product_image_id: <?=$image->image_id?>,
                                    image_name: "<?=$image->image_name?>"
                                },
                                success: function(data) {
                                    $('.dell_<?=$image->image_id?>').parent().parent().fadeOut(300,
                                        function() {
                                            $(this).remove();
                                        });
                                }
                            })

                            // REFRESH BROWSER
                            if (<?=count($images)?> > 17) {
                                location.reload()
                            }
                        } else {};
                    });
                    </script>

                    <?php } ?>
                </div>
                <?php } ?>

                <?php 
        if (isset($images)) { 
        // if (count($images) < 18) { ?>
                <script>
                if (<?=count($images)?> < 18) {
                    // alert(counter);
                    $('.uploader').show();
                } else {

                    setTimeout(function() {
                        $('.uploader').hide();
                    }, 200);
                    // alert(counter);

                }
                </script>
                <?php } ?>

            </div>
        </div>

        <link href="./assets/plugins/filepond/filepond.min.css" rel="stylesheet">
        <script src="./assets/plugins/filepond/filepond-plugin-file-encode.min.js"></script>
        <script src="./assets/plugins/filepond/filepond-plugin-image-exif-orientation.min.js"></script>
        <script src="./assets/plugins/filepond/filepond.js"></script>

        <script>
        FilePond.parse(document.body);
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginImageExifOrientation,
        );

        FilePond.create(
            FilePond.setOptions({

                    allowMultiple: true,
                    server: {
                        url: './_post.php',
                        process: {
                            url: './_post.php?upload=<?=$listing->id?>',
                            method: 'POST',
                            withCredentials: false,
                            headers: {},
                            timeout: 7000,
                            onload: null,
                            onerror: null,
                            ondata: null,
                        },
                    },
                    <?php 
        $url = array();
        if (end($url) == "add") {} else { ?>
                    // REFESH PAGE ON COMPLETION
                    // onprocessfiles: () => location.reload()
                    <?php } ?>
                },

            ), );
        </script>

        <div class="card mt-3">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::rooms?></strong>
            </div>
            <div class="card-body">

                <?php 

        include('./xcrud/xcrud.php');
        $xcrud = Xcrud::get_instance();
        $xcrud->table('listings_rooms');
        $xcrud->order_by('id','desc');
        $xcrud->columns('status,thumb_img,room_type_id,hotel_id');
        $xcrud->fields('status,thumb_img,room_type_id,hotel_id');
        $xcrud->relation('room_type_id','listings_settings','id','name','setting_type = "rooms_type"');
        $xcrud->change_type('room_adults','select','1','1,2,3,4,5,6,7,8,9');
        $xcrud->change_type('room_children','select','0','0,1,2,3,4,5,6,7,8,9');

        $rooms_options = $xcrud->nested_table('id','id','listings_rooms_options','room_id'); 
        $rooms_options->columns('breakfast,cancellation,quantity,price,adults,childs');
        $rooms_options->fields('breakfast,cancellation,quantity,price,adults,childs');
        $rooms_options->change_type('adults','select','1','1,2,3,4,5,6,7,8,9');
        $rooms_options->change_type('childs','select','0','0,1,2,3,4,5,6,7,8,9');

        $rooms_options->field_callback('breakfast','Enable_Disable');
        $rooms_options->field_callback('cancellation','Enable_Disable');

        $rooms_options->unset_title();
        $rooms_options->unset_csv();

        $xcrud->change_type('hotel_id', 'hidden');
        $xcrud->where('hotel_id =', $listing->id);
        $xcrud->pass_default('hotel_id', $listing->id);
        $xcrud->unset_title();
        $xcrud->unset_csv();
        $xcrud->unset_view();
        $xcrud->column_class('thumb_img', 'zoom_img');
        $xcrud->change_type('thumb_img', 'image', true, array('width' => 200, 'path' => '../../uploads/',
        // 'thumbs'=>array(
        // array('width'=> 50, 'marker'=>'_s'),
        // array('width'=> 100, 'marker'=>'_m'),
        // array('width'=> 500, 'marker'=>'_l'),
        // array('width'=> 1000, 'marker'=>'_xl'),
        // array('width' => 250, 'folder' => 'thumbs' // using 'thumbs' subfolder
        // ))
        ));

        // USER PERMISSIONS
        if (!isset($permission_delete)){ $xcrud->unset_remove(); }
        if (!isset($permission_edit)){ $xcrud->unset_edit(); } else {
        $xcrud->column_callback('status', 'check_mark');
        $xcrud->column_callback('featured', 'featured');
        $xcrud->field_callback('status','Enable_Disable');
        }

        $xcrud->column_width('thumb_img','100px');
        $xcrud->column_width('status','5%');
        $xcrud->language($USER_SESSION->backend_user_language);

        echo $xcrud->render();
        ?>

            </div>
        </div>

    </div>

    <!-- PARTCIAL -->
    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::settings?></strong>
            </div>
            <div class="card-body">

                <?php 
            $params = array("user_id"=> $listing->owned_by);
            $data = GET('users',$params);
            $seuser = DECODE($_SESSION['phptravels_backend_user']);
            $params = array("type_name"=> $seuser->backend_user_type);
            $role = GET('users_roles',$params);

            // SHOW THIS OPTION ONLY TO ADMINS
            if (isset($role[0]->type_name)) {
            if (strtolower($role[0]->type_name) == "admin") { ?>

                <div class="border px-4 rounded-3 mb-2 pt-2 ">

                    <div class="row">

                        <div class="col">
                            <div class="row form-group mb-0">
                                <label class="col-md-4 control-label text-left pt-2"><?=T::status?></label>
                                <div class="col-md-8">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="status"></label>
                                        <input
                                            <?php if(isset($listing)){ if ($listing->status == 1){ echo "checked";} }?>
                                            style="margin-top:10px;width: 40px; height: 20px;cursor:pointer"
                                            class="form-check-input" id="status" type="checkbox" name="status" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="row form-group mb-0">
                                    <label class="col-md-4 control-label text-left pt-2"><?=T::refundable?></label>
                                    <div class="col-md-8">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="refundable"></label>
                                            <input
                                                <?php if(isset($listing)){ if ($listing->refundable == 1){ echo "checked";} }?>
                                                style="margin-top:10px;width: 40px; height: 20px;cursor:pointer"
                                                class="form-check-input" id="refundable" type="checkbox"
                                                name="refundable" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mb-3">
                                <label class="col-md-4 control-label text-left pt-2"><?=T::featured?></label>
                                <div class="col-md-8">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="featured"></label>
                                        <input
                                            <?php if(isset($listing)){ if ($listing->featured == 1){ echo "checked";} }?>
                                            style="margin-top:10px;width: 40px; height: 20px;cursor:pointer"
                                            class="form-check-input" id="featured" type="checkbox" name="featured"
                                            value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col mb-2">
                    <div class="form-floating mb-0">
                        <select required class="form-select owned_change" name="owned_by" required>
                            <?php if (isset($data[0])){ $user = $data[0]; ?>
                            <option value="<?=$listing->owned_by?>"><strong><?=$user->first_name?>
                                    <?=$user->last_name?></strong> <?=$user->email?></option>
                            <?php } else { ?>
                            <option value="<?=$seuser->backend_user_id?>"><?=$seuser->backend_user_name?></option>
                            <?php } ?>
                        </select>
                        <label style="margin-top:-3px;" for=""><?=T::owned_by?></label>
                    </div>
                </div>

                <?php } else {?>
                <input type="hidden" name="owned_by" value="<?=$seuser->backend_user_id?>">
                <?php } } ?>

                <div class="form-floating mb-2">
                    <?php $params = array(); $currencies = GET('currencies',$params); ?>
                    <select required class="form-select" name="currency_id">
                        <?php foreach($currencies as $c){ ?>
                        <option value="<?=$c->name?>"><?=$c->name?></option>
                        <?php } ?>
                    </select>
                    <label for=""><?=T::hotel.' '.T::currency?></label>
                </div>
                <script>
                $("[name='currency_id']").val('<?=$listing->currency_id?>')
                </script>

                <div class="form-floating mb-2">
                    <?php $params = array("setting_type"=>"hotels_type"); $hotels_type = GET('listings_settings',$params); ?>
                    <select required class="form-select" name="settings_type">
                        <?php foreach($hotels_type as $h){ ?>
                        <option value="<?=$h->id?>"><?=$h->name?></option>
                        <?php } ?>
                    </select>
                    <label for=""><?=T::hotel.' '.T::type?></label>
                </div>

                <?php if (!empty($listing->settings_type)) {?> <script>
                $("[name='settings_type']").val('<?=$listing->settings_type?>')
                </script><?php } ?>

                <div class="form-floating mb-0">
                    <select required class="form-select" name="stars">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <label for=""><?=T::star?></label>
                </div>
            </div>
            <?php if (!empty($listing->stars)) {?>
            <script>
            $("[name='stars']").val('<?=$listing->stars?>')
            </script>
            <?php } ?>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::location?></strong>
            </div>
            <div class="card-body">

                <div class="form-floating mb-2">
                    <select required class="locations form-select" name="location_id" required>
                        <?php if (isset($listing->location_id)){ $params = array("id"=>$listing->location_id); $languages = GET('locations',$params)[0];?>
                        <option value="<?=$listing->location_id?>"><?=$languages->city?>
                            <small><strong><?=$languages->country?> </strong></small></option>
                        <?php } else { ?>
                        <option value=""><?=T::select?></option>
                        <?php } ?>
                    </select>
                    <label style="margin-top:-3px;" for=""><?=T::location?> <?=T::city?></label>
                </div>

                <div class="form-floating mb-2">
                    <input required type="text" placeholder="name" id="mapaddress" name="mapaddress"
                        value="<?php if (isset($listing)){echo $listing->mapaddress;}?>" class="form-control">
                    <label for="mapaddress"><?=T::adress_on_map?></label>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body" style="margin-bottom: 0px;">
                        <div class="col-md-12 form-horizontal">
                            <table class="table">

                                <tr>
                                    <td><?=T::latitude?></td>
                                    <td><input type="text" class="form-control" id="latitude"
                                            value="<?php if (isset($listing)){echo $listing->latitude;}?>"
                                            name="latitude" /></td>
                                </tr>
                                <tr>
                                    <td><?=T::longitude?></td>
                                    <td><input type="text" class="form-control" id="longitude"
                                            value="<?php if (isset($listing)){echo $listing->longitude;}?>"
                                            name="longitude" /></td>
                                </tr>
                            </table>

                        </div>
                        <div class="border p-2 rounded-3 mb-2">
                            <div id="map-canvas" style="height: 200px; width:400"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Address and Map -->

        <div class="card mt-3">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::amenities?></strong>
            </div>
            <div class="card-body">

                <div class="form-check">
                    <input onClick="toggle(this)" type="checkbox" class="form-check-input" id="select_alls" name=""
                        value="">
                    <label for="select_alls"><?=T::select_all?></label>
                </div>
                <hr>

                <div class="row">

                    <?php 
                        $params = array("setting_type"=> "hotel_amenities");
                        $amenities = GET('listings_settings',$params);
                        ?>

                    <?php foreach ($amenities as $a){ ?>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input onClick="toggle(this)" type="checkbox" class="check form-check-input"
                                id="am_<?=$a->id?>" name="amenities[]" value="<?=$a->id?>">
                            <label for="am_<?=$a->id?>"><?=$a->name?></label>
                        </div>
                    </div>
                    <?php } ?>

                    <?php 
                        if (!empty($listing->amenities)){
                        $amenties_data = json_decode($listing->amenities);
                        foreach ($amenties_data as $i) {                        
                        echo ("<script>$('#am_".$i."').prop('checked', true);</script>");
                        } }
                        ?>

                </div>
            </div>
        </div>

        <!-- <div class="card mt-3">
            <div class="card-header">
                <strong><?=T::hotel?> <?=T::qr_code?></strong>
            </div>
            <div class="card-body pt-4">

                <?php
                $params = array();
                $settings = GET('settings',$params)[0];
                ?>

                <?php $QR = "https://chart.googleapis.com/chart?cht=qr&chs=250x260&chl=".$settings->site_url."/hotel/".$listing->id.""; ?>

                <div class="d-flex justify-content-center">
                    <div class="border p-0 rounded-3 mb-2">
                        <img class="" src="<?=$QR?>" alt="">
                    </div>
                </div>

                <a href="#" download="<?=$QR?>" class="btn btn-light w-100 mb-3 mt-3"><?=T::download?>
                    <?=T::qr_code?></a>
            </div>
        </div> -->
    </div>

</div>
</div>

</div>
<div class="card-footer" style="#position: fixed; bottom: 0; width: 100%;background: #e9ecef;">
    <div class="mx-4 my-3">
        <button type="submit" class="btn btn-primary"> <?=T::submit?></button>
    </div>
</div>

</div>

<style>
.xcrud-rightside,
.xcrud-top-actions {
    float: left;
    margin: 0 0px;
}

.xcrud-list-container {
    overflow-x: auto;
    clear: both;
    padding: 20px 0px;
    background: #fff;
    border-radius: 16px;
    margin: 0px 0;
}
</style>

<script>
$('#select_alls').change(function() {
    var checkboxes = $(this).closest('form').find('.check').not($(this));
    checkboxes.prop('checked', $(this).is(':checked'));
});
</script>

<script>
function initAutocomplete() {
    var markers = [];
    var ex_latitude = $('#latitude')
        .val();
    var ex_longitude = $('#longitude')
        .val();
    if (ex_latitude != '' && ex_longitude != '') {
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {
                lat: parseFloat(ex_latitude),
                lng: parseFloat(ex_longitude)
            },
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            icon: "./assets/img/marker.png",
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(ex_latitude, ex_longitude)
        });
        markers.push(marker);
        google.maps.event.addListener(marker, 'dragend', function() {
            var marker_positions = marker.getPosition();
            $('#latitude')
                .val(marker_positions.lat());
            $('#longitude')
                .val(marker_positions.lng());
        });
    } else {
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    }
    // Create the search box and link it to the UI element.
    var input = document.getElementById('mapaddress');
    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
        //   alert(input);
    });
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        map.setZoom(16);
        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            var marker = new google.maps.Marker({
                map: map,
                icon: "./assets/img/marker.png",
                title: place.name,
                position: place.geometry.location,
                draggable: true,
                animation: google.maps.Animation.DROP,
            });
            // Create a marker for each place.
            markers.push(marker);
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            google.maps.event.addListener(marker, 'dragend', function() {
                var marker_positions = marker.getPosition();
                $('#latitude')
                    .val(marker_positions.lat());
                $('#longitude')
                    .val(marker_positions.lng());
            });
            $('#latitude')
                .val(place.geometry.location.lat());
            $('#longitude')
                .val(place.geometry.location.lng());
        });
        map.fitBounds(bounds);
        map.setZoom(16);
    });
}
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvPooGV84U2zlu--JO8IQQvKDakc_VJ6k&libraries=places&callback=initAutocomplete"
    async defer></script>