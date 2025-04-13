<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('menu_get_header_items'))
{
    function menu_get_header_items()
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_all_header_items();
    return $res;
    }
}

if ( ! function_exists('demo_header'))
{
    function demo_header()
    {
        $CI = get_instance();
        if ($CI->config->item('is_demo') == 1 || $CI->config->item('base_url') == 'https://www.phptravels.net/') {

           require "demo.php";
        }
    }
}
if ( ! function_exists('google_tag'))
{
    function google_tag()
    {
        $CI = get_instance();
        if ($CI->config->item('is_demo') == 1 || $CI->config->item('base_url') == 'https://www.phptravels.net/') {
            require "header_demo.php";
        }
    }
}
if ( ! function_exists('get_title_in_lang'))
{
    function get_title_in_lang($pageid,$langid)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_title_in_lang($pageid,$langid);
    return $res;
    }
}
if (!function_exists("get_airline_name")) {
    function get_airline_name($k)
    {
        $data = file_get_contents(FCPATH."application/json/airlines.json");
        $data = json_decode($data, true);
        $final = array_filter($data, function ($a) use ($k) {
            return (in_array($a['id'], (array)$k));
        });
        foreach ($final as $value) {
            $name = $value['name'];
        }
        return $name;
    }
}
if ( ! function_exists('get_menu_items'))
{
    function get_menu_items($col,$type)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_menu_items($col,$type);
    return $res;
    }
}

if ( ! function_exists('get_non_menu_items'))
{
    function get_non_menu_items()
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_non_menu_items();
    return $res;
    }
}



if ( ! function_exists('show_footer_cols_label'))
{
    function show_footer_cols_label($col)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->show_footer_cols_label($col);
    return $res;
    }
}


if ( ! function_exists('has_child'))
{
    function pt_has_child($pageid)
    {
    $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->has_child($pageid);
    return $res;

    }
}

if ( ! function_exists('pt_get_footer_labels'))
{
    function pt_get_footer_labels()
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_footer_menus_label();
    return $res;

    }
}


if ( ! function_exists('get_child_pages'))
{
    function pt_get_child_pages($pageid,$langid)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_child_pages($pageid,$langid);
    return $res;
    }
}

// Get all child pages of cms

if ( ! function_exists('pt_get_all_parents'))
{
    function pt_get_all_parents()
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_all_parents();
    return $res;
    }
}



// If module is enabled or disabled

if ( ! function_exists('pt_is_module_enabled'))
{
    function pt_is_module_enabled($module)
    {
      $CI = get_instance();

    $CI->load->model('Admin/Modules_model');

   $modres = $CI->Modules_model->check_module($module);

    return $modres;
    }
}

// If module is available

if ( ! function_exists('pt_is_module_available'))
{
    function pt_is_module_available($module)
    {
      $CI = get_instance();

   $modres = $CI->ptmodules->is_module_available($module);

    return $modres;
    }
}



if ( ! function_exists('get_page_details'))
{
    function get_page_details($id)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    return $CI->Menus_model->get_page_details($id);

    }
}
if ( ! function_exists('get_page_details_api'))
{
    function get_page_details_api($id,$lang)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    return $CI->Menus_model->get_page_details_api($id,$lang);

    }
}


if ( ! function_exists('child_page_active'))
{
    function child_page_active($pages)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    return $CI->Menus_model->child_page_active($pages);

    }
}


