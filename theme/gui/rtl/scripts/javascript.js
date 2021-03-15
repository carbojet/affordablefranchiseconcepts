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



function findprice_min(strURL, box_id, text) {		
	
	var req  = getXMLHTTP();
	var txt  = "<select name='s_pmin' class='span12 m-wrap'><option>" + text + "</option></select>";
	var txt2 = "<select name='s_pmin' class='span12 m-wrap'><option>" + text + "</option></select>";
	
	if (box_id == "quick_s_pmin") { document.getElementById(box_id).innerHTML=txt2; }
	else { document.getElementById(box_id).innerHTML=txt; }
	
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box_id).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
			
}



function findprice_max(strURL, box_id, text) {		
	
	var req  = getXMLHTTP();
	var txt  = "<select name='s_pmax' class='span12 m-wrap'><option>" + text + "</option></select>";
	var txt2 = "<select name='s_pmax' class='span12 m-wrap'><option>" + text + "</option></select>";

	if (box_id == "quick_s_pmax") { document.getElementById(box_id).innerHTML=txt2; }
	else { document.getElementById(box_id).innerHTML=txt; }
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box_id).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
			
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

	
	/*
	alert (
		'New Value = ' + new_value 			+ '\n' +
		'Max Level = ' + max_level 			+ '\n' +
		'URL Count = ' + url_count			+ '\n' +
		'URL list = ' + url_list			+ '\n' +
		'LEvel Current = ' + level_current	+ '\n' +
		'Box ID = ' + box_id				+ '\n' +
		'Box Notification = ' + box_notification
	);
	*/
	
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
	
	/*
	alert (
	'New Value = ' + new_value 			+ '\n' +
	'Max Level = ' + max_level 			+ '\n' +
	'URL Count = ' + url_count			+ '\n' +
	'URL list = ' + url_list			+ '\n' +
	'LEvel Current = ' + level_current	+ '\n' +
	'Box ID = ' + box_id				+ '\n' +
	'Box Notification = ' + box_notification
	);
	*/
	
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



function get_calculation(strURL, box_id) {		
	
	var req = getXMLHTTP();
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box_id).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
			
}



function div_display(box_id, value) { 
	document.getElementById(box_id).style.display=value; 
}



/* CALENDAR FUNCTION - FOR VACATION RENTAL USE */
function get_calendar(url, box, text) {		
	
	var req  = getXMLHTTP();
	var txt  = "<div class='calendar'><table width='100%' border='0' cellspacing='1' cellpadding='0' class='content'><tr><td style='width:300px; height:300px; vertical-align:middle; text-align:center;'><img src='gui/ltr/img/loading_animation_1.gif' alt='" + text + "' borders='0' /><br /><br />" + text + "</td></tr></table></div>";
	document.getElementById(box).innerHTML=txt; 
	
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}


function get_calendar_small(url, box, text) {		
	
	var req  = getXMLHTTP();
	var txt  = "<div class='calendar' style='background-color:#fff'><table width='200' border='0' cellspacing='1' cellpadding='0' class='content_small' style='background-color:#fff'><tr><td style='width:200px; height:200px; vertical-align:middle; text-align:center;'><img src='gui/ltr/img/loading_animation_1.gif' alt='" + text + "' borders='0' /><br /><br />" + text + "</td></tr></table></div>";
	document.getElementById(box).innerHTML=txt; 
	
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}


function get_calendar_mini(url, box, text) {		
	
	var req  = getXMLHTTP();
	var txt  = "<table border='0' cellpadding='0' cellspacing='0' style='border: 2px solid #3272bc;' class='normal_20_blue'><tr><td style='width:220px; height:220px; vertical-align:middle; text-align:center;'><img src='gui/ltr/img/loading_animation_1.gif' alt='"+ text +"' /><br /><br />"+ text +"</td></tr></table>";
	document.getElementById(box).innerHTML=txt; 
	
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}



function get_calendar_title(url, box, text) {		
	
	var req  = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}



function get_calendar_prev(url, box, text) {		
	
	var req  = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}


function get_calendar_next(url, box, text) {		
	
	var req  = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) { document.getElementById(box).innerHTML=req.responseText; } 
			}				
		}			
		req.open("GET", url, true);
		req.send(null);
	}

}



function get_calendar_quicknav(listing, xmonth, xyear) {

	get_calendar_title	('seller_listing_info_calendar_title.php?listing=' 	+ listing + '&xmonth=' + xmonth + '&xyear=' + xyear, 'calendar_title', 'loading  ...');
	get_calendar_prev	('seller_listing_info_calendar_prev.php?listing=' 	+ listing + '&xmonth=' + xmonth + '&xyear=' + xyear, 'calendar_prev', 'loading  ...');
	get_calendar_next	('seller_listing_info_calendar_next.php?listing=' 	+ listing + '&xmonth=' + xmonth + '&xyear=' + xyear, 'calendar_next', 'loading  ...');
	get_calendar		('seller_listing_info_calendar_big.php?listing=' 	+ listing + '&xmonth=' + xmonth + '&xyear=' + xyear, 'calendar_section', 'loading  ...');

}



function div_video_open(box_id) { 
	div_display('video_type_upload'		, 'none');
	div_display('video_type_external'	, 'none');
	div_display('video_type_youtube'	, 'none');
	div_display(box_id					, 'block');
}
