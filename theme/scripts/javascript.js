// JavaScript Document


function change_color(box_id, box_bg, box_color, lbl_id, lbl_color) {

	document.getElementById(lbl_id).style.color 			= lbl_color;
	document.getElementById(box_id).style.color 			= box_color;
	document.getElementById(box_id).style.backgroundColor 	= box_bg;

}


function change_class(box_id, box_class, lbl_id, lbl_class) {
	document.getElementById(box_id).setAttribute("class", box_class);
	document.getElementById(lbl_id).setAttribute("class", lbl_class);
}



function imgover(img_name, imgfile){
	document.getElementById(img_name).src = imgfile;
}



function expand(name) {
	document.getElementById( name ).style.display = "block";
}



function collapse(name) {
	document.getElementById( name ).style.display = "none";
}


function set_layer(what, value){
   if (document.getElementById &&
		 document.getElementById(what) &&
			document.getElementById(what).style)
   {
   document.getElementById(what).style.display = value;
   };
}



function on_off(id_tr, color){
	document.getElementById(id_tr).style.backgroundColor 	= color;		
}


function collapse_page_all(){
	collapse('page_document');
	collapse('page_comment');
	//collapse('page_photo');
	//collapse('page_slide');
	//collapse('page_video');
	//collapse('page_event');
	//collapse('page_coupon');
	//collapse('page_product');
}

function preview_image(url, text){
	document.photo_img.src 								= url;
	document.getElementById("photo_text").innerHTML 	= text;
}

function preview_comment_open(comment_num){
	expand('comment_desc_' 		+ comment_num);
	expand('comment_minus_' 	+ comment_num);
	collapse('comment_plus_'	+ comment_num);
}

function preview_comment_close(comment_num){
	collapse('comment_desc_' 	+ comment_num);
	collapse('comment_minus_' 	+ comment_num);
	expand('comment_plus_'		+ comment_num);
}


function preview_document_open(document_num){
	expand('document_desc_' 	+ document_num);
	expand('document_minus_' 	+ document_num);
	collapse('document_plus_'	+ document_num);
}

function preview_document_close(document_num){
	collapse('document_desc_' 	+ document_num);
	collapse('document_minus_' 	+ document_num);
	expand('document_plus_'		+ document_num);
}


function preview_news_open(news_num){
	expand('news_desc_' 		+ news_num);
	expand('news_minus_' 	+ news_num);
	collapse('news_plus_'	+ news_num);
}

function preview_news_close(news_num){
	collapse('news_desc_' 	+ news_num);
	collapse('news_minus_' 	+ news_num);
	expand('news_plus_'		+ news_num);
}

function preview_event_open(event_num){
	expand('event_desc_' 		+ event_num);
	expand('event_minus_' 		+ event_num);
	collapse('event_plus_'		+ event_num);
}

function preview_event_close(event_num){
	collapse('event_desc_' 		+ event_num);
	collapse('event_minus_' 	+ event_num);
	expand('event_plus_'		+ event_num);
}

function preview_product_open(product_num){
	expand('product_desc_' 		+ product_num);
	expand('product_minus_' 	+ product_num);
	collapse('product_plus_'	+ product_num);
}

function preview_product_close(product_num){
	collapse('product_desc_' 	+ product_num);
	collapse('product_minus_' 	+ product_num);
	expand('product_plus_'		+ product_num);
}

function preview_coupon_open(coupon_num){
	expand('coupon_desc_' 		+ coupon_num);
	expand('coupon_minus_' 		+ coupon_num);
	collapse('coupon_plus_'		+ coupon_num);
}

function preview_coupon_close(coupon_num){
	collapse('coupon_desc_' 	+ coupon_num);
	collapse('coupon_minus_' 	+ coupon_num);
	expand('coupon_plus_'		+ coupon_num);
}