if ( ! function_exists('getHeaderMenu'))
{
    function getHeaderMenu($lang_set)
    {

      $result = new stdClass;
      $icons = TRUE;
      $CI = get_instance();
      $CI->load->model('Helpers_models/Menus_model');
      $res = $CI->Menus_model->get_header_menu();
       $result->hasMenu = TRUE;
      if(!empty($res))
      {
        $result->hasMenu = TRUE;
        $menuItems = json_decode($res[0]->menu_items);
        // Menu status in header
        $status = $CI->Menus_model->get_header_menu_status();
        foreach($menuItems as $hm)
        {
            if ($status[$hm->id] == 1)
            {
                $pageDetails =  get_page_details($hm->id);
                foreach($pageDetails as $pagesinfo)
                {
                  $parent = parent_info($pagesinfo,$icons,$lang_set);
                  $ischildactive = child_page_active($hm->children);
                  $activeLinkClass = pt_active_link($pagesinfo->page_slug);
                  if(!empty($hm->children))
                  {
                    $hasChild = TRUE;

                    foreach($hm->children as $ch)
                    {
                      $children =  get_page_details($ch->id);
                      foreach($children as $childinfo)
                      {
                        $child = child_info($childinfo,$icons,$lang_set);

                        $childrenInfo[] = (object)array('id' => $ch->id,
                          'title' => $child['childtitle'],
                          'hrefLink' => $child['hrefchild'],
                          'target' => $child['childtarget'],
                          'icon' => $child['icons']
                          );
                      }
                    }
                  }
                  else
                  {
                    $hasChild = FALSE;
                    $childrenInfo = array();
                  }

                  if(!empty($hm->children) && $ischildactive)
                  {
                    $dropdownmenu = "dropdown-menu";
                    $dropdown = "dropdown";
                    $dropdowntoggle = "dropdown-toggle";
                    $datatoggle = "data-toggle='dropdown'";
                    $caret = "<span class='caret'></span>";
                  }
                  else
                  {
                    $dropdownmenu = "";
                    $dropdown = "";
                    $dropdowntoggle = "";
                    $datatoggle = "";
                    $caret = "";
                  }

                  $result->pagesInfo[] = (object)array(
                    'id' => $hm->id,
                    'title' =>  $parent['pagetitle'],
                    'children' => $childrenInfo,
                    'hasChild' => $hasChild,
                    'activeLinkClass' => $activeLinkClass,
                    'hrefLink' => $parent['hreflink'],
                    'target' => $parent['target'],
                    'icon' => $parent['icons'],
                    'dropdown' => $dropdown,
                    'dropdownmenu' => $dropdownmenu,
                    'dropdowntoggle' => $dropdowntoggle,
                    'datatoggle' => $datatoggle,
                    'caret' => $caret,
                  );
              }
          } // End: if ($status[$hm->id] == 1)
        } // End: loop
      }

      return $result;

    }
}


if ( ! function_exists('get_footer_menus'))
{
    function get_footer_menus($id)
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_footer_menus($id);
    return $res;
    }
}

if ( ! function_exists('get_footer_horizontal'))
{
    function get_footer_horizontal()
    {
      $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

    $res = $CI->Menus_model->get_footer_horizontal();
    return $res;
    }
}


/*****************************

Header menu items template
@icons - true/false
@childul - Class applied to child ul tag

******************************/



if ( ! function_exists('parent_info'))
{
    function parent_info($pagesinfo,$icons,$lang_set)
    {
        $result = array();
        $ptitle = $pagesinfo->content_page_title;

        if($pagesinfo->content_special == '1')
        {
            $result['pagetitle'] = trans($pagesinfo->content_page_title);
            $arrayFrom = array("ean",  "flightsdohop","cartrawler","travelstart","hotelscombined","wegoflights","travelpayouts","travelport_flight");
            $arrayTo   = array(EANSLUG,"flightsd",     "car",       "flightst",   "hotelsc",       "flightsw",   "air",        "flight");
            $pageSlug  = str_replace($arrayFrom, $arrayTo, $pagesinfo->page_slug);
            if(empty($result['pagetitle']))
            {
                $result['pagetitle'] = $pagesinfo->content_page_title;
            }

            $pptitle = str_replace(" ","",$ptitle);
            $result['icons'] = pt_get_icon(strtolower($pptitle));
            $result['target'] = pt_linktarget(strtolower($pptitle));
            $result['hreflink'] = base_url().$pageSlug;
        }
        else
        {
            $result['pagetitle'] = get_title_in_lang($pagesinfo->page_id,$lang_set);
            $externalink = $pagesinfo->page_external_link;
            if(!empty($externalink))
            {
              $result['hreflink'] = $externalink;
              $result['target'] = "_".$pagesinfo->page_target;
            }
            else
            {
              $result['target'] = "";
              $result['hreflink'] = base_url().$pagesinfo->page_slug;
            }
            $result['icons']  = $pagesinfo->page_icon;
        }

          if(!$icons)
          {
            $result['icons'] = "";
          }

        return $result;
    }


}


