<?php

function publish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}
function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != 0)
            {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}
function movebottom($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != $count - 1)
            {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = '';
    if ($value == '1')
    {
        $result = '<i class="fa fa-check" />' . 'OK';
    }
    elseif ($value == '2')
    {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud)
{
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
        '" />';
}
function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud)
{
    var_dump($list);
}

function after_update_test($pd, $pm, $xc)
{
    $xc->search = 0;
}

function create_status_icon($value, $fieldname, $primary_key, $row, $xcrud)
{
    if($value == 1){
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input checked style="width: 40px; height: 20px;cursor:pointer" class="updated_status form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }else{
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input style="width: 40px; height: 20px;cursor:pointer" class="updated_status form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }

}

function create_status_blog_icon($value, $fieldname, $primary_key, $row, $xcrud)
{
    if($value == 1){
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input checked style="width: 40px; height: 20px;cursor:pointer" class="updated_status form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }else{
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input style="width: 40px; height: 20px;cursor:pointer" class="updated_status form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }

}
function name_link($value, $fieldname, $primary_key, $row, $xcrud)
{

    if (strlen($value) > 35){ $str = "... "; } else { $str = ""; }
    return '<a href="./listings.php?listing_id='.$primary_key.'" > '.substr($value, 0, 32).$str.'</a>';
 
}

function owned_by($value, $fieldname, $primary_key, $row, $xcrud)
{
    
if (!empty($value)){

    if (function_exists('GET')) {

        $params = array("email"=> $value);
        $user = GET('users',$params);
        if (!empty($user)){
            return '<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/></svg>'
            .$user[0]->first_name.' '.$user[0]->last_name.'<br><small class="fw-light">'.$user[0]->email.'</small';
        }

    }
}

}

function owned_by_email($value, $fieldname, $primary_key, $row, $xcrud)
{
     
if (!empty($value)){

    if (function_exists('GET')) {

    $params = array("email"=> $value);
    $user = GET('users',$params);
    if (!empty($user)){
        return '<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/></svg>'
        .$user[0]->first_name.' '.$user[0]->last_name.'<br><small class="fw-light">'.$user[0]->email.'</small';
    }
    }
}

}


function thumb_img($value, $fieldname, $primary_key, $row, $xcrud)
{
    
$img_url = "../uploads/".$value."";

if (@getimagesize($img_url))
{
return '<img src='.$img_url.'>';
} else {
return "<img src='../uploads/_no_img,jpg'>";
}

}

function Enable_Disable($value, $field, $priimary_key, $list, $xcrud)
{

    if ($value == 1) { $enabled = "selected"; } else { $enabled = ""; }
    if ($value == 0) { $disabled = "selected"; } else { $disabled = ""; }

   return '<div class="input-prepend input-append">' 
        .'<select class="xcrud-input" name="'.$xcrud->fieldname_encode($field).'">' 
        . '<option '.$enabled.' value="1"> Enabled '
        . '<option '.$disabled.' value="0"> Disabled '
        . '</select>'
        . '</div>';
}

function Yes_No($value, $field, $priimary_key, $list, $xcrud)
{

    if ($value == 1) { $enabled = "selected"; } else { $enabled = ""; }
    if ($value == 0) { $disabled = "selected"; } else { $disabled = ""; }

   return '<div class="input-prepend input-append">' 
        .'<select class="xcrud-input" name="'.$xcrud->fieldname_encode($field).'">' 
        . '<option '.$enabled.' value="1"> Yes '
        . '<option '.$disabled.' value="0"> No '
        . '</select>'
        . '</div>';
}

function check_mark($value, $field, $priimary_key, $list, $xcrud)
{

    if ($value == 1) { $check = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>'; }  
    if ($value == 0) { $check = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'; } 

   return $check;
}

function MakeDefault($value, $fieldname, $primary_key, $row, $xcrud){
 
    if($value == 1){
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input checked style="width: 40px; height: 20px;cursor:pointer" class="makeDefault form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }else{
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input style="width: 40px; height: 20px;cursor:pointer" class="makeDefault form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }

}

function featured($value, $fieldname, $primary_key, $row, $xcrud)
{
    if($value == 1){
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input checked style="width: 40px; height: 20px;cursor:pointer" class="makeFeatured form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }else{
        return '
        <div class="form-check form-switch">
<label class="form-check-label" for=""></label>
<input style="width: 40px; height: 20px;cursor:pointer" class="makeFeatured form-check-input" data-status="0" data-value="'.$primary_key.'" data-item="" id="checkedbox" type="checkbox">
</div>
        ';
    }

}

function stars($value, $fieldname, $primary_key, $row, $xcrud) {
    $res = "";
    for($stars = 1; $stars <= 5; $stars++){
        if($stars <= $value){
            $res .= '<svg style="margin: 0 1px" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.9121 1.59053C12.7508 1.2312 12.3936 1 11.9997 1C11.6059 1 11.2487 1.2312 11.0874 1.59053L8.27041 7.86702L1.43062 8.60661C1.03903 8.64895 0.708778 8.91721 0.587066 9.2918C0.465355 9.66639 0.574861 10.0775 0.866772 10.342L5.96556 14.9606L4.55534 21.6942C4.4746 22.0797 4.62768 22.4767 4.94632 22.7082C5.26497 22.9397 5.68983 22.9626 6.03151 22.7667L11.9997 19.3447L17.968 22.7667C18.3097 22.9626 18.7345 22.9397 19.0532 22.7082C19.3718 22.4767 19.5249 22.0797 19.4441 21.6942L18.0339 14.9606L23.1327 10.342C23.4246 10.0775 23.5341 9.66639 23.4124 9.2918C23.2907 8.91721 22.9605 8.64895 22.5689 8.60661L15.7291 7.86702L12.9121 1.59053Z" fill="#000000"/>
            </svg>';
             }else{
            $res .= '<svg style="margin: 0 -2px" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <mask id="path-1-inside-1" fill="white"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z"/> </mask> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z" fill="#000000"/> <path d="M11.9972 4.18011L11.0461 3.87109L11.0461 3.87109L11.9972 4.18011ZM12.9482 4.18011L13.8993 3.87109L13.8993 3.87109L12.9482 4.18011ZM10.3398 9.28092L9.38874 8.9719L9.38874 8.9719L10.3398 9.28092ZM4.20707 10.5309L3.61928 11.3399L3.61928 11.3399L4.20707 10.5309ZM8.54608 13.6834L7.95829 14.4924L7.95829 14.4924L8.54608 13.6834ZM8.72771 14.2424L7.77666 13.9334L7.77666 13.9334L8.72771 14.2424ZM7.07036 19.3432L6.1193 19.0342L6.1193 19.0342L7.07036 19.3432ZM7.83978 19.9022L8.42756 20.7113L8.42756 20.7113L7.83978 19.9022ZM12.1788 16.7498L12.7666 17.5588L12.7666 17.5588L12.1788 16.7498ZM12.7666 16.7498L12.1788 17.5588L12.1788 17.5588L12.7666 16.7498ZM17.1056 19.9022L16.5178 20.7113L16.5178 20.7113L17.1056 19.9022ZM17.875 19.3432L16.9239 19.6522L16.9239 19.6522L17.875 19.3432ZM16.2177 14.2424L17.1687 13.9334L17.1687 13.9334L16.2177 14.2424ZM16.3993 13.6834L15.8115 12.8744L15.8115 12.8744L16.3993 13.6834ZM20.7383 10.5309L20.1505 9.7219L20.1505 9.7219L20.7383 10.5309ZM14.6056 9.28092L15.5566 8.9719L15.5566 8.9719L14.6056 9.28092ZM12.4994 7.79779L11.5577 7.46123L12.4994 4.82656L13.4411 7.46123L12.4994 7.79779ZM13.7342 11.2527V12.2527H13.0297L12.7926 11.5893L13.7342 11.2527ZM11.2646 11.2527L12.2062 11.5893L11.9691 12.2527H11.2646V11.2527ZM7.26858 11.2527L6.71745 12.0871L3.9401 10.2527H7.26858V11.2527ZM10.5014 13.388L11.0525 12.5535L11.7071 12.9859L11.4431 13.7245L10.5014 13.388ZM9.26657 16.8429L9.8177 17.6773L7.31576 19.3298L8.32491 16.5063L9.26657 16.8429ZM12.4994 14.7076L11.9483 13.8732L12.4994 13.5092L13.0505 13.8732L12.4994 14.7076ZM15.7322 16.8429L16.6739 16.5063L17.683 19.3298L15.1811 17.6773L15.7322 16.8429ZM14.4974 13.388L13.5557 13.7245L13.2917 12.9859L13.9463 12.5535L14.4974 13.388ZM17.7302 11.2527V10.2527H21.0587L18.2813 12.0871L17.7302 11.2527ZM11.0461 3.87109C11.4951 2.48912 13.4502 2.48912 13.8993 3.87109L11.9972 4.48912C12.1468 4.94978 12.7985 4.94978 12.9482 4.48912L11.0461 3.87109ZM9.38874 8.9719L11.0461 3.87109L12.9482 4.48912L11.2909 9.58994L9.38874 8.9719ZM9.86427 8.62641C9.64766 8.62641 9.45568 8.76589 9.38874 8.9719L11.2909 9.58994C11.09 10.208 10.5141 10.6264 9.86427 10.6264V8.62641ZM4.50096 8.62641H9.86427V10.6264H4.50096V8.62641ZM3.61928 11.3399C2.44371 10.4858 3.04787 8.62641 4.50096 8.62641V10.6264C4.98532 10.6264 5.18671 10.0066 4.79485 9.7219L3.61928 11.3399ZM7.95829 14.4924L3.61928 11.3399L4.79485 9.7219L9.13386 12.8744L7.95829 14.4924ZM7.77666 13.9334C7.70972 14.1394 7.78305 14.3651 7.95829 14.4924L9.13386 12.8744C9.65959 13.2563 9.87958 13.9334 9.67877 14.5514L7.77666 13.9334ZM6.1193 19.0342L7.77666 13.9334L9.67877 14.5514L8.02141 19.6522L6.1193 19.0342ZM8.42756 20.7113C7.25199 21.5654 5.67027 20.4162 6.1193 19.0342L8.02141 19.6522C8.17109 19.1916 7.64385 18.8085 7.25199 19.0932L8.42756 20.7113ZM12.7666 17.5588L8.42756 20.7113L7.25199 19.0932L11.591 15.9407L12.7666 17.5588ZM12.1788 17.5588C12.354 17.6861 12.5913 17.6861 12.7666 17.5588L11.591 15.9407C12.1167 15.5588 12.8286 15.5588 13.3544 15.9407L12.1788 17.5588ZM16.5178 20.7113L12.1788 17.5588L13.3544 15.9407L17.6934 19.0932L16.5178 20.7113ZM18.8261 19.0342C19.2751 20.4162 17.6934 21.5654 16.5178 20.7113L17.6934 19.0932C17.3015 18.8085 16.7743 19.1916 16.9239 19.6522L18.8261 19.0342ZM17.1687 13.9334L18.8261 19.0342L16.9239 19.6522L15.2666 14.5514L17.1687 13.9334ZM16.9871 14.4924C17.1623 14.3651 17.2356 14.1394 17.1687 13.9334L15.2666 14.5514C15.0658 13.9334 15.2858 13.2563 15.8115 12.8744L16.9871 14.4924ZM21.3261 11.3399L16.9871 14.4924L15.8115 12.8744L20.1505 9.7219L21.3261 11.3399ZM20.4444 8.62641C21.8975 8.62641 22.5017 10.4858 21.3261 11.3399L20.1505 9.7219C19.7587 10.0066 19.96 10.6264 20.4444 10.6264V8.62641ZM15.0811 8.62641H20.4444V10.6264H15.0811V8.62641ZM15.5566 8.9719C15.4897 8.76589 15.2977 8.62641 15.0811 8.62641V10.6264C14.4313 10.6264 13.8553 10.208 13.6545 9.58993L15.5566 8.9719ZM13.8993 3.87109L15.5566 8.9719L13.6545 9.58994L11.9972 4.48912L13.8993 3.87109ZM13.4411 7.46123L14.6759 10.9161L12.7926 11.5893L11.5577 8.13435L13.4411 7.46123ZM10.3229 10.9161L11.5577 7.46123L13.4411 8.13435L12.2062 11.5893L10.3229 10.9161ZM7.26858 10.2527H11.2646V12.2527H7.26858V10.2527ZM9.95027 14.2224L6.71745 12.0871L7.81971 10.4183L11.0525 12.5535L9.95027 14.2224ZM8.32491 16.5063L9.55974 13.0514L11.4431 13.7245L10.2082 17.1794L8.32491 16.5063ZM13.0505 15.542L9.8177 17.6773L8.71544 16.0085L11.9483 13.8732L13.0505 15.542ZM15.1811 17.6773L11.9483 15.542L13.0505 13.8732L16.2833 16.0085L15.1811 17.6773ZM15.439 13.0514L16.6739 16.5063L14.7905 17.1794L13.5557 13.7245L15.439 13.0514ZM18.2813 12.0871L15.0485 14.2224L13.9463 12.5535L17.1791 10.4183L18.2813 12.0871ZM13.7342 10.2527H17.7302V12.2527H13.7342V10.2527Z" fill="#000000" mask="url(#path-1-inside-1)"/> </svg>'; }
    }
    return $res;
}


function refresh($postdata, $primary, $xcrud){
    // $postdata->set('name', sha1( $postdata->get('name') ));
    echo "<script>location.reload();</script>";
}

function nice_input($value, $field, $priimary_key, $list, $xcrud)
{
   return '<div class="input-prepend input-append">' 
        . '<span class="add-on">$</span>'
        . '<input type="text" name="'.$xcrud->fieldname_encode($fieldname).'" value="'.$value.'" class="xcrud-input" />'
        . '<span class="add-on">.00</span>'
        . '</div>';
}

function country_flag($value, $field, $priimary_key, $list, $xcrud)
{
   return  
        '<i class="flag '.strtolower($value).'"></i>'
        ;
}

function create_lang($postdata, $primary, $xcrud)
{
    $name = strtolower($_POST['xcrud']['postdata']['bGFuZ3VhZ2VzLmNvdW50cnlfaWQ-']);
    $val = json_encode(array());
    file_put_contents("../../lang/".$name.".json", print_r($val, true));

    $db = Xcrud_db::get_instance();
    $query = 'SELECT * FROM `languages` WHERE `language_code` !="en"';
    $db->query($query);
    $languages = $db->result();
    foreach ($languages as $key=>$value){
        //Add Hotels Languages
        $hotel_query = 'SELECT * FROM hotels';
        $db->query($hotel_query);
        $hotel_data = $db->result();
        foreach ($hotel_data as $hdata){
            $check_data = "SELECT * FROM `hotels_translations` WHERE `hotel_id` = ".$hdata['id']." and `language_id` = ".$value['id'];
            $db->query($check_data);
            $tran_check = $db->result();
            if(empty($tran_check)) {
                $tran_query = 'INSERT INTO `hotels_translations`( `hotel_id`, `language_id`) VALUES (' . $hdata['id'] . ',' . $value['id'] . ')';
                $db->query($tran_query);
            }
        }
        //Add Tours Languages
        $tours_query = 'SELECT * FROM tours';
        $db->query($tours_query);
        $tours_query = $db->result();
        foreach ($tours_query as $tdata){
            $check_tdata = "SELECT * FROM `tours_translations` WHERE `tour_id` = ".$tdata['id']." and `language_id` = ".$value['id'];
            $db->query($check_tdata);
            $tran_tcheck = $db->result();
            if(empty($tran_tcheck)) {
                $tran_tquery = 'INSERT INTO `tours_translations`( `tour_id`, `language_id`) VALUES (' . $tdata['id'] . ',' . $value['id'] . ')';
                $db->query($tran_tquery);
            }
        }

        //Add Blogs Languages
        $blogs_query = 'SELECT * FROM blogs';
        $db->query($blogs_query);
        $blogs_query = $db->result();
        foreach ($blogs_query as $bdata){
            $check_bdata = "SELECT * FROM `blogs_translations` WHERE `blog_id` = ".$bdata['id']." and `language_id` = ".$value['id'];
            $db->query($check_bdata);
            $tran_bcheck = $db->result();
            if(empty($tran_bcheck)) {
                $tran_blog_query = 'INSERT INTO `blogs_translations`( `blog_id`, `language_id`) VALUES (' . $bdata['id'] . ',' . $value['id'] . ')';
                $db->query($tran_blog_query);
            }
        }
    }
}

function checklanguage($value, $field, $primary_key, $row, $xcrud)
{
    $db = Xcrud_db::get_instance();
    $lan_query = 'SELECT * FROM `languages` WHERE `id` = '.$value;
    $db->query($lan_query);
    $get_lang = $db->result();
    return '<div class="input-group mb-3">'
        . '<input type="text" style="border-radius: 0px 6px 6px 0 !important;" disabled class="xcrud-input form-control" name="'.$xcrud->fieldname_encode($field).'" value="'.$get_lang[0]['name'].'" class="xcrud-input" />'
        . '</div>';
}

function remove_lang($xcrud)
{
    // $name = strtolower($_POST['xcrud']);
    // unlink("../lang/".$name.".json");
    // file_put_contents("../lang/2.json", print_r($_POST['xcrud'], true));

}

function email_new_account($postdata, $primary, $xcrud){

    require_once '../../_config.php';
    $db = new mysqli(server, username, password, dbname);
    $settings_data = $db->query('SELECT * FROM `settings`')->fetch_object();

    // return '<i class="icon-user"></i>' . $value;
    // file_put_contents("_post.log", print_r($_REQUEST['xcrud']['postdata']['dXNlcnMudXNlcl9pZA--'], true));

    $user_id = $_REQUEST['xcrud']['postdata']['dXNlcnMudXNlcl9pZA--'];
    $mail_code = rand(100000, 999999);

    $update = $db->query("UPDATE users SET email_code=".$mail_code." WHERE user_id=".$user_id."");

    ob_start();
    $link = $settings_data->site_url.'/account/activation/'.$user_id.'/'.$mail_code;
    include "../../email/_header.php";
    include "../../email/add_user_by_admin.php";
    include "../../email/_footer.php";
    $views = ob_get_clean();

    $params = array(
    "api_key" => $settings_data->email_api_key,
    "to" => array("".$_REQUEST['xcrud']['postdata']['dXNlcnMuZmlyc3RfbmFtZQ--']." <".$_REQUEST['xcrud']['postdata']['dXNlcnMuZW1haWw-'].">"),
    "sender" => "".$settings_data->business_name." <".$settings_data->email_sender_email.">",
    "subject" => "Signup",
    "html_body" => $views,
    );

    // SEND EMAIL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.smtp2go.com/v3/email/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);

}

function country_code($postdata, $primary, $xcrud){

    // file_put_contents("_post.log", print_r($city.' ' .$city->city, true));

    if (isset($_REQUEST['xcrud']['postdata']['bG9jYXRpb25zLmNvdW50cnk-'])) {

        $city = $_REQUEST['xcrud']['postdata']['bG9jYXRpb25zLmNpdHk-'];
        $country_name = $_REQUEST['xcrud']['postdata']['bG9jYXRpb25zLmNvdW50cnk-'];

        // PARAMS
        require_once '../../_config.php';
        $db = new mysqli(server, username, password, dbname);    
        $data = $db->query("SELECT * FROM `countries` WHERE `nicename` LIKE '$country_name'")->fetch_object();

        if(isset($data->iso)){

            if (isset($_REQUEST['xcrud']['primary'])){
                $id=$_REQUEST['xcrud']['primary'];
                $data2 = $db->query("UPDATE `locations` SET `country_code` = '$data->iso' WHERE `locations`.`id` = $id;");
            }

            else {
                $location = $db->query("SELECT * FROM `locations` ORDER BY id DESC LIMIT 1;")->fetch_object();
                $data2 = $db->query("UPDATE `locations` SET `country_code` = '$data->iso' WHERE `locations`.`id` = $location->id;");
            }

        }

        echo "<script>location.reload();</script>";

    }

}

function location_id($value, $fieldname, $primary_key, $row, $xcrud)
{
 
if (!empty($value)){

    // REFRESH IF THERE IS NO GET FUNCTION
    if (function_exists('GET')){
    $params = array("city"=> $value);
    $location = GET('locations',$params)[0];
    } else {
        echo "<script>location.reload();</script>";
    }

    if (!empty($location)){
        return '<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>'
        .'<strong>'.$location->city.'</strong><br><small class="fw-light">'.$location->country.'</small';
    }
}

}

function booking_total($value, $fieldname, $primary_key, $row, $xcrud) {

    require_once '../_config.php';
    $db = new mysqli(server, username, password, dbname);
    $data = $db->query('SELECT * FROM `bookings` WHERE `booking_id`= '.$primary_key.'')->fetch_object();

    // file_put_contents("_post.log", print_r("21", true));

    $price = number_format($data->booking_total, 2); 

    return '<small><strong>'.($data->booking_currency).'</strong></small>'.' '.($price);
}

function markup($value, $field, $priimary_key, $list, $xcrud)
{
   return '<div class="input-group mb-3">' 
        . '<span class="input-group-text" id="basic-addon1">%</span>'
        . '<input type="text" style="border-radius: 0px 6px 6px 0 !important;" class="xcrud-input form-control" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" />'
        . '</div>';
}
function users_select($value, $field, $priimary_key, $list, $xcrud){   


        
    $name = $xcrud->fieldname_encode($field);
       
        $db = Xcrud_db::get_instance();
        $query = 'SELECT * FROM users';
        $db->query($query);
        $users = $db->result();

        $data = '<select class="form-control" name="'.$name.'">';
            foreach ($users as $user){
                $data .='<option value="'.$user['email'].'">'.$user['email'].'</option>';
            }
        $data .='</select>';

   return $data;

}

// FUNCTION FOR USER WALLET
function update_user_wallet($postdata, $primary, $xcrud){   

    $currency = ($_POST['xcrud']['postdata']['dHJhbnNhY3Rpb25zLmN1cnJlbmN5']);
    $amount = ($_POST['xcrud']['postdata']['dHJhbnNhY3Rpb25zLmFtb3VudA--']);
    $user_id = ($_POST['xcrud']['postdata']['dHJhbnNhY3Rpb25zLnVzZXJfaWQ-']);
    $type = ($_POST['xcrud']['postdata']['dHJhbnNhY3Rpb25zLnR5cGU-']);

        // GET DEFAULT CURRENCY NAME 
        $db = Xcrud_db::get_instance();
        $query = "SELECT * FROM `currencies` WHERE `default` = '1'";
        $db->query($query);
        $default_current = $db->result();
        // $default_current[0]['name']

        $db = Xcrud_db::get_instance();
        $query = "SELECT * FROM `currencies` WHERE `name` = '$currency'";
        $db->query($query);
        $selected_currency = $db->result();
        // $select_currency[0]['rate']

        $price_get = (str_replace(',','',$amount) / $selected_currency[0]['rate']);
        $price =  number_format((float)$price_get, 2, '.', '');

        // file_put_contents("_post.log", print_r($price, true));

        $db_ = Xcrud_db::get_instance();
        if ($type == "credit" || $type == "purchase"){
            $query = "UPDATE `users` SET `balance`=`balance`+$price WHERE `user_id` = $user_id";
        } 

        if ($type == "refund"){
            $query = "UPDATE `users` SET `balance`=`balance`-$price WHERE `user_id` = $user_id";
        }

        $db_->query($query);        
        echo "<script>location.reload();</script>";

   return $xcrud;

}

function address($postdata, $xcrud){
    file_put_contents("_post.log", print_r($_POST, true));
    $postdata->set('address', $postdata->get('hotels.location_cords.search') );
}

function user_id($value, $fieldname, $primary_key, $row, $xcrud)
{
    
if (!empty($value)){

    if (function_exists('GET')) {

        $params = array("email"=> $value);
        $user = GET('users',$params);
        if (!empty($user)){
            return '<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/></svg>'
            .$user[0]->first_name.' '.$user[0]->last_name.'<br><small class="fw-light">'.$user[0]->email.'</small';
        }

    } else {
        echo "<script>location.reload();</script>";
    }
}

}