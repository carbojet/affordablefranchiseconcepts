(function($) {

    $(document).ready(function(){

        /*.featured-listing,.new-listing,*/

        $( "#datepicker" ).datepicker();
        $("body").on("blur","input[name=pre-qual-fax],input[name=pre-businessphone]",function(e){

            form = $(this).closest("form");		
            val = $(this).val()
            $(this).closest("span.wpcf7-form-control-wrap").find('span.wpcf7-not-valid-tip').remove();
            if(val!="" && val.length<12)
            {
                e.preventDefault();
                $(this).closest("span.wpcf7-form-control-wrap").append('<span role="alert" class="wpcf7-not-valid-tip">Please fill in Valid number.</span>');	
            }
        });

        $("body").on("click","form input[type=submit]",function(e){

            form = $(this).closest("form");
            form.find('span.wpcf7-not-valid-tip').remove();
            form_valid = true;
            if(form.find("input[name=pre-qual-time-frame]").length>0)
            {
                if ( confirm("Do you want to Submit This form ?") ){
                } 
                else{ return false; }

            }
            form_data = $(form).serialize();
            var site_url = 'https://www.affordablebusinessconcepts.com/product/'+'?'+form_data+'&listing_id='+$("input[name=listing_id]").val();
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if(xhttp.readyState == 4 && xhttp.status == 200)
                {
                    //data = eval('(' + xhttp.responseText + ')');
                    //if(Object.keys(data).length>0){/*for data output*/ alert(data);}
                    //alert(xhttp.responseText);
                    //alert($(xhttp.responseText).find(".query_content").html());
                }
            }
            xhttp.open("GET", site_url, true);
            xhttp.send();
            if(form_valid)
            {
                //if valid		
            }
        })
        $("body").on("click",".cross-btn",function () {
            if($(this).find("input.selected_ad_id").prop("checked")){
                $(this).find("input.selected_ad_id").prop("checked",false);
                $(this).closest(".cross-btn").removeClass("active")	
            }else{
                $(this).find("input.selected_ad_id").prop("checked",true);
                $(this).closest(".cross-btn").addClass("active")			
            }
            count_ads = $("body").find("input.selected_ad_id:checked:checked").length;

            if($("body").find("input.selected_ad_id:checked:checked").length>=1)
            {
                $(".fixed-bar.ci-mail-send span.count-ads").html(count_ads)

                $(".fixed-bar.ci-mail-send").hide(100,function(){$(".fixed-bar.ci-mail-send").show()})
            }
            else
            {
                $(".fixed-bar.ci-mail-send span.count-ads").html('0')
                $(".fixed-bar.ci-mail-send").hide();
            }				    	
        });	

        $("body").on("click","a.multi-ad-list",function () {
            remove_id = $(this).closest(".alert").find("input.selected_id").val()
            $("body").find("input.selected_ad_id:checked:checked").each(function(){
                if($(this).val()==remove_id)
                {
                    $(this).prop("checked",false);
                    $(this).closest(".cross-btn").removeClass("active")
                    if($("body").find("input.selected_ad_id:checked:checked").length>=1)
                    {
                        $(".fixed-bar.ci-mail-send").show();
                    }
                    else
                    {
                        $(".fixed-bar.ci-mail-send").hide();
                    }
                }
            })
        });
        /*.featured-listing,.new-listing,*/
        $("body").on("click",".cross-btn",function () {
            if($(this).find("input.selected_ad_id").prop("checked")){
                $(this).find("input.selected_ad_id").prop("checked",false);
                $(this).closest(".cross-btn").removeClass("active")	
            }else{
                $(this).find("input.selected_ad_id").prop("checked",true);
                $(this).closest(".cross-btn").addClass("active")			
            }
            count_ads = $("body").find("input.selected_ad_id:checked:checked").length;
            if($("body").find("input.selected_ad_id:checked:checked").length>=1)
            {
                $(".fixed-bar.ci-mail-send span.count-ads").html(count_ads)
                $(".fixed-bar.ci-mail-send").hide(100,function(){$(".fixed-bar.ci-mail-send").show()})
            }
            else
            {
                $(".fixed-bar.ci-mail-send span.count-ads").html('0')
                $(".fixed-bar.ci-mail-send").hide();
            }				    	
        });
                

        $("body").on("click","a.multi-ad-list",function () {
            remove_id = $(this).closest(".alert").find("input.selected_id").val()
            $("body").find("input.selected_ad_id:checked:checked").each(function(){
                if($(this).val()==remove_id)
                {
                    $(this).prop("checked",false);
                    $(this).closest(".cross-btn").removeClass("active")
                    if($("body").find("input.selected_ad_id:checked:checked").length>=1)
                    {
                        $(".fixed-bar.ci-mail-send").show();
                    }
                    else
                    {
                        $(".fixed-bar.ci-mail-send").hide();
                    }
                }
            })
        });
        $("body").on("click","button[name=cal]",function(){
            cash_in_bank23 = Number($("input[name=cash_in_bank23]").val());
            cash_in_bank2 = Number($("input[name=cash_in_bank2]").val());
            cash_in_bank3 = Number($("input[name=cash_in_bank3]").val());
            cash_in_bank4 = Number($("input[name=cash_in_bank4]").val());
            cash_in_bank5 = Number($("input[name=cash_in_bank5]").val());
            cash_in_bank6 = Number($("input[name=cash_in_bank6]").val());
            cash_in_bank7 = Number($("input[name=cash_in_bank7]").val());
            cash_in_bank8 = Number($("input[name=cash_in_bank8]").val());
            cash_in_bank9 = Number($("input[name=cash_in_bank9]").val());
            cash_in_bank10 = Number($("input[name=cash_in_bank10]").val());
            cash_in_bank11 = cash_in_bank23+cash_in_bank2+cash_in_bank3+cash_in_bank4+cash_in_bank5+cash_in_bank6+cash_in_bank7+cash_in_bank8+cash_in_bank9+cash_in_bank10;
            $("input[name=cash_in_bank11]").val(cash_in_bank11);
            cash_in_bank13 = Number($("input[name=cash_in_bank13]").val());
            cash_in_bank14 = Number($("input[name=cash_in_bank14]").val());
            cash_in_bank15 = Number($("input[name=cash_in_bank15]").val());
            cash_in_bank16 = Number($("input[name=cash_in_bank16]").val());
            cash_in_bank17 = Number($("input[name=cash_in_bank17]").val());
            cash_in_bank18 = Number($("input[name=cash_in_bank18]").val());
            cash_in_bank19 = Number($("input[name=cash_in_bank19]").val());
            cash_in_bank20 = Number($("input[name=cash_in_bank20]").val());
            cash_in_bank21 = Number($("input[name=cash_in_bank21]").val());
            cash_in_bank22 = cash_in_bank13+cash_in_bank14+cash_in_bank15+cash_in_bank16+cash_in_bank17+cash_in_bank18+cash_in_bank19+cash_in_bank20+cash_in_bank21;
            $("input[name=cash_in_bank22]").val(cash_in_bank22);
            if(cash_in_bank11>=cash_in_bank22)
            {
                cash_in_bank12 = cash_in_bank11 - cash_in_bank22;
                $("input[name=cash_in_bank12]").val(cash_in_bank12);
            }
            else
            {
                alert("your liabilities are higher than your assets");
            }
        })

        $('.net-worth input').addClass('auto');
        $('input[name=cash_in_bank11]').addClass('auto');
        $('input[name=cash_in_bank22]').addClass('auto');
        $('input[name=cash_in_bank12]').addClass('auto');
        $('input[name=pre_qual_retirement_fund]').addClass('auto');
        $('input[name=visitor_est_nt_worth]').addClass('auto');
        $('input[name=visitor_capital_invest]').addClass('auto');
        $('input[name=pre_qual_invest_amt]').addClass('auto');
        $('input[name=pre_qual_nt_worth]').addClass('auto');
        $('input[name=pre_qual_time_frame]').addClass('purchase_time_frame');
        $('input[name=pre_qual_zip]').addClass('zip-code');
        $('input[name=visitor_postal_code]').addClass('zip-code');
        $('input[name=visitor_time_frame]').addClass('purchase_time_frame');
        
        $('input[name=pre_qual_zip]').attr("id","zip");


        var getOption = $.parseJSON('{"mDec": "0"}');
        $('.auto').autoNumeric('init',getOption);
        
        $(".purchase_time_frame").keypress(function (e) {
            if (e.charCode != 0) {
                var regex = new RegExp("^[a-zA-Z0-9\-\ \s]+$");
                var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (!regex.test(key)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
        $('body').on("keydown blur",".zip-code",function(event){
            $(this).closest('.form-group').find('.custom-form-validation-error').remove()
                if($(this).val()!="")
                {
                    if(ValidateString($(this).val()) == true)
                    {
                        $(this).closest('.form-group').find('.custom-form-validation-error').remove();
                    }
                    else{
                        $(this).closest('.form-group').append('<span class="custom-form-validation-error" style="color:#FF0000">Must be a valid Zip or Postal Code</span>');
                        $("#errmsgzip").hide();
                        $("#errmsgmulti_ad_zip").hide();
                        $("#errmsgenquiry_zip").hide();
                        $("#errmsgrqst_free_phn_zip").hide();
                        $("#errmsgcontact_zip").hide();
                    }
            }
        })


        $("body").keydown(function(e)
        {
            var charCode = (e.which) ? e.which : e.keyCode;
            var ctrl = e.ctrlKey;
            if(charCode==67 && ctrl==true)
            {
                e.preventDefault();
            }
        });

        $('body').on('submit','form',function(){
            setInterval(function(){
                if($('.wpcf7-mail-sent-ok').length>0){$('.wpcf7-mail-sent-ok').fadeOut();}
            },8000)	
        })		

        $("input[name=pre-qual-frst-name],input[name=pre-qual-last-name]").blur(function(e) {
            $("input[name=pre-qual-frst-last-name]").val($("input[name=pre-qual-frst-name]").val()+" "+$("input[name=pre-qual-last-name]").val())	
        });

        $('body').on('keydown',"input",function(e) {
            var curchr = this.value.length;
            var curval = $(this).val();
            var charCode = (e.which) ? e.which : e.keyCode;
            if(charCode==13){

                e.preventDefault();

                inputs = $(this).closest("form").find("input,select,textarea")

                idx = inputs.index(this)

                inputs[idx + 1].focus();

                inputs[idx + 1].select();

            }
        })

        $('body').on('keypress',"input[type=tel]",function(e) {
            var curchr = this.value.length;
            var curval = $(this).val();
            var charCode = (e.which) ? e.which : e.keyCode;

            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            else
            {
                if(curchr<=11)
                {
                    if(curchr==3)
                    {
                        $(this).val(curval+"-");
                    }
                    else if(curchr==7)
                    {
                        $(this).val(curval+"-");
                    }
                }
                else
                {
                    e.preventDefault();
                }
            }
        });

        $('[data-toggle="tooltip"]').tooltip(); 
        plisting_title = $("input[name=plisting_title]").val(); 
        $("input[name=listing_title]").val(plisting_title);
        $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });
        //reset advance search form
        $.fn.reset_advance_search = function()
        {
            $("form[name=advance_search]").find("input[name=list_seller_username]").val('');

            $("form[name=advance_search]").find("select[name=list_state]").val(0);

            $("form[name=advance_search]").find("select[name=list_sector]").val(0);

            $("form[name=advance_search]").find("select[name=list_invest_level]").val(0);

            $("form[name=advance_search]").find("select[name=list_city]").html('<option value="0">All</option>');

            $("form[name=advance_search]").find("select[name=list_category]").html('<option value="0">Category</option>');

            $("form[name=advance_search]").find("input[name=list_search_keywork]").val('');
        }
        $(".adv-reset").on("click",function(e){
            e.preventDefault();
            $.fn.reset_advance_search();
        })
        $(".adv-reset-close").on("click",function(){
            $.fn.reset_advance_search();
        })

        //FOR MENU FOCUS
        $("body").on("click",".navbar-default .navbar-nav .open .dropdown-menu>li>a",function(e){
            $(this).parent(".dropdown a").css("background-color","#000");
        })

        $(document).bind("contextmenu", function (e) {
            e.preventDefault();           
        });
    });

    /**custom  function start */

    function ajax_category_list(id,level){
        var site_url = 'https://www.affordablebusinessconcepts.com/directory/listing/ajax_category_list/'+id;	
        //alert(site_url);  
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                data = eval('(' + xhttp.responseText + ')');
                if(Object.keys(data).length>0)
                {
                    jQuery("#listing_category_1").find("select option").remove();
                    jQuery("#listing_category_1").find("select").append('<option value="0">All</option>')
                    for(var key in data){					
                        jQuery("#listing_category_1").find("select").append('<option value="'+key+'">'+data[key]+'</option>')
                    }						
                }
            }
        }
    xhttp.open("GET", site_url, true);
    xhttp.send();
    }
    //#################### SELECT CITY #####################
    function ajax_select_city(id){ 
        var site_url = 'https://www.affordablebusinessconcepts.com/directory/listing/ajax_select_city/'+id;	
        //alert(site_url);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
            data = eval('(' + xhttp.responseText + ')');
                if(Object.keys(data).length>0){					
                    jQuery("#ajax_city").find("select option").remove();
                    jQuery("#ajax_city").find("select").append('<option value="0">All</option>')
                    jQuery.each(data,function(key,obj){  
                        jQuery("#ajax_city").find("select").append('<option value="'+obj.id+'">'+obj.location_name+'</option>')
                    })				
                }
            }
        }
        xhttp.open("GET", site_url, true);
        xhttp.send();
    }

    function ajax_city(id){ 
        var site_url = 'https://www.affordablebusinessconcepts.com/directory/listing/ajax_select_city/'+id;	
        //alert(site_url);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                data = eval('(' + xhttp.responseText + ')');
                if(Object.keys(data).length>0){					
                    jQuery("#ajax_cty").find("select.selectpicker option").remove();
                    jQuery("#ajax_cty").find("select.selectpicker").append('<option value="0">City</option>')
                    jQuery.each(data,function(key,obj){  
                        jQuery("#ajax_cty").find("select.selectpicker").append('<option value="'+obj.id+'">'+obj.location_name+'</option>')
                    })
                    jQuery('select[name=list_city].selectpicker').selectpicker('refresh');
                }
            }
        }
        xhttp.open("GET", site_url, true);
        xhttp.send();
    }
    function ValidateString(str){
        var re = /^[A-Za-z- \d=... ]{4,7}$/
    //	var re = /^[a-zA-Z0-9]+$/
        return re.test(str);
    }
    function checkDocHist(){
        if(jQuery("body").find("input.selected_ad_id:checked:checked").length>0){
            jQuery(".cross-btn input.selected_ad_id:checked:checked").each(function(){
                jQuery(this).closest(".cross-btn").addClass("active")
            })
            jQuery(".fixed-bar.ci-mail-send span.count-ads").html(jQuery("body").find("input.selected_ad_id:checked:checked").length)
            jQuery(".fixed-bar.ci-mail-send").show()
        }
    }
    setInterval(checkDocHist,500);
    function pre_quali_validateZIP() {
            var inputStr = jQuery("#zip").val();
            if(inputStr.length<5 && inputStr.length>0) 
            jQuery( "#zip" ).after( '<span id="errmsgzip" style="color:#FF0000">Must be a valid Zip or Postal Code</span>' );
    }
    function multi_ad_zip_validateZIP(){
        var inputStr = jQuery("#multi_ad_zip").val();
        if(inputStr.length<5 && inputStr.length>0) 
        jQuery( "#multi_ad_zip" ).after( '<span id="errmsgmulti_ad_zip" style="color:#FF0000">Must be a valid Zip or Postal Code</span>' );
    }
    function enquiry_zip_validateZIP(){
        var inputStr = jQuery("#enquiry_zip").val();
        if(inputStr.length<5 && inputStr.length>0) 
        jQuery( "#enquiry_zip" ).after( '<span id="errmsgenquiry_zip" style="color:#FF0000">Must be a valid Zip or Postal Code</span>' );
    }
    function rqst_free_phn_zip_validateZIP(){
        var inputStr = jQuery("#rqst_free_phn_zip").val();
        if(inputStr.length<5 && inputStr.length>0) 
        jQuery( "#rqst_free_phn_zip" ).after( '<span id="errmsgrqst_free_phn_zip" style="color:#FF0000">Must be a valid Zip or Postal Code</span>' ); 
    }
    function contact_zip_validateZIP(){
        var inputStr = jQuery("#contact_zip").val();
        if(inputStr.length<5 && inputStr.length>0) 
        jQuery( "#contact_zip" ).after( '<span id="errmsgcontact_zip" style="color:#FF0000">Must be a valid Zip or Postal Code</span>' ); 
    }
})(jQuery);