if ( ! function_exists('child_info'))
{
    function child_info($child,$icons,$lang_set)
    {
               $result = array();

                if($child->content_special == '1'){
                 $result['childtitle'] = trans($child->content_page_title);
                  if(empty($result['childtitle'])){
                  $result['childtitle'] = $child->content_page_title;

                  }
                    $pptitle = str_replace(" ","",$child->content_page_title);
               $result['icons']  = pt_get_icon(strtolower($pptitle));
                  $result['childtarget'] = pt_linktarget(strtolower($pptitle));
                   $result['hrefchild'] = base_url().$child->page_slug;
                 }else{
                $result['childtitle'] = get_title_in_lang($child->page_id,$lang_set);
                $childexternal = $child->page_external_link;
                if(!empty($childexternal)){
                 $result['hrefchild'] = $childexternal;
                $result['childtarget'] = "_".$child->page_target; }else{
                 $result['childtarget'] = "";
                  $result['hrefchild'] = base_url().$child->page_slug;
                }
                $result['icons']  = $child->page_icon;
                 }
                   if(!$icons){
                  $result['icons'] = "";
                 }

           return $result;
    }


}


if ( ! function_exists('get_header_menu_items'))
{
    function get_header_menu_items($useicons,$childul = null)
    {
    $CI = get_instance();

     $CI->load->model('Helpers_models/Menus_model');
     $lang_set = $CI->theme->_data['lang_set'];
     $hmenu = get_header_menu();

     if(!empty($hmenu)){

                  $menuitems = json_decode($hmenu[0]->menu_items);
                  if(!empty($menuitems)){
                    foreach($menuitems as $hm){
                        $pinfo =  get_page_details($hm->id);
                 foreach($pinfo as $pagesinfo){

                $icons = ''; $ptitle  = $pagesinfo->content_page_title;

                if($pagesinfo->content_special == '1'){
                 $pagetitle = trans($pagesinfo->content_page_title);
                  if(empty($pagetitle)){
                  $pagetitle = $pagesinfo->content_page_title;

                  }
                    $pptitle = str_replace(" ","",$ptitle);
                $icons = pt_get_icon(strtolower($pptitle));
                   $target = pt_linktarget(strtolower($pptitle));
                   $hreflink = base_url().$pagesinfo->page_slug;
                 }else{
                $pagetitle = get_title_in_lang($pagesinfo->page_id,$lang_set);
                $externalink = $pagesinfo->page_external_link;
                if(!empty($externalink)){
                $hreflink = $externalink;
                $target = "_".$pagesinfo->page_target; }else{
                $target = "";
                $hreflink = base_url().$pagesinfo->page_slug;
                 }
                $icons  = $pagesinfo->page_icon;
                 }
                if($useicons == "yes"){
                   $icons = $icons;
                 }else{
                   $icons = "";
                 }

           ?>
              <li>
                <a href="<?php echo $hreflink;?>" class="<?php pt_active_link($pagesinfo->page_slug);?>" target="<?php echo $target;?>" ><i class='<?php  echo $icons;?>'></i><strong><?php echo  $pagetitle;?></strong> </a>
                <?php if(!empty($hm->children)){  ?>
                <ul class="<?php echo $childul;?>">
                  <?php foreach($hm->children as $ch){
                     $children =  get_page_details($ch->id);
                   // $grandchild = pt_get_child_pages($child->page_id,$lang_set);
                     foreach($children as $child){

                   if($child->content_special == '1'){
                 $childtitle = trans($child->content_page_title);
                  if(empty($childtitle)){
                  $childtitle = $child->content_page_title;

                  }
                    $pptitle = str_replace(" ","",$child->content_page_title);
                $icons = pt_get_icon(strtolower($pptitle));
                   $childtarget = pt_linktarget(strtolower($pptitle));
                   $hrefchild = base_url().$child->page_slug;
                 }else{
                $childtitle = get_title_in_lang($child->page_id,$lang_set);
                $childexternal = $child->page_external_link;
                if(!empty($childexternal)){
                $hrefchild = $childexternal;
                $childtarget = "_".$child->page_target; }else{
                 $childtarget = "";
                 $hrefchild = base_url().$child->page_slug;
                }
                $icons  = $child->page_icon;
                 }
                   if($useicons == "yes"){
                   $icons = $icons;
                 }else{
                   $icons = "";
                 }
                  ?>
                  <li style="min-width:200px" >
                    <a href="<?php echo $hrefchild;?>" target="<?php echo $childtarget;?>" ><i class='<?php echo $icons;?>'></i> <?php echo  $childtitle;?> </a>
                   </li>
                  <?php } } ?>
                </ul>
                <?php } ?>
              </li>

<?php } } } } } }

/*****************************

Starting Footer menu items template

******************************/

// Get Footer Menu Items


