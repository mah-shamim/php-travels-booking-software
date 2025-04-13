<div class="sidebar-header">
    <img style="float: left; margin-right: 10px; max-width: 33px;border-radius:5px;margin-left: 12px;" src="<?php echo base_url(); ?>uploads/global/favicon.png" class="hlogo_preview_img img-fluid brand-logos favicon">
    <h5 style="margin-top:0px;font-weight: bold;">Administrator<br><small style="text-transform: uppercase; letter-spacing: 1px;">Console</small></h5>
</div>
<!--<div class="root">
    <a href="<?php echo base_url().$this->uri->segment(1);?>/profile/">
        <i class="fa fa-user-circle-o pull-left" style="left:5px"></i>
        <p><strong><?php echo $this->session->userdata('fullName'); ?></strong> Current User</p>
    </a>
</div>-->
<div class="social-sidebar">
    <!--<div class="search-sidebar">
        <form class="search-sidebar-form has-icon filterform" onsubmit="return false;">
            <label for="sidebar-query" class="fa fa-search"></label>
            <input id="sidebar-query" type="text" placeholder="Search" class="form-control search-query filtertxt">
        </form>
    </div>-->
    <ul id="social-sidebar-menu" class="list-unstyled components">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>"><i class="fa fa-desktop"></i> <strong>Dashboard</strong></a></li>



        <?php if ($isadmin) {?>
        <?php $chkupdates = checkUpdatesCount();if ($chkupdates->showUpdates) {if ($isSuperAdmin) {?>
        <li>
            <a href="<?php echo base_url(); ?>admin/updates/"><i class="fa fa-refresh"></i>
                <span>Updates</span><span class="pull-right label label-danger" id="updatescount"><?php if ($chkupdates->count > 0) {echo $chkupdates->count;} ;?></span>
            </a>
        </li>
        <?php }}?>
        <?php if ($isSuperAdmin) {?>
        <li> <a href="<?php echo base_url(); ?>admin/settings/modules/"><i class="fa fa-cube"></i> <?php echo trans('08'); ?></a></li>
        <li>
            <a href="#menu-ui" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cog"></i> <?php echo trans('03'); ?></a>
            <ul id="menu-ui" class="collapse wow fadeIn animated list-unstyled">
                <li> <a href="<?php echo base_url(); ?>admin/settings/"><?php echo trans('04'); ?></a> </li>
                <li> <a href="<?php echo base_url(); ?>admin/settings/currencies/">Currencies</a> </li>
                <li> <a href="<?php echo base_url(); ?>admin/settings/paymentgateways/"><?php echo trans('05'); ?></a></li>
                <li> <a href="<?php echo base_url(); ?>admin/settings/social/"><?php echo trans('07'); ?></a></li>
                <li> <a href="<?php echo base_url(); ?>admin/settings/widgets/"><?php echo trans('010'); ?></a></li>
                <li> <a href="<?php echo base_url(); ?>admin/settings/sliders/">Homepage Sliders</a></li>
                <li> <a href="<?php echo base_url(); ?>admin/templates/email/"><?php echo trans('012'); ?></a></li>
                <li> <a href="<?php echo base_url(); ?>admin/templates/sms_settings/">SMS API Settings</a></li>
                <li> <a href="<?php echo base_url(); ?>admin/backup/">BackUp</a></li>
                <li><a href="<?php echo base_url(); ?>admin/banip/">Ban IP</a></li>
                <!--<?php if (pt_permissions('locations', @$userloggedin)) {?>
                <li><a href="<?php echo base_url() . $this->uri->segment(1); ?>/locations"><i class="fa fa-map-marker w30"></i> Locations<span class="pull-right label label-danger"></span></a></li>
                <?php }?>-->
            </ul>
        </li>
        <!--<li>
            <a data-toggle="collapse" aria-expanded="false" href="#REPORTS"><i class="fa fa-file-o w30"></i> Reports<i class="fa fa-angle-right pull-right menu-icon"></i></a>
            <ul id="REPORTS" class="collapse wow fadeIn animated list-unstyled">
                <li><a href="<?php echo base_url(); ?>admin/reports/accounts">Accounts</a></li>
                <li><a href="<?php echo base_url(); ?>admin/reports/bookings">Bookings</a></li>
                <li><a href="<?php echo base_url(); ?>admin/reports/payouts">Payouts</a></li>
            </ul>
        </li>-->
        <?php }?>
        <li>
            <a data-toggle="collapse"  aria-expanded="false" href="#ACCOUNTS"><i class="fa fa-user-circle"></i> <?php echo trans('017'); ?>
            </a>
            <ul id="ACCOUNTS" class="collapse wow fadeIn animated list-unstyled">
                <?php if ($role != "admin") {?>
                <li><a href="<?php echo base_url(); ?>admin/accounts/admins/">Admins</a></li>
                <?php }?>
                <li><a href="<?php echo base_url(); ?>admin/accounts/suppliers/"><?php echo trans('023'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>admin/accounts/agents/">Agents</a></li>
                <li><a href="<?php echo base_url(); ?>admin/accounts/customers/"><?php echo trans('025'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>admin/accounts/guest/"><?php echo trans('027'); ?><?php echo trans('025'); ?></a></li>
            </ul>
        </li>
        <li>
            <a href="#CMS" data-toggle="collapse" aria-expanded="false"><i style="width:30px" class="fa fa-list-alt w30"></i><span><?php echo trans('013'); ?></span></a>
            <ul id="CMS" class="collapse wow fadeIn animated list-unstyled">
                <li><a href="<?php echo base_url(); ?>admin/cms"><?php echo trans('015'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>admin/cms/menus/manage"><?php echo trans('016'); ?></a></li>
            </ul>
        </li>
        <?php } ?>





        <?php $module_data = []; $submodule_data = []; $module_extra = []; if (empty($supplier)) {
        $moduleslist = app()->service('ModuleService')->all();
        $baseurl = base_url();
        $urisegment = $this->uri->segment(1);
        $hotels =1; $flights =1; $tours =1; $cars =1; $visa =1; $cruise =1; $rental =1;
        foreach ($moduleslist as $modl) {
        $isenabled = isModuleActive($modl->name);
        if ($isenabled) {
        if (pt_permissions($modl->name, $userloggedin) && !in_array(strtolower($modl->name), ['offers', 'newsletter', 'coupons', 'reviews'])) {
        if ($modl->parent_id == 'hotels' && $hotels ==1) {
        array_push($module_data, (object)[
        'name'=>'hotels',
        'icon'=>'fa fa-building-o',
        'parent_id'=>'hotels']);
        $hotels++;}
        if ($modl->parent_id == 'hotels') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'flights' && $flights ==1) {
        array_push($module_data, (object)[
        'name'=>'flights',
        'icon'=>'fa fa-plane',
        'parent_id'=>'flights']);
        $flights++;}
        if ($modl->parent_id == 'flights') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'tours' && $tours ==1) {
        array_push($module_data, (object)[
        'name'=>'tours',
        'icon'=>'fa fa-suitcase',
        'parent_id'=>'tours']);
        $tours++;}
        if ($modl->parent_id == 'tours') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'cars' && $cars ==1) {
        array_push($module_data, (object)[
        'name'=>'cars',
        'icon'=>'fa fa-car',
        'parent_id'=>'cars']);
        $cars++;}
        if ($modl->parent_id == 'cars') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'visa' && $visa ==1) {
        array_push($module_data, (object)[
        'name'=>'visa',
        'icon'=>'fa fa-tag',
        'parent_id'=>'visa']);
        $visa++;}
        if ($modl->parent_id == 'visa') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'cruise' && $cruise ==1) {
        array_push($module_data, (object)[
        'name'=>'cruise',
        'icon'=>'fa fa-suitcase',
        'parent_id'=>'cruise']);
        $cruise++;}
        if ($modl->parent_id == 'cruise') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'rental' && $rental ==1) {
        array_push($module_data, (object)[
        'name'=>'rental',
        'icon'=>'fa fa-suitcase',
        'parent_id'=>'rental']);
        $rental++;}
        if ($modl->parent_id == 'rental') {array_push($submodule_data, $modl);}
        if ($modl->parent_id == 'extra') {
        array_push($module_extra, $modl);}
        }
        }
        }
        }?>
        <!-- ///////////////////////////////////////////// -->
        <!-- //////////////////Main module Work///////////////-->
        <!-- //////////////////////////////////////////// -->
        <?php $urisegment = $this->uri->segment(1);
        foreach ($module_data as $key) { ?>
        <li>
            <a href="#<?php echo $key->name; ?>module" data-toggle="collapse" aria-expanded="false"><i class="w30 <?=$key->icon;?>"></i><?php echo $key->name; ?></a>
            <ul id="<?php echo $key->name; ?>module" class="collapse wow fadeIn animated list-unstyled">
                <!-- //////////////////////////////sub module code////////////////////// -->
                
                <!-- <li><a href="<?=base_url();?>admin/<?php echo $key->name; ?>/booking" style="color: #0066FF"><i class="fa fa-list w30" style="text-align:center;color: black !important;"></i>Bookings</a></li> -->
                <?php foreach ($submodule_data as $sub_key) {
                if ($sub_key->parent_id == $key->parent_id) { ?>
                <li>
                    <a href="#<?php echo $sub_key->name; ?>" data-toggle="collapse" aria-expanded="false"><i class=" w30 <?=$sub_key->menus->icon;?>" style="text-align:center;color: black !important;display:none"></i><?php echo $sub_key->label; ?></a>

                    <?php if ($urisegment == "admin" && !empty($sub_key->menus->admin)) {?>
                    <ul id="<?php echo $sub_key->name; ?>" class="collapse wow fadeIn animated list-unstyled">
                        
                        <?php foreach ($sub_key->menus->admin as $menu): ?>
                        <?php if ($menu->label!= 'Bookings') {?>
                        <li><a href="<?=base_url($menu->link);?>" style="color: #0066FF"><?php echo $menu->label;?></a></li>
                        <?php } ?>

                        <?php endforeach;?>

                    </ul>
                    <?php } else if (!empty($sub_key->menus->supplier)) {?>
                    <ul id="<?php echo $sub_key->name; ?>" class="collapse wow fadeIn animated list-unstyled">
                        <?php foreach ($sub_key->menus->supplier as $menu): ?>
                        <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                        <?php endforeach;?>
                    </ul>
                    <?php }?>
                </li>
                <?php } }?>

                <li class="divider"></li>
                <!-- //////////////////////////////sub module code end////////////////////// -->
                <li><a href="<?=base_url();?>admin/<?php echo $key->name; ?>/booking" style="color: #0066FF"><i class="fa fa-list w30" style="text-align:center;color: black !important; display:none"></i>Bookings</a></li>
                <li><a href="<?=base_url();?>admin/<?php echo $key->name; ?>/searches" style="color: #0066FF"><i class="fa fa-search w30" style="text-align:center;color: black !important; display:none"></i>Searches</a></li>
            </ul>
        </li>
        <?php }?>
        <!-- //////////////////////////////////////////////////// -->
        <!-- //////////////////Main module Work end///////////////-->
        <!-- //////////////////////////////////////////////////// -->
