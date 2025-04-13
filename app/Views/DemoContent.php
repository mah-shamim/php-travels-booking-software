<?php 
if ($_SERVER['SERVER_NAME']=="phptravels.site" || $_SERVER['SERVER_NAME']=="phptravels.net"){ ?>
<style>
        
    /* Cookies Law Style */
    .cc-window{opacity:1;transition:opacity 1s ease;}
    .cc-link{text-decoration:underline;}
    .cc-window{left:0;right:0;bottom:10px;position:fixed;overflow:hidden;box-sizing:border-box;font-size:16px;line-height:1.5em;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;z-index:999;}
    .cc-window.cc-banner{padding:6px;width:100%;-ms-flex-direction:row;flex-direction:row;}
    .cc-btn,.cc-link{cursor:pointer;}
    .cc-link{opacity:.8;padding:0;}
    .cc-link:hover{opacity:1;} .cc-link:active,.cc-link:visited{color:initial;}
    .cc-btn{display:block;padding:.4em .8em;font-size:.9em;font-weight:700;border-width:2px;border-style:solid;text-align:center;white-space:nowrap;}
    .cc-window.cc-banner{-ms-flex-align:center;align-items:center;}
    .cc-banner .cc-message{display:block;-ms-flex:1 1 auto;flex:1 1 auto;max-width:100%;margin-right:1em;font-size: 14px; letter-spacing: 0.2px;}
    .cc-compliance{margin-right: 2px;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-line-pack:justify;align-content:space-between;}
    @media print{
    .cc-window{display:none;} } @media screen and (max-width:900px){
    .cc-btn{white-space:normal;} } @media screen and (max-width:414px) and (orientation:portrait),screen and (max-width:736px) and (orientation:landscape){
    .cc-window.cc-top{top:0;}
    .cc-window.cc-banner{left:0;right:0;}
    .cc-window.cc-banner{-ms-flex-direction:column;flex-direction:column;}
    .cc-window.cc-banner .cc-compliance{-ms-flex:1 1 auto;flex:1 1 auto;}
    .cc-window .cc-message{margin-bottom:1em;}
    .cc-window.cc-banner{-ms-flex-align:unset;align-items:unset;}
    .cc-window.cc-banner .cc-message{margin-right:0;} }
    .cc-color-override--1961008818.cc-window{color:rgb(0 73 170 / 70%);background-color:transparent;}
    .cc-color-override--1961008818 .cc-link,.cc-color-override--1961008818
    .cc-link:active,.cc-color-override--1961008818 .cc-link:visited{color:rgb(0 73 170 / 70%);font-weight: bold}
    .cc-color-override--1961008818 .cc-btn{color: #fff; border-color: transparent; background-color: #2989fff5; padding: 4px 24px; margin-top: -29px;}
    .cc-color-override--1961008818 .cc-btn:hover,.cc-color-override--1961008818
    .cc-btn:focus{background-color:#1567cbf5;}
    .cookies_bg { background: #000000;border: 1px solid #000000;margin: 0 auto; padding: 20px 22px; border-radius: 10px; color: #fff }
    /* Cookies Law Style */

</style>

<!-- <nav class="bg-primary navbar d-fixed p-0" style="position: fixed; top: 0; width: 100%; height: 50px; z-index: 1000;">
    <div class="container">
        <div class="py-0">
            <a href="https://phptravels.com/pricing" class="btn btn-light" target="_blank">
                BUY NOW
            </a>
        </div>
    </div>
</nav> -->

<div id="cookie_disclaimer" data-wow-duration="0.5s" data-wow-delay="5s" role="dialog" class="wow  fadein_ fadeIn cc-window cc-banner cc-type-info cc-theme-block cc-color-override--1961008818" style="z-index: 9999;">
<div class="container">
<div class="cookies_bg">
<span id="cookieconsent:desc" class="cc-message">This is a demo website of <strong>PHPTRAVELS</strong> to use this on your website please buy phptravels.com
<!-- <a aria-label="learn more about cookies" role="button" tabindex="0" class="cc-link waves-effect" href="https://phptravels.com/pricing" rel="noopener noreferrer nofollow" target="_blank">Pricing</a> -->
</span>
<div class="cc-compliance text-end float-end">
<a href="https://phptravels.com/pricing/" target="_bank" class="cc-btn cc-dismiss" style="margin-right:5px">Pricing</a>
<button class="cc-btn cc-dismiss" id="cookie_stop">Hide</button></div>
</div>
</div>
</div>

<script>
$(function(){
     $('#cookie_stop').click(function(){
        $('#cookie_disclaimer').slideUp();
        var nDays = 999;
        var cookieName = "disclaimer";
        var cookieValue = "true";
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000*24*nDays);
        document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString()+";path=/";
     });

});
</script>

<?php } ?>