if ( ! function_exists('get_footer_menu_items'))
{
    function get_footer_menu_items($id = null,$divclass = null, $titleclass = null, $ulclass = null)
    {
    $CI = get_instance();
    $lang_set = $CI->theme->_data['lang_set'];

    $CI->load->model('Helpers_models/Menus_model');

     $fmenus = get_footer_menus($id);

     if(!empty($fmenus)){
                foreach($fmenus as $f){

                  $menuitems = json_decode($f['menuitems']);
                  if(!empty($menuitems)){
              ?>
            <div class="<?php echo $divclass; ?>" >
              <h5 class="<?php echo $titleclass; ?>"><strong><?php echo $f['title']; ?></strong></h5>
              <ul class="<?php echo $ulclass; ?>">
                <?php
                  foreach($menuitems as $mi){
                    $pagesinfo =  get_page_details($mi->id);
                  $pagetitle  = get_title_in_lang($mi->id,$lang_set);
                  foreach($pagesinfo as $pageinfo){
                  $href3 = base_url().$pageinfo->page_slug;
                    if(!empty($pageinfo->page_external_link)){
                    $href3 = $pageinfo->page_external_link;
                    $target = "_".$pageinfo->page_target;
                    }else{

                    $target = "";
                    }
                  ?>
                <li><a href="<?php echo $href3;?>" target="<?php echo $target;?>" title=""><?php echo $pagetitle;?></a></li>
                <?php } } ?>
              </ul>
            </div>
<?php } } }

    }
}



if ( ! function_exists('get_header_menu_main'))
{
    function get_header_menu_main($id = null,$lang)
    {
        $CI = get_instance();
        $lang_set = $CI->theme->_data['lang_set'];
        $CI->load->model('Helpers_models/Menus_model');
        $fmenus = get_footer_menus($id);

        $arry =  [];
        if(!empty($fmenus)){
            foreach($fmenus as $f){
                $menuitems = json_decode($f['menuitems']);
                if(!empty($menuitems)){
                    $child = [];
                    foreach($menuitems as $mi){
                      $pagesinfo =  get_page_details_api($mi->id,$lang);
                      // print_r($pagesinfo);
                        foreach($pagesinfo as $pageinfo){
                          $arry[] =  array(
                          'href'=> strtolower($pageinfo->page_slug),
                          'title'=>$pageinfo->content_page_title,
                          'page_name'=>$pageinfo->content_page_title
                          );
                      foreach ($mi->children as $key) {
                      $childsinfo =  get_page_details_api($key->id,$lang);

                      foreach($childsinfo as $childinfo){
                      // $child[] = array('page_name' =>$childinfo->page_slug);
                      array_push($arry, array(
                        'href'=> strtolower($childinfo->page_slug),
                        'title'=>$childinfo->content_page_title,
                        'page_name'=>$pageinfo->content_page_title,
                      ));
                        }
                     }
                   }

                    }
                }
              }
            }
            return json_encode($arry);
    }
    }


if ( ! function_exists('get_footer_menu_main'))
{
    function get_footer_menu_main($id = null,$lang)
    {
        $CI = get_instance();
        $lang_set = $CI->theme->_data['lang_set'];
        $CI->load->model('Helpers_models/Menus_model');
        $fmenus = get_footer_menus($id);

        $arry =  [];
        if(!empty($fmenus)){
            foreach($fmenus as $f){
                $menuitems = json_decode($f['menuitems']);
                if(!empty($menuitems)){
                    $child = [];
                    foreach($menuitems as $mi){
                      $pagesinfo =  get_page_details_api($mi->id,$lang);
                      // print_r($pagesinfo);
                        foreach($pagesinfo as $pageinfo){
                          $arry[] =  array(
                          'href'=> strtolower($pageinfo->page_slug),
                          'title'=>$pageinfo->content_page_title,
                          'page_name'=>$pageinfo->content_page_title
                          );
                      foreach ($mi->children as $key) {
                      $childsinfo =  get_page_details_api($key->id,$lang);

                      foreach($childsinfo as $childinfo){
                      // $child[] = array('page_name' =>$childinfo->page_slug);
                      array_push($arry, array(
                        'href'=> strtolower($childinfo->page_slug),
                        'title'=>$childinfo->content_page_title,
                        'page_name'=>$pageinfo->content_page_title,
                      ));
                        }
                     }
                   }

                    }
                }
              }
            }
            return json_encode($arry);
        }
    }


// Get horizontal footer items

//Get Header Items

