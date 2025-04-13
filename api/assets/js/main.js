/**
 *   set focus on selected form element
 */

function appSetFocus(el_id){
    if(document.getElementById(el_id)){
        document.getElementById(el_id).focus();
    }    
}

/**
 *   Change location (go to another page)
 */
function appGoTo(page, params){
	var params_ = (params != null) ? params : "";
    window.location.href = 'index.php?'+page + params_;
}

/**
 *   Change location (go to another page)
 */
function appGoToPage(page, params, method){
	var params_ = (params != null) ? params : "";
	var method_ = (method != null) ? method : "";
	
	if(method_ == "post"){		
		var m_form = document.createElement('form');
			m_form.setAttribute('id', 'frmTemp');
			m_form.setAttribute('action', page);
			m_form.setAttribute('method', 'post');
		document.body.appendChild(m_form);
		
		params_ = params_.replace("?", "");
		var vars = params_.split("&");
		var pair = "";
		for(var i=0;i<vars.length;i++) { 
			pair = vars[i].split("="); 
			var input = document.createElement('input');
				input.setAttribute('type', 'hidden');
				input.setAttribute('name', pair[0]);
				input.setAttribute('id', pair[0]);
				input.setAttribute('value', unescape(pair[1]));
			document.getElementById('frmTemp').appendChild(input);
		}
		document.getElementById('frmTemp').submit();
	}else{
		window.location.href = page + params_;		
	}
}

/**
 *   Change location (go to current page)
 */
function appGoToCurrent(page, params){
	var page_  = (page != null) ? page : "index.php";
	var params_ = (params != null) ? params : "";
    window.location.href = page_ + params_;
}

/**
 *   Change location (go to current page)
 */
function appSetNewCurrency(page, params){
	var page_   = (page != null) ? page : "index.php";
	var params_ = (params != null) ? params : "";
	window.location.href = page_.replace("__CUR__", params_);	
}

/**
 *   Open popup window
 */
function appOpenPopup(page){
	new_window = window.open(page, "blank", "location=1,status=1,scrollbars=1,width=400,height=300");
    new_window.moveTo(100,100);
	if(window.focus) new_window.focus();
}

/**
 *   set cookie
 */
function appSetCookie(name, value, days) {
    if (days){
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = '; expires='+date.toGMTString();
    }
    else var expires = '';
    document.cookie = name+'='+value+expires+'; path=/';
}

/**
 *   get cookie
 */
function appGetCookie(name) {
	if (document.cookie.length > 0){
		start_c = document.cookie.indexOf(name + "=");
		if(start_c != -1){
			start_c += (name.length + 1);
			end_c = document.cookie.indexOf(";", start_c);
			if(end_c == -1) end_c = document.cookie.length;
			return unescape(document.cookie.substring(start_c,end_c));
		}
	}	
	return "";
}

/**
 *   get menu status
 */
function appGetMenuStatus(ind){
	var status = document.getElementById("side_box_content_"+ind).style.display;
	if(status == "none"){			
		return "none";
	}else{
		return "";
	}
}

/**
 *   toggle viewing of element
 */
function appToggleElementView(current_val, target_val, el, status1, status2){
	var status1 = (status1 != null) ? status1 : "none";
	var status2 = (status2 != null) ? status2 : "";
    if(!document.getElementById(el)){
		return false;
	}else{	
        if(current_val == target_val) document.getElementById(el).style.display = status1;
		else document.getElementById(el).style.display = status2;
    }  
}

/**
 *   toggle rss
 */
function appToggleRss(val){
	if(val == 1){
		if(document.getElementById("rss_feed_type")){
			document.getElementById("rss_feed_type").disabled = false;
		}
	}else{
		if(document.getElementById("rss_feed_type")){
			document.getElementById("rss_feed_type").disabled = true;
		}
	}
}

/**
 *   email validation
 */
function appIsEmail(str){
	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var lstr=str.length;
	var ldot=str.indexOf(dot);
	if(str.indexOf(at)==-1) return false; 

	if(str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr) return false;
	if(str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr) return false;
	if(str.indexOf(at,(lat+1))!=-1) return false;
	if(str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot) return false;
	if(str.indexOf(dot,(lat+2))==-1) return false;
	if(str.indexOf(" ")!=-1) return false;

 	return true;
}

/**
 *  submit site search
 */
function appPerformSearch(page, kwd){
	if(kwd != null) document.forms['frmQuickSearch'].keyword.value = kwd;
	document.forms['frmQuickSearch'].p.value = page;
	document.forms['frmQuickSearch'].submit();
}

/**
 *  submit coupon
 */
