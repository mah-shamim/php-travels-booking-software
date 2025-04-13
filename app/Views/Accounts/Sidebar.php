<?php //dd($_SESSION);?>

<div class="pt-3">
    <div class="sticky-top bg-white">
        <div class="author-content">
            <div class="lh-1 border rounded p-3 py-4 mb-2 text-center align-items-center gap-3" style="">
                <div class="author-img avatar-sm mx-auto">
                    <img src="<?=root?>assets/img/user.png" alt="user" style="width:50px;height:auto">
                </div>
                <div class="d-block"></div>
                <?php // dd($_SESSION['phptravels_client']) ?>
                <div class="w-100 text-center mt-3">
                    <h6 class="mb-0"><strong style="text-transform:capitalize"><?=$_SESSION['phptravels_client']->first_name?> <?=$_SESSION['phptravels_client']->last_name?></strong></h6>
                    <span class="author__meta"><?=T::welcomeback?></span>
                </div>
            </div>
        </div>
    </div>
</div><!-- end sidebar-nav -->
<div class="">

<ul class="sidebar-menu list-items w-100 g-1 user_menu">
    <li class=""><a class="py-2 <?php if (isset($meta['dashboard_active'])) { echo "active btn btn-primary w-100 d-block fadeout"; }else{ echo "btn btn-outline-dark w-100 d-block fadeout"; }?>" href="<?=root.('dashboard')?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> <?=T::dashboard?></a></li>
    <li class=""><a class="py-2 <?php if (isset($meta['bookings_active'])) { echo "active btn btn-primary w-100 d-block fadeout"; }else{ echo "btn btn-outline-dark w-100 d-block fadeout"; }?>" href="<?=root.('bookings')?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 12H16c-.7 2-2 3-4 3s-3.3-1-4-3H2.5"/><path d="M5.5 5.1L2 12v6c0 1.1.9 2 2 2h16a2 2 0 002-2v-6l-3.4-6.9A2 2 0 0016.8 4H7.2a2 2 0 00-1.8 1.1z"/></svg> <?=T::mybookings?></a></li>
    <!-- <li class="user_wallet d-none"><a class="py-2 <?php if (isset($meta['add_funds'])) { echo "avtive btn btn-primary w-100 d-block fadeout"; }else{ echo "btn btn-outline-dark w-100 d-block fadeout"; }?>" href="<?=root.('wallet')?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V6l-3-4H6zM3.8 6h16.4M16 10a4 4 0 1 1-8 0"/></svg> <?=T::add_funds?></a></li> -->
    <li class=""><a class="py-2 <?php if (isset($meta['profile_active'])) { echo "active btn btn-primary w-100 d-block fadeout"; }else{ echo "btn btn-outline-dark w-100 d-block fadeout"; }?>" href="<?=root.('profile')?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/></svg> <?=T::myprofile?></a></li>
    <li class=""><a class="py-2 fadeout btn btn-outline-dark w-100 d-block mb-2" href="<?=root.('logout')?>"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9"/></svg> <?=T::logout?></a></li>
</ul>
</div>

<!-- ================================
       END DASHBOARD NAV
================================= -->

<style>
.header-area{position:relative;z-index:9999;}
.info-area.info-bg {display:none}
.cta-area,.header-top-bar,.footer-area{display:none}
.header-menu-wrapper{padding: 0 50px}
.menu-sidebar { display:none }
body { background: #f3f5fd; }
</style>

<script>
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var x = new Date()
document.getElementById('ct').innerHTML = x;
display_c(); }

// console.log(location.pathname.split("/")[2])
</script>