<!--___________________________________________________________________________________________________-->
        <!-- //////////////////extra module Work///////////////-->
        <?php
        foreach ($module_extra as $modl) { ?>
        <li>
            <a href="#<?php echo $modl->name; ?>" data-toggle="collapse" aria-expanded="false"><i class="w30 <?=$modl->menus->icon;?>"></i><?php echo $modl->label; ?></a>
            <?php if ($urisegment == "admin" && !empty($modl->menus->admin)) {?>
            <ul id="<?php echo $modl->name; ?>" class="collapse wow fadeIn animated list-unstyled">
                <?php foreach ($modl->menus->admin as $menu): ?>
                <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                <?php endforeach;?>
            </ul>
            <?php } else if (!empty($modl->menus->supplier)) {?>
            <ul id="<?php echo $modl->name; ?>" class="collapse wow fadeIn animated list-unstyled">
                <?php foreach ($modl->menus->supplier as $menu): ?>
                <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                <?php endforeach;?>
            </ul>
            <?php }?>
        </li>
        <?php }?>
        <!-- //////////////////////////////////////////////////// -->
        <!-- //////////////////extra module Work end///////////////-->
        <!-- //////////////////////////////////////////////////// -->




        <?php if ($isadmin && $role != "admin") { if (isModuleActive('offers')) {?>
        <li>
            <a data-toggle="collapse" aria-expanded="false" href="#SPECIAL_OFFERS"><i class="fa fa-gift w30"></i> Offers<i class="fa fa-angle-right pull-right menu-icon"></i></a>
            <ul id="SPECIAL_OFFERS" class="collapse wow fadeIn animated list-unstyled">
                <li><a href="<?php echo base_url(); ?>admin/offers/"><?php echo trans('029'); ?> <?php echo trans('030'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>admin/offers/settings/"><?php echo trans('030'); ?> <?php echo trans('04'); ?></a></li>
            </ul>
        </li>
        <?php }if (isModuleActive('coupons')) {?>
        <!--<li><a href="<?php echo base_url(); ?>admin/coupons/"><i class="fa fa-asterisk"></i> Coupons</a></li>-->
        <?php }}?>


        
        <?php if ($isadmin) {if (isModuleActive('newsletter')) {?>
        <?php if (pt_permissions('newsletter', @$userloggedin)) {?>
        <li><a href="<?php echo base_url(); ?>admin/newsletter/"><i class="fa fa-envelope"></i> <?php echo trans('031'); ?> <span class="pull-right label label-danger" id=""></span></a></li>
        <?php }}}?>
        <?php if (pt_permissions('booking', @$userloggedin)) {?>
        <li><a href="<?php echo base_url() . $this->uri->segment(1); ?>/bookings"><i class="fa fa-list w30"></i> <?php echo trans('034'); ?><span class="pull-right label label-danger" id=""></span></a></li>
        <?php }?>
        <?php if($this->uri->segment(1) != 'admin' ){ ?>
        <li><a href="<?php echo base_url(); ?>supplier/widget"><i class="fa fa-code w30"></i> Widgets <span class="pull-right label label-danger"></span></a></li>
        <?php } ?>



        <?php if ($isSuperAdmin)
        if (empty($supplier)) {
        if (isModuleActive('hotels') ||  isModuleActive('tours') || isModuleActive('cars') ) {
        ?>
        <li>
            <a data-toggle="collapse" aria-expanded="false" href="#PAYOUTS" class="collapsed"><span class="ink animate"></span><i class="fa fa-money w30"></i> Payouts<i class="fa fa-angle-right pull-right menu-icon"></i></a>
            <ul id="PAYOUTS" class="wow fadeIn animated list-unstyled collapse" aria-expanded="false" style="height: 0px;">
                <?php if (empty($supplier)) {
                $moduleslist = app()->service('ModuleService')->all();
                foreach ($moduleslist as $modl) {
                $isenabled = isModuleActive($modl->name);
                if ($isenabled) {
                if (pt_permissions($modl->name, $userloggedin) && in_array(strtolower($modl->name), ['hotels', 'tours', 'cars']) ) { ?>
                <li>
                    <a href="admin/payouts/unpaid/<?php echo strtolower($modl->name); ?>"><?php echo $modl->label; ?></a>
                </li>
                <?php } } } } ?>
            </ul>
        </li>
        <?php } } ?>
    </ul>
</div>
<!--<ul class="list-unstyled CTAs">
    <li><a style="position:fixed;bottom:30px;width:210px;" target="_blank" href="https://phptravels.com/documentation/" class="article"><i style="margin-top:0px" class="fa fa-chevron-left"></i> Documentation</a></li>
</ul>-->