function appSubmitCoupon(status){
	jQuery('#checkout-form input[name=submition_type]').val(status);
	jQuery('#checkout-form').attr('action', 'index.php?page=booking_checkout');
	jQuery('#checkout-form').submit();
}

/**
 *   toggle element
 */
function appToggleElement(key){
	jQuery("#"+key).toggle("fast");
}

/**
 *   hide element
 */
function appHideElement(key){	
	if(key.indexOf('#') !=-1 || key.indexOf('.') !=-1){
		jQuery(key).hide('fast');
	}else{
		jQuery('#'+key).hide('fast');
	}		
}

/**
 *   show element
 */
function appShowElement(key){	
	if(key.indexOf('#') !=-1 || key.indexOf('.') !=-1){
		jQuery(key).show('fast');	
	}else{
		jQuery('#'+key).show('fast');	
	}		
}

/**
 *  toggle by jQuery
 */
function appToggleJQuery(el){
	jQuery('.'+el).toggle("fast");
}

/**
 *  toggle by class
 */
function appToggleByClass(el){
	jQuery('.'+el).toggle("fast");
}

/**
 *  submit form 
 */
function appFormSubmit(frm_name_id, vars){
	if(document.getElementById(frm_name_id)){
		if(vars != null){
			var vars_pairs = vars.split('&');
			var pair = '';
			for(var i=0; i<vars_pairs.length; i++){ 
				pair = vars_pairs[i].split('=');
				for(var j=0; j<pair.length; j+=2) {
					if(document.getElementById(pair[j])) document.getElementById(pair[j]).value = pair[j+1];
				}				
			}
		}	
		document.getElementById(frm_name_id).submit();					
	}									
}

/**
 *  submit site quick search
 */
function appQuickSearch(){
	var keyword = document.frmQuickSearch.keyword.value;
	if(keyword == '' || keyword.indexOf("...") != -1){
		return false;
	}else{
		document.frmQuickSearch.submit();
		return true;
	}
}

/////////////////////////////////////////////////////////////////////////////

/**
 *   toggle tabs
 */
function appToggleTabs(key, all_keys){
	jQuery("#content"+key).show("fast");
	jQuery("#tab"+key).attr("style", "font-weight:bold");
	
	for(var i = 0; i < all_keys.length; i++) {
		if(all_keys[i] != key){
			jQuery("#content"+all_keys[i]).hide("fast");
			jQuery("#tab"+all_keys[i]).attr("style", "font-weight:normal");
		}
	} 	
}

/**
 *   toggle readonly state of element
 */
function appToggleElementReadonly(current_val, target_val, el, target_status, default_status, is_readonly){
	var target_status = (target_status != null) ? target_status : false;
	var default_status = (default_status != null) ? default_status : false;
	var is_readonly = (is_readonly != null) ? is_readonly : true;
    if(!document.getElementById(el)){
		return false;
	}else{
		//alert(current_val +"=="+ target_val+target_status);
		
		//alert(document.getElementById(el).readOnly);
		if(is_readonly){
			if(current_val == target_val) document.getElementById(el).readOnly = target_status;
			else document.getElementById(el).readOnly = default_status;
		}else{
			if(current_val == target_val) document.getElementById(el).disabled = target_status;
			else document.getElementById(el).disabled = default_status;
		}
    }  
}