if ( ! function_exists('get_header_menu'))
{
    function get_header_menu($id = null)
    {
        $CI = get_instance();
        $lang_set = $CI->theme->_data['lang_set'];
        $CI->load->model('Helpers_models/Menus_model');
        $fmenus = get_footer_menus($id);
        if(!empty($fmenus)){
            foreach($fmenus as $f){
                $menuitems = json_decode($f['menuitems']);
                if(!empty($menuitems)){ ?>

                    <?php
                    foreach($menuitems as $mi){
                    $pagesinfo =  get_page_details($mi->id);
                    foreach($pagesinfo as $pageinfo){
                        if(empty($mi->children)) {
                        $check = app()->service('ModuleService')->check($pageinfo->page_slug);
                        if(!empty($check)){
                            if($pageinfo->page_slug == 'Blog' ||  $pageinfo->page_slug == 'Offers'){
                                $href3 = base_url().$pageinfo->page_slug;
                                $pagetitle  = get_title_in_lang($mi->id,$lang_set);
                            }else{
                                $pagetitle  = lang($pageinfo->page_slug);
                                $href3 = base_url().''.strtolower(lang($pageinfo->page_slug));
                            }
                        }else{
                            $href3 = base_url().$pageinfo->page_slug;
                            $pagetitle  = get_title_in_lang($mi->id,$lang_set);
                        }
                    if(!empty($pageinfo->page_external_link)){
                        $href3 = $pageinfo->page_external_link;
                        $target = "_".$pageinfo->page_target;
                    }else{
                        $target = "";
                    }
                    ?>
                        <li><a class="" href="<?php echo $href3; ?>" target="<?php echo $target; ?>" title=""><?php echo $pagetitle; ?></a></li>
                        <?php } if(!empty($mi->children)) {?>
                            <li class="footm">
                            <a href="#"><?=$pageinfo->page_slug?> <i class="la la-angle-down"></i></a>

                            <ul class="dropdown-menu-item">
                            <?php
                            foreach ($mi->children as $chid){
                            $pagesinfo =  get_page_details($chid->id);
                            foreach($pagesinfo as $pageinfo){
                                $check = app()->service('ModuleService')->check($pageinfo->page_slug);
                                if(!empty($check)){
                                    if($pageinfo->page_slug == 'Blog' ||  $pageinfo->page_slug == 'Offers'){
                                        $href3 = base_url().$pageinfo->page_slug;
                                        $pagetitle  = get_title_in_lang($chid->id,$lang_set);
                                    }else{
                                        $pagetitle  = lang($pageinfo->page_slug);
                                        $href3 = base_url().''.strtolower(lang($pageinfo->page_slug));
                                    }
                                }else{
                                    $href3 = base_url().$pageinfo->page_slug;
                                    $pagetitle  = get_title_in_lang($chid->id,$lang_set);
                                }
                                if(!empty($pageinfo->page_external_link)){
                                    $href3 = $pageinfo->page_external_link;
                                    $target = "_".$pageinfo->page_target;
                                }else{
                                    $target = "";
                                }
                                ?>
                                <li><a href="<?php echo $href3; ?>" target="<?php echo $target; ?>" title=""><?php echo $pagetitle; ?></a></li>
                                <?php } } ?>
                                <li>
                            </ul>
                        <?php } } } ?>
                        <?php } } } } }

//End Header Items

if ( ! function_exists('footer_horizontal'))
{
    function footer_horizontal($divclass = null,$lang_set)
    {
    $CI = get_instance();

    $CI->load->model('Helpers_models/Menus_model');

     $fhmenus = get_footer_horizontal();

             if(!empty($fhmenus)){
                foreach($fhmenus as $fh){

                  $menuitems = json_decode($fh->menu_items);
                  if(!empty($menuitems)){
              ?>
             <div class="<?php echo $divclass;?>">
          <nav>
            <?php
              $count = 0;
              foreach($menuitems as $fhi){
               $pagesinfo =  get_page_details($fhi->id);
              $fhtitle  = get_title_in_lang($fhi->id,$lang_set);
              foreach($pagesinfo as $pageinfo){
              $href6 = base_url().$pageinfo->page_slug;
              if(!empty($pageinfo->page_external_link)){
              $href6 = $pageinfo->page_external_link;
              $target = "_".$pageinfo->page_target;
              }else{

              $target = "";
              }

              $count++;
              if($count == 1){
              $first = "first";
              }else{
              $first = "";
              }
              ?>
            <i class="<?php echo $first;?>"><a href="<?php echo $href6;?>" data-toggle="tooltip" data-placement="top"  target="<?php echo $target;?>" title="<?php echo $fhtitle;?>"><?php echo $fhtitle;?></a></i>
            <?php } } ?>
          </nav>
        </div>
<?php } } }

    }
}


