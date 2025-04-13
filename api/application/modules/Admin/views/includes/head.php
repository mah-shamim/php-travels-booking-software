<nav class="navbar navbar-inverse navbar-fixed-top bg-dark" style="background:#005bea;height:45px">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url().$this->uri->segment(1);?>"><i class="fa fa-desktop"></i> <strong><small>DASHBOARD</small></strong></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class=""><a href="javascript:void(0);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="sr-only">(current)</span></a></li>
                <?php if ($isadmin) { ?>
                <?php if ($isSuperAdmin) {?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> &nbsp;<?php echo trans('04'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdowns-menu">
                        <li> <a href="<?php echo base_url(); ?>admin/settings/"><i class="fa fa-cog"></i> <?php echo trans('03'); ?> <?php echo trans('04'); ?></a> </li>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/modules/"><i class="fa fa-cube"></i> <?php echo trans('08'); ?></a></li>
                        <?php $chkupdates = checkUpdatesCount();if ($chkupdates->showUpdates) {if ($isSuperAdmin) {?>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/updates/"><i class="fa fa-refresh"></i>
                            <span>Updates</span><span class="pull-right label label-danger" id="updatescount"><?php if ($chkupdates->count > 0) {echo $chkupdates->count;} ;?></span>
                            </a>
                        </li>
                        <?php }}?>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/currencies/"><i class="fa fa-dollar"></i> Currencies</a> </li>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/paymentgateways/"><i class="fa fa-money"></i> <?php echo trans('05'); ?></a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/social/"><i class="fa fa-link"></i> <?php echo trans('07'); ?></a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/widgets/"><i class="fa fa-window-restore"></i> <?php echo trans('010'); ?></a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/settings/sliders/"><i class="fa fa-image"></i> Homepage Sliders</a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/templates/email/"><i class="fa fa-envelope"></i> <?php echo trans('012'); ?></a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/templates/sms_settings/"><i class="fa fa-comment"></i> SMS API Settings</a></li>
                        <li> <a href="<?php echo base_url(); ?>admin/backup/"><i class="fa fa-refresh"></i> BackUp</a></li>
                        <!--<li><a href="<?php echo base_url(); ?>admin/banip/">Ban IP</a></li>-->
                        <!-- <?php if($this->uri->segment(1) != 'admin' ){ ?>
                            <li><a href="<?php echo base_url(); ?>supplier/widget"><i class="fa fa-code w30"></i> Widgets <span class="pull-right label label-danger"></span></a></li>
                            <?php } ?>-->
                    </ul>
                </li>
                <?php }?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i> &nbsp; <?php echo trans('017'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdowns-menu">
                        <?php if ($role != "admin") {?>
                        <li><a href="<?php echo base_url(); ?>admin/accounts/admins/">Admins</a></li>
                        <?php }?>
                        <li><a href="<?php echo base_url(); ?>admin/accounts/suppliers/"><?php echo trans('023'); ?></a></li>
                        <li><a href="<?php echo base_url(); ?>admin/accounts/agents/">Agents</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/accounts/customers/"><?php echo trans('025'); ?></a></li>
                        <li><a href="<?php echo base_url(); ?>admin/accounts/guest/"><?php echo trans('027'); ?> <?php echo trans('025'); ?></a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-alt w20"></i><?php echo trans('013'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdowns-menu">
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
                <?php $urisegment = $this->uri->segment(1); foreach ($module_data as $key) { ?>
                <li class="dropdown">
                    <a href="javascript:void(0);#<?php echo $key->name; ?>module" class="dropdown-toggle" data-toggle="dropdown"><i class="w20 <?=$key->icon;?>"></i><?php echo $key->name; ?> <b class="caret"></b></a>
                    <ul id="<?php echo $key->name; ?>module" class="dropdown-menu dropdowns-menu">
                        <!-- //////////////////////////////sub module code////////////////////// -->
                        <!-- <li><a href="<?=base_url();?>admin/<?php echo $key->name; ?>/booking" style="color: #0066FF"><i class="fa fa-list w30" style="text-align:center;color: black !important;"></i>Bookings</a></li> -->
                        <?php foreach ($submodule_data as $sub_key) {
                            if ($sub_key->parent_id == $key->parent_id) { ?>
                        <li class="dropdown-submenu">
                            <a href="#<?php echo $sub_key->name; ?>" tabindex="-1" href="javascript:void(0);" class="dropdown-submenu-toggle">
                                <i class="w20 <?=$sub_key->menus->icon;?>" style="text-align:center;color: black !important;display:none"></i><?php echo $sub_key->label; ?> <!--<b class="caret"></b>-->
                            </a>
                            <?php if ($urisegment == "admin" && !empty($sub_key->menus->admin)) {?>
                            <ul id="<?php echo $sub_key->name; ?>" class="dropdown-menu">
                                <?php foreach ($sub_key->menus->admin as $menu): ?>
                                <?php if ($menu->label!= 'Bookings') {?>
                                <li><a href="<?=base_url($menu->link);?>"><?php echo $menu->label;?></a></li>
                                <?php } ?>
                                <?php endforeach;?>
                            </ul>
                            <?php } else if (!empty($sub_key->menus->supplier)) {?>
                            <ul id="<?php echo $sub_key->name; ?>" class="dropdown-menu">
                                <?php foreach ($sub_key->menus->supplier as $menu): ?>
                                <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                                <?php endforeach;?>
                            </ul>
                            <?php }?>
                        </li>
                        <?php } }?>
                        <li class="divider"></li>
                        <?php if ($isSuperAdmin) {?>
                        <!-- //////////////////////////////sub module code end////////////////////// -->

                        <?php if ($key->name == "hotels" ) { ?>
                        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/locations"><i class="fa fa-map w20"></i>Locations</a></li>
                        <?php } ?>

                        <?php if ($key->name == "cars" ) { ?>
                        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/locations"><i class="fa fa-map w20"></i>Locations</a></li>
                        <?php } ?>

                        <?php if ($key->name == "tours" ) { ?>
                        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/locations"><i class="fa fa-map w20"></i>Locations</a></li>
                        <?php } ?>

                        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/<?php echo $key->name; ?>/booking"><i class="fa fa-list w20"></i>Bookings</a></li>
                        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/<?php echo $key->name; ?>/searches"><i class="fa fa-search w20"></i>Searches</a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php }?>

                 <!--
                <?php if ($isSuperAdmin) {?>
                <?php  foreach ($module_extra as $modl) { ?>
                <li class="dropdown">
                    <a href="javascript:void(0);#<?php echo $modl->name; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="w20 <?=$modl->menus->icon;?>"></i><?php echo $modl->label; ?> <span class="caret"></span></a>
                    <?php if ($urisegment == "admin" && !empty($modl->menus->admin)) {?>
                    <ul id="<?php echo $modl->name; ?>" class="dropdown-menu dropdowns-menu">
                        <?php foreach ($modl->menus->admin as $menu): ?>
                        <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                        <?php endforeach;?>
                    </ul>
                    <?php } else if (!empty($modl->menus->supplier)) {?>
                    <ul id="<?php echo $modl->name; ?>" class="dropdown-menu dropdowns-menu">
                        <?php foreach ($modl->menus->supplier as $menu): ?>
                        <li><a href="<?=base_url($menu->link);?>"><?=$menu->label;?></a></li>
                        <?php endforeach;?>
                    </ul>
                    <?php }?>
                </li>
                <?php }?>
                <?php }?>
                -->

                <?php if ($isSuperAdmin) {?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bullseye"></i> Marketing <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdowns-menu">
                        <!--<li class="dropdown-submenu">
                            <a tabindex="-1" href="javascript:void(0);" class="dropdown-submenu-toggle">Second Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                    <li><a href="#">Sub-Menu Item</a></li>
                                    <li><a href="#">Sub-Menu Item</a></li>
                                    <li><a href="#">Sub-Menu Item</a></li>
                            </ul>
                            </li>-->
                        <?php if ($isadmin && $role != "admin") { if (isModuleActive('offers')) {?>
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="javascript:void(0);" class="dropdown-submenu-toggle"><i class="fa fa-gift"></i> Offers</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>admin/offers/"><?php echo trans('029'); ?> <?php echo trans('030'); ?></a></li>
                                <li><a href="<?php echo base_url(); ?>admin/offers/settings/"><?php echo trans('030'); ?> <?php echo trans('04'); ?></a></li>
                            </ul>
                        </li>
                        <?php }if (isModuleActive('coupons')) {?>
                        <li><a href="<?php echo base_url(); ?>admin/coupons/"><i class="fa fa-asterisk"></i> Coupons</a></li>
                        <?php }}?>
                        <?php if ($isadmin) {if (isModuleActive('newsletter')) {?>
                        <?php if (pt_permissions('newsletter', @$userloggedin)) {?>
                        <li><a href="<?php echo base_url(); ?>admin/newsletter/"><i class="fa fa-envelope"></i> <?php echo trans('031'); ?> <span class="pull-right label label-danger" id=""></span></a></li>
                        <?php }}}?>
                    </ul>
                </li>
                <?php if (isModuleActive('blog')) {?>
                        <li><a href="<?php echo base_url(); ?>admin/blog/"><i class="fa fa-columns"></i> Blog</a></li>
                        <?php }?>
                <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($isSuperAdmin)
                    if (empty($supplier)) {
                    if (isModuleActive('hotels') ||  isModuleActive('tours') || isModuleActive('cars') ) {
                    ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown"><span class="ink animate"></span><i class="fa fa-money w30"></i> Payouts<i class="fa fa-angle-right pull-right menu-icon"></i></a>
                    <ul class="dropdown-menu">
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
                <?php if (pt_permissions('booking', @$userloggedin)) {?>
                <li><a href="<?php echo base_url() . $this->uri->segment(1); ?>/bookings"><i class="fa fa-list w30"></i> <?php echo trans('034'); ?><span class="pull-right label label-danger" id=""></span></a></li>
                <?php }?>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /container -->
</nav>