//--------------------------------------------------------------------------
// invoice preview (used for admin and client)
function appPreview(mode){
	var template_file = "";
	var div_id = "";
	var caption = "";
	var css_style = "";
	
	if(mode == "invoice"){
		template_file = "invoice.tpl.html";
		div_id = "divInvoiceContent";
		caption = "INVOICE";
	}else if(mode == "booking"){
		template_file = "description.tpl.html";
		div_id = "divDescriptionContent";
		caption = "BOOKING";		
	}else if(mode == "description"){
		template_file = "description.tpl.html";
		div_id = "divDescriptionContent";
		caption = "DESCRIPTION";
	}

	var new_window = window.open('html/templates/'+template_file,'blank','location=0,status=0,toolbar=0,height=480,width=680,scrollbars=yes,resizable=1,screenX=100,screenY=100');
	if(window.focus) new_window.focus();

	var message = document.getElementById(div_id).innerHTML;

	// remove html tags: <form>,<input>,<label>,
	message = message.replace(/<[//]{0,1}(FORM|INPUT|LABEL)[^><]*>/g,'');

	css_style = '<style>';
	css_style += 'TABLE.tblReservationDetails { border:1px solid #d1d2d3 }';
	css_style += 'TABLE.tblReservationDetails THEAD TR { background-color:#e1e2e3;font-weight:bold;font-size:13px; }';
	css_style += 'TABLE.tblReservationDetails TR TD SPAN { background-color:#e1e2e3; }';
	css_style += 'TABLE.tblExtrasDetails { border:1px solid #d1d2d3 }';
	css_style += 'TABLE.tblExtrasDetails THEAD TR { background-color:#e1e2e3;font-weight:bold;font-size:13px; }';
	css_style += 'TABLE.tblExtrasDetails TR TD SPAN { background-color:#e1e2e3; }';
	css_style += 'INPUT, SELECT, IMG { display:none; }';
    css_style += '@media print { .non-printable { display:none; } }	'; 
	css_style += '</style>';
	message = '<html><head>'+css_style+'</head><body><div class=\"non-printable\" style=\"width:99%;height:24px;margin:0px;padding:4px 5px;background-color:#e1e2e3;\"><div style=\"float:left;\">'+caption+'</div><div style=\"float:right;\">[ <a href=\"javascript:void(0);\" onclick=\"javascript:window.print();\">Print</a> ] [ <a href=\"javascript:void(0);\" onclick=\"javascript:window.close();\">Close</a> ]</div></div>' + message + '</body></html>';

	new_window.document.open();
	new_window.document.write(message);
	new_window.document.close();
}

/**
 *  Show Popup window
 */
function appPopupWindow(template_file, element_id){
	var element_id = (element_id != null) ? element_id : false;
	var new_window = window.open('html/'+template_file,'PopupWindow','height=500,width=600,toolbar=0,location=0,menubar=0,scrollbars=yes,screenX=100,screenY=100');
	if(window.focus) new_window.focus();
	if(element_id){
		var el = document.getElementById(element_id);		
		if(el.type == undefined){
			var message = el.innerHTML;	
		}else{
			var message = el.value;	
		}		
		var reg_x = /\n/gi;
		var replace_string = '<br> \n';
		message = message.replace(reg_x, replace_string);		
		new_window.document.open();
		new_window.document.write(message);
		new_window.document.close();
	}
}

function appShowTermsAndConditions(){
    document.getElementById('light').style.display='block';
    document.getElementById('fade').style.display='block';
}

function appCloseTermsAndConditions(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
}

function appReloadHotels(val, fill_el, token, dir){
	var dir_ = (dir != null) ? dir : '';
	var token_ = (token != null) ? token : '';
	jQuery.ajax({
		url: dir_+"ajax/hotels.ajax.php",
		global: false,
		type: "POST",
		data: ({location_id : val, check_key : "PHPTRAVELShs", token : token_}),
		dataType: "html",
		async:false,
		error: function(html){
			alert("AJAX: cannot connect to the server or server response error! Please try again later.");
		},
		success: function(html){
			var obj = jQuery.parseJSON(html);            			
			if(obj[0].status == "1"){
				if(obj.length > 0){
					jQuery("#"+fill_el).empty(); 
					jQuery("<option />", {val: '', text: "-- All --"}).appendTo("#"+fill_el);				
					for(var i = 1; i < obj.length; i++){
						jQuery("<option />", {val: obj[i].id, text: obj[i].template_name}).appendTo("#"+fill_el);				
					}					
				}
			}else{
				//alert("An error occurred while receiving hotel data! Please try again later.");
			}
		}
	});	
}

function appChangeCountry(val, fill_el, fill_val, token, dir){
	var dir_ = (dir != null) ? dir : '';
	var token_ = (token != null) ? token : '';
	jQuery.ajax({
		url: dir_+"ajax/countries.ajax.php",
		global: false,
		type: "POST",
		data: ({country_code : val, check_key : "PHPTRAVELShs", token : token_}),
		dataType: "html",
		async:false,
		error: function(html){
			alert("AJAX: cannot connect to the server or server response error! Please try again later.");
		},
		success: function(html){
			var obj = jQuery.parseJSON(html);            			
			if(obj[0].status == "1"){
				if(obj.length > 0){					
					if(obj.length > 1){					
						jQuery("#"+fill_el).replaceWith('<select id="'+fill_el+'" name="'+fill_el+'"></select>');
						jQuery("#"+fill_el).empty(); 
						for(var i = 1; i < obj.length; i++){
							if(obj[i].abbrv == fill_val && fill_val != ''){
								jQuery("<option />", {val: obj[i].abbrv, text: obj[i].name, selected: true}).appendTo("#"+fill_el);					
							}else{
								jQuery("<option />", {val: obj[i].abbrv, text: obj[i].name}).appendTo("#"+fill_el);					
							}							
						}
					}else{
						jQuery("#"+fill_el).replaceWith('<input type="text" id="'+fill_el+'" name="'+fill_el+'" size="32" maxlength="64" value="'+fill_val+'" />');
					}
				}
			}else{
				//alert("An error occurred while receiving hotel data! Please try again later.");
			}
		}
	});	
}