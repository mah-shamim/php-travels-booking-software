<table class="table table-bordered">
        <thead class="">
            <tr class="bg-light">
                <th class="text-start"><strong><?=T::customer?> <?=T::details?></strong></th>
                <th class="text-start"><strong></strong></th>
                <th class="text-start"><strong><?=T::customer?> <?=T::care?></strong></th>
                <th class="text-start"><strong></strong></th>
            </tr>
            <tr>
                <th class="text-start"><strong><?=T::email?></strong></th>
                <th class="text-start fw-light"><?php if(!empty(json_decode($data->user_data)->email)){ echo json_decode($data->user_data)->email; } ?></th>
                <th class="text-start"><strong><?=T::email?></strong></th>
                <?php if (!empty(app()->app->contact_email)){?>
                <th class="text-start fw-light"><?=app()->app->contact_email?></th>
            <?php } ?>
            </tr>
            <tr>
                <th class="text-start"><?=T::contact?></th>
                <th class="text-start fw-light"><?php if(!empty(json_decode($data->user_data)->phone)){ echo json_decode($data->user_data)->phone; } ?></th>
                <th class="text-start"><?=T::contact?></th>
                <?php if (!empty(app()->app->contact_phone)){?>
            <th class="text-start fw-light"><?=app()->app->contact_phone?></th>
            <?php } ?>
            </tr>
            <tr>
                <th class="text-start"><?=T::address?></th>
                <th class="text-start fw-light"><?php if(!empty(json_decode($data->user_data)->address)){ echo json_decode($data->user_data)->address; } ?></th>
                <th class="text-start"><?=T::website?></th>
                <?php if (!empty(app()->app->site_url)){?>
            <th class="text-start fw-light"><?=app()->app->site_url?></th>
            <?php } ?>
            </tr>
        </thead>
    </table>
    <div class="row g-2">
        <div class="col"><button class="btn border no_print w-100 d-flex item-align-center gap-3 justify-content-center p-3" onclick="download_pdf()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/></svg>
        <?=T::download_as_pdf?></button></div>
        <div class="col">
        <a class="btn border no_print w-100 d-flex item-align-center gap-3 justify-content-center p-3" id="a" target="_blank" href="javascript:void()"> 
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.6 6.31999C16.8669 5.58141 15.9943 4.99596 15.033 4.59767C14.0716 4.19938 13.0406 3.99622 12 3.99999C10.6089 4.00135 9.24248 4.36819 8.03771 5.06377C6.83294 5.75935 5.83208 6.75926 5.13534 7.96335C4.4386 9.16745 4.07046 10.5335 4.06776 11.9246C4.06507 13.3158 4.42793 14.6832 5.12 15.89L4 20L8.2 18.9C9.35975 19.5452 10.6629 19.8891 11.99 19.9C14.0997 19.9001 16.124 19.0668 17.6222 17.5816C19.1205 16.0965 19.9715 14.0796 19.99 11.97C19.983 10.9173 19.7682 9.87634 19.3581 8.9068C18.948 7.93725 18.3505 7.05819 17.6 6.31999ZM12 18.53C10.8177 18.5308 9.65701 18.213 8.64 17.61L8.4 17.46L5.91 18.12L6.57 15.69L6.41 15.44C5.55925 14.0667 5.24174 12.429 5.51762 10.8372C5.7935 9.24545 6.64361 7.81015 7.9069 6.80322C9.1702 5.79628 10.7589 5.28765 12.3721 5.37368C13.9853 5.4597 15.511 6.13441 16.66 7.26999C17.916 8.49818 18.635 10.1735 18.66 11.93C18.6442 13.6859 17.9355 15.3645 16.6882 16.6006C15.441 17.8366 13.756 18.5301 12 18.53ZM15.61 13.59C15.41 13.49 14.44 13.01 14.26 12.95C14.08 12.89 13.94 12.85 13.81 13.05C13.6144 13.3181 13.404 13.5751 13.18 13.82C13.07 13.96 12.95 13.97 12.75 13.82C11.6097 13.3694 10.6597 12.5394 10.06 11.47C9.85 11.12 10.26 11.14 10.64 10.39C10.6681 10.3359 10.6827 10.2759 10.6827 10.215C10.6827 10.1541 10.6681 10.0941 10.64 10.04C10.64 9.93999 10.19 8.95999 10.03 8.56999C9.87 8.17999 9.71 8.23999 9.58 8.22999H9.19C9.08895 8.23154 8.9894 8.25465 8.898 8.29776C8.8066 8.34087 8.72546 8.403 8.66 8.47999C8.43562 8.69817 8.26061 8.96191 8.14676 9.25343C8.03291 9.54495 7.98287 9.85749 8 10.17C8.0627 10.9181 8.34443 11.6311 8.81 12.22C9.6622 13.4958 10.8301 14.5293 12.2 15.22C12.9185 15.6394 13.7535 15.8148 14.58 15.72C14.8552 15.6654 15.1159 15.5535 15.345 15.3915C15.5742 15.2296 15.7667 15.0212 15.91 14.78C16.0428 14.4856 16.0846 14.1583 16.03 13.84C15.94 13.74 15.81 13.69 15.61 13.59Z" fill="#000"/>
        </svg>
        <?=T::send_to_whatsapp?></a></div>
        <?php if ($data->cancellation_request==1){}else{?>
        <div class="col">
        <form onSubmit="show_alert(event);" action="#" method="GET">
        <button type="submit" class="btn border no_print w-100 d-flex item-align-center gap-3 justify-content-center p-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <?=T::request_for_cancellation?>
        </button>
        </form>
        </div>
        <?php } ?>
    </div>

    <script>
        // CANCELLATION REQUEST
        function show_alert() { if(!confirm("<?=T::are_you_sure_about_cancellation?>")) { 
        event.preventDefault();    
        return false; } 
        
            event.preventDefault();

            // SHOW LOADING ANIMATION
            document.getElementById("loading").style.display = "flex";
            var form = new FormData();
            form.append("booking_ref_no", "<?=$data->booking_ref_no?>");
            var settings = {
            "url": "<?=root.api_url?><?=$data->module_type?>/cancellation",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                location.reload();
            });
        }
        var url = "https://wa.me/<?php if(!empty(json_decode($data->user_data)->phone)){ echo json_decode($data->user_data)->phone; } ?>?text=Booking%20Invoice%20"+encodeURIComponent(window.location.href);
        document.getElementById('a').setAttribute('href',url);

    </script>

    <!-- LOADING ANIMATION FOR CANCELLATION -->
    <div id="loading" style="display: none;padding: 150px; align-items: center; position: fixed; width: 100%; top: 0; left: 0; background: #fff; z-index: 9999; height: 100%;">
        <div class="rotatingDiv"></div>
    </div>