function confirm_delete_listing_top(id, name){	
	if ( confirm("Are you sure to delete this listing ?") ){
		window.location = "system_seller_listing_delete.php?listing=" + id + "&backurl=seller_listing.php"; 
		return true;
	} 
	else{ return false; }
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


function getXMLHTTP() {

	var xmlhttp=false;	
	try{ xmlhttp=new XMLHttpRequest(); }
	catch(e)	{		
		try{ xmlhttp= new ActiveXObject("Microsoft.XMLHTTP"); }
		catch(e){
			try{ xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch(e1){ xmlhttp=false; }
		}
	}
	return xmlhttp;

}



function find_child_cat(new_value, max_level, url_count, url_list, level_current, box_id, box_notification) {		
	
	var req_count	= getXMLHTTP();
	var req_list	= getXMLHTTP();
	var temp_box	= '';

	for (i=level_current + 1; i<=max_level; i++) {
		temp_box	= "listing_category_" + i;
		document.getElementById(temp_box).innerHTML = "";
		document.getElementById(temp_box).style.display='none';
		document.getElementById(temp_box).style.padding='0px';
	}


	if (new_value > 0) {

		document.getElementById(box_notification).style.display='block';
	
		if (req_count) {
			
			req_count.onreadystatechange = function() {
				if (req_count.readyState == 4) {
					if (req_count.status == 200) { 
					
						count = req_count.responseText * 1;
						if (count>0) { 
						
							if (req_list) {
								req_list.onreadystatechange = function() {
									if (req_list.readyState == 4) {
										if (req_list.status == 200) { 
										
											document.getElementById(box_id).innerHTML=req_list.responseText;
											document.getElementById(box_id).style.display='block';
											document.getElementById(box_id).style.padding='5px 0px 0px 0px';
											document.getElementById(box_notification).style.display='none';
											
										} 
									}				
								}			
								req_list.open("GET", url_list, true);
								req_list.send(null);
							}
							
						}
						else { document.getElementById(box_notification).style.display='none'; }
					
					} 
				}				
			}			
			req_count.open("GET", url_count, true);
			req_count.send(null);
			
		}
	}
}


function find_child_location(new_value, max_level, url_count, url_list, level_current, box_id, box_notification) {		


	var req_count	= getXMLHTTP();
	var req_list	= getXMLHTTP();
	var temp_box	= '';

	for (i=level_current + 1; i<=max_level; i++) {
		temp_box	= "listing_location_" + i;
		document.getElementById(temp_box).innerHTML = "";
		document.getElementById(temp_box).style.display='none';
		document.getElementById(temp_box).style.padding='0px';
	}


	if (new_value > 0) {

		document.getElementById(box_notification).style.display='block';
	
		if (req_count) {
			
			req_count.onreadystatechange = function() {
				if (req_count.readyState == 4) {
					if (req_count.status == 200) { 
					
						count = req_count.responseText * 1;
						if (count>0) { 
						
							if (req_list) {
								req_list.onreadystatechange = function() {
									if (req_list.readyState == 4) {
										if (req_list.status == 200) { 
										
											document.getElementById(box_id).innerHTML=req_list.responseText;
											document.getElementById(box_id).style.display='block';
											document.getElementById(box_id).style.padding='5px 0px 0px 0px';
											document.getElementById(box_notification).style.display='none';
											
										} 
									}				
								}			
								req_list.open("GET", url_list, true);
								req_list.send(null);
							}
							
						}
						else { document.getElementById(box_notification).style.display='none'; }
					
					} 
				}				
			}			
			req_count.open("GET", url_count, true);
			req_count.send(null);
			
		}
	}
}


function find_child_event_cat(new_value, max_level, url_count, url_list, level_current, box_id, box_notification) {		
	
	var req_count	= getXMLHTTP();
	var req_list	= getXMLHTTP();
	var temp_box	= '';
	
	// alert (
	//	   'New Value = ' + new_value 			+ '\n' +
	//	   'Max Level = ' + max_level 			+ '\n' +
	//	   'URL Count = ' + url_count			+ '\n' +
	//	   'URL list = ' + url_list				+ '\n' +
	//	   'LEvel Current = ' + level_current	+ '\n' +
	//	   'Box ID = ' + box_id					+ '\n' +
	//	   'Box Notification = ' + box_notification
	//	   );

	for (i=level_current + 1; i<=max_level; i++) {
		temp_box	= "event_category_" + i;
		document.getElementById(temp_box).innerHTML = "";
		document.getElementById(temp_box).style.display='none';
		document.getElementById(temp_box).style.padding='0px';
	}


	if (new_value > 0) {

		document.getElementById(box_notification).style.display='block';
	
		if (req_count) {
			
			req_count.onreadystatechange = function() {
				if (req_count.readyState == 4) {
					if (req_count.status == 200) { 
					
						count = req_count.responseText * 1;
						if (count>0) { 
						
							if (req_list) {
								req_list.onreadystatechange = function() {
									if (req_list.readyState == 4) {
										if (req_list.status == 200) { 
										
											document.getElementById(box_id).innerHTML=req_list.responseText;
											document.getElementById(box_id).style.display='block';
											document.getElementById(box_id).style.padding='5px 0px 0px 0px';
											document.getElementById(box_notification).style.display='none';
											
										} 
									}				
								}			
								req_list.open("GET", url_list, true);
								req_list.send(null);
							}
							
						}
						else { document.getElementById(box_notification).style.display='none'; }
					
					} 
				}				
			}			
			req_count.open("GET", url_count, true);
			req_count.send(null);
			
		}
	}
}


function find_child_news_cat(new_value, max_level, url_count, url_list, level_current, box_id, box_notification) {		
	
	var req_count	= getXMLHTTP();
	var req_list	= getXMLHTTP();
	var temp_box	= '';
	
	// alert (
	//	   'New Value = ' + new_value 			+ '\n' +
	//	   'Max Level = ' + max_level 			+ '\n' +
	//	   'URL Count = ' + url_count			+ '\n' +
	//	   'URL list = ' + url_list				+ '\n' +
	//	   'LEvel Current = ' + level_current	+ '\n' +
	//	   'Box ID = ' + box_id					+ '\n' +
	//	   'Box Notification = ' + box_notification
	//	   );

	for (i=level_current + 1; i<=max_level; i++) {
		temp_box	= "news_category_" + i;
		document.getElementById(temp_box).innerHTML = "";
		document.getElementById(temp_box).style.display='none';
		document.getElementById(temp_box).style.padding='0px';
	}


	if (new_value > 0) {

		document.getElementById(box_notification).style.display='block';
	
		if (req_count) {
			
			req_count.onreadystatechange = function() {
				if (req_count.readyState == 4) {
					if (req_count.status == 200) { 
					
						count = req_count.responseText * 1;
						if (count>0) { 
						
							if (req_list) {
								req_list.onreadystatechange = function() {
									if (req_list.readyState == 4) {
										if (req_list.status == 200) { 
										
											document.getElementById(box_id).innerHTML=req_list.responseText;
											document.getElementById(box_id).style.display='block';
											document.getElementById(box_id).style.padding='5px 0px 0px 0px';
											document.getElementById(box_notification).style.display='none';
											
										} 
									}				
								}			
								req_list.open("GET", url_list, true);
								req_list.send(null);
							}
							
						}
						else { document.getElementById(box_notification).style.display='none'; }
					
					} 
				}				
			}			
			req_count.open("GET", url_count, true);
			req_count.send(null);
			
		}
	}
}

function find_child_product_cat(new_value, max_level, url_count, url_list, level_current, box_id, box_notification) {		
	
	var req_count	= getXMLHTTP();
	var req_list	= getXMLHTTP();
	var temp_box	= '';
	
	// alert (
	//	   'New Value = ' + new_value 			+ '\n' +
	//	   'Max Level = ' + max_level 			+ '\n' +
	//	   'URL Count = ' + url_count			+ '\n' +
	//	   'URL list = ' + url_list				+ '\n' +
	//	   'LEvel Current = ' + level_current	+ '\n' +
	//	   'Box ID = ' + box_id					+ '\n' +
	//	   'Box Notification = ' + box_notification
	//	   );

	for (i=level_current + 1; i<=max_level; i++) {
		temp_box	= "product_category_" + i;
		document.getElementById(temp_box).innerHTML = "";
		document.getElementById(temp_box).style.display='none';
		document.getElementById(temp_box).style.padding='0px';
	}


	if (new_value > 0) {

		document.getElementById(box_notification).style.display='block';
	
		if (req_count) {
			
			req_count.onreadystatechange = function() {
				if (req_count.readyState == 4) {
					if (req_count.status == 200) { 
					
						count = req_count.responseText * 1;
						if (count>0) { 
						
							if (req_list) {
								req_list.onreadystatechange = function() {
									if (req_list.readyState == 4) {
										if (req_list.status == 200) { 
										
											document.getElementById(box_id).innerHTML=req_list.responseText;
											document.getElementById(box_id).style.display='block';
											document.getElementById(box_id).style.padding='5px 0px 0px 0px';
											document.getElementById(box_notification).style.display='none';
											
										} 
									}				
								}			
								req_list.open("GET", url_list, true);
								req_list.send(null);
							}
							
						}
						else { document.getElementById(box_notification).style.display='none'; }
					
					} 
				}				
			}			
			req_count.open("GET", url_count, true);
			req_count.send(null);
			
		}
	}
}


function div_display(box_id, value) { 
	document.getElementById(box_id).style.display=value; 
}


function update_open_close(day_id, value) {
	
	if (value == "open") {
		// div_display("section_" 	+ day_id + "_title"		, "block"	);	
		// div_display("section_" 	+ day_id + "_text"		, "block"	);	
		div_display("section_" 		+ day_id + "_hourfrom"	, "block"	);	
		div_display("section_" 		+ day_id + "_hourto"	, "block"	);	
	}
	else {
		// div_display("section_" 	+ day_id + "_title"		, "none"	);	
		// div_display("section_" 	+ day_id + "_text"		, "none"	);	
		div_display("section_" 		+ day_id + "_hourfrom"	, "none"	);	
		div_display("section_" 		+ day_id + "_hourto"	, "none"	);	
	}

}


function div_video_open(box_id) { 
	div_display('video_type_upload'		, 'none');
	div_display('video_type_external'	, 'none');
	div_display('video_type_youtube'	, 'none');
	div_display(box_id					, 'block');
}

