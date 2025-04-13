<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<div class="py-4 mb-0">
   <div class="container">
      <div class="">
         <?php require_once "./App/Views/Tours/Search.php"; ?>
      </div>
   </div>
</div>

<div class="bg-light">

    <div class="loader">
        <div class="py-5 d-flex justify-content-center align-items-center">
            <div class="m-0 rotatingDiv"></div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row g-3 recent">
                    <!-- HERE GOES THE TEMPLATED DATA -->
                </div>
            </div>
        </div>
    </div>

</div>

<?php 

$mods = array();
foreach ($modules as $i => $m){

    if ($m->type=="tours"){

        $arrs = array(
        "name"=>$m->name,
        "c1"=>$m->c1,
        "c2"=>$m->c2,
        "c3"=>$m->c3,
        "c4"=>$m->c4,
        "c5"=>$m->c6,
        "c6"=>$m->c6,
        );

        array_push($mods,$arrs);

    }
};

foreach($mods as $key=>$value){ 
    
    if ($value['name'] == "tours"){
        $api_url = root.api_url.'tours/search'; 
    } else {
        $api_url = "https://api.phptravels.com/tours/".$value['name']."/api/v1/search"; 
    }

?>

<script>
var form = new FormData();
form.append("location", "<?=$meta['location']?>");
form.append("date", "<?=$meta['date']?>");
form.append("adults", "<?=$meta['adults']?>");
form.append("childs", "<?=$meta['childs']?>");
form.append("language", "en");
form.append("currency", "<?=currency?>");
form.append("ip", "<?=$meta['ip']?>");
form.append("c1", "<?=$value['c1']?>");
form.append("c2", "<?=$value['c2']?>");
form.append("c3", "<?=$value['c3']?>");
form.append("c4", "<?=$value['c4']?>");
form.append("c5", "<?=$value['c5']?>");
form.append("c6", "<?=$value['c6']?>");
form.append("pagination", "<?=$meta['page_number']?>");

var settings = {
  "url": "<?=$api_url?>",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) {

  // LOADER REMOVE
  $('.loader').fadeOut(50);

//   var encoded = btoa(JSON.stringify("<?=$value['c1']?>"))
//   var actual = JSON.parse(atob(encoded))

  data = JSON.parse(response).response;
  // console.log(form)

    $.each(data, function( key, value ) {
        apend_func(value)
    })

});

</script>

<?php } ?>




<script>

function apend_func(value){

    $('.recent').append(`

    <div class="col-xl-3 col-lg-4 col-md-6 mb-2 col-12" data-aos="fade-up">
<div class="bg-white h-100 rounded-3">
  <div class="card rounded-3 border-0">
     <!-- THUMBNAIL -->
     <div class="col-12 overflow-hidden border-0" style="max-height: 230px;min-height: 230px; border-radius: 6px 6px 0px 0px !important;">
        <img class="w-100 h-100" src="`+value.img+`" style="object-fit: cover;min-height: 230px;" alt="">
     </div>
  </div>
  <div class="p-3 py-3 overflow-hidden position-relative">
     <p class="m-1" style="line-height:20px;min-height:40px"><strong>`+value.name+`</strong></p>
     <span class="d-inline-block rounded-pill position-absolute" style="top:5px; right:5px; height: 10px;width: 10px;background: ##`+value.color+`"></span>
     <div class="d-flex justify-content-between align-items-center mb-1">
        <div class="d-flex gap-1 align-items-center text-muted h6 py-2">
           <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs">
                 <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
                 <circle cx="12" cy="10" r="3"></circle>
              </svg>
           </span>
           <span class="text--overflow text-capitalize">`+value.location+`</span>
        </div>
     </div>
     <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
           <svg class="stars" style="margin-right:-3px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
           </svg>
           <svg class="stars" style="margin-right:-3px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
           </svg>
           <svg class="stars" style="margin-right:-3px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
           </svg>
           <svg class="stars" style="margin-right:-3px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
           </svg>
        </div>
        <div class="d-inline-flex fw-bold rounded">
           <small>
           Rating `+value.rating+`/5
           </small>
        </div>
        <span class="fw-bold fs-5"><small style="font-size:14px"><?=currency?></small> `+value.price+`</span>
     </div>
     <a href="<?=root?>tour/`+value.tour_id+`/`+value.supplier+`/<?=$meta['date']?>/<?=$meta['adults']?>/<?=$meta['childs']?>" target="_self" class="d-flex align-items-center btn btn-primary rounded-1 justify-content-center gap-2 waves-effect" type="button">
        <?=T::details?>                           
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs">
           <path d="M9 18l6-6-6-6"></path>
        </svg>
     </a>
  </div>
</div>
</div>
`).hide().fadeIn(0, function() { 
    // console.log('') 
});

}

</script>

<script>
   AOS.init();
</script>