</div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js" ></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" ></script>

<!-- js pdf  -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
<script>
    var w = 776;
    var h = 1259;

    var timeEvent = 1000;
    var windowWidth = 0;

    const loadingElement = document.querySelector("div#loading");

    function download_pdf() {      
        (windowWidth > 0) && (window.innerWidth = windowWidth + "px");
        
        windowWidth = window.innerWidth;
        
        if(windowWidth < 768) {
            window.innerWidth = 992 + "px";
            
            timeEvent = 2000;
        }
        

        $(".no_print").attr("style", "display: none !important");
        
        setTimeout(function () { 
            $(".no_print").attr("style", "") 
            loadingElement.classList.remove("_show");
        }, 5000);
        
        setTimeout(() => {
            html2canvas($("#invoice")[0], {
                useCORS: true
            }).then((canvas) => {                
                var img = canvas.toDataURL("image/jpeg");
                
                // loading animation
                loadingElement.classList.add("_show");

                var invoicePdf = new jsPDF({
                    unit: "px",
                });                
                invoicePdf.addImage(img, 'jpeg', 23.28, 25.18, 400, 550, 'FAST');
                invoicePdf.save("invoice.pdf");

                location.reload();
            });

        }, timeEvent);
    }
</script>

<!-- ANIMATION LIBRARY -->
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.9.3/tsparticles.confetti.bundle.min.js"></script>

<!-- ANIMATION FOR SUCCESSFULL PAYMENT -->
<?php if (isset($_SESSION['animate'])) {?>
<script>
const count=200,defaults={origin:{y:.7}};function fire(e,t){confetti(Object.assign({},defaults,t,{particleCount:Math.floor(count*e)}))}fire(.25,{spread:26,startVelocity:55}),fire(.2,{spread:60}),fire(.35,{spread:100,decay:.91,scalar:.8}),fire(.1,{spread:120,startVelocity:25,decay:.92,scalar:1.2}),fire(.1,{spread:120,startVelocity:45});
</script>
<?php } unset($_SESSION['animate']); // REMOVE ANIMATE FROM THE SESSION
?>

<!-- ANIMATION FOR SUCCESSFULL NEW BOOKING CELEBRATION -->
<?php 

 
if (isset($_SESSION['booking_celebration'])) {?>
<script>
const count=200,defaults={origin:{y:.7}};function fire(e,t){confetti(Object.assign({},defaults,t,{particleCount:Math.floor(count*e)}))}fire(.25,{spread:26,startVelocity:55}),fire(.2,{spread:60}),fire(.35,{spread:100,decay:.91,scalar:.8}),fire(.1,{spread:120,startVelocity:25,decay:.92,scalar:1.2}),fire(.1,{spread:120,startVelocity:45});
</script>
<?php } unset($_SESSION['booking_celebration']); // REMOVE ANIMATE FROM THE SESSION
?>

<style>
.form-check{cursor:pointer}
.header-top-bar,.main-menu-content,.info-area,.footer-area,.cta-area{display:none}
.menu-wrapper{display: flex; justify-content: center; padding: 12px;}
.nav-link:focus, .nav-link:hover { color: var(--theme-bg) !important; }
.newsletter-section{display: none;}

/* cancellation read more  */
.to--be > p { max-height: calc(3.5em + 2px); overflow: hidden; }
.to--be > .read--more { display: none; }
.to--be > .read--more > label { cursor: pointer; }
.to--be:has(:checked) > p { max-height: unset !important; }
.to--be:has(:checked) > .read--more > #to--be_1 { display: none !important; }
.to--be:has(:checked) > .read--more > #to--be_2 { display: block !important; }
header #navbarSupportedContent { display: none !important }
header { height: 80px; }
header .container{ justify-content: center !important; }

._show {
    display: block !important;
    background: #ffffff36 !important;
}
</style>