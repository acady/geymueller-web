jQuery(document).ready(function($){
								
$(".groupTitle").click(function(){
	var group = $(this).parents(".toggle_option_group");
	if(group.hasClass("group_close")){
	group.removeClass("group_close").addClass("group_open");
	$(this).addClass("open");
	}else{
	group.removeClass("group_open").addClass("group_close");
	$(this).removeClass("open");
		}
   });	


$('.singlepage_shortcodes,.singlepage_shortcodes_textarea').click(function(){
  var popup = 'shortcode-generator';

        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }

        // load thickbox
        tb_show("Shortcodes", ajaxurl + "?action=hoo_shortcodes_popup&popup=" + popup + "&width=" + 800);

        jQuery('#TB_window').hide();
     })


$('.singlepage_shortcodes_textarea').on("click",function(){
			var id = $(this).next().find("textarea").attr("id");
			$('#singlepage-shortcode-textarea').val(id);
		});																	   

$('.singlepage_shortcodes_list li a.singlepage_shortcode_item').on("click",function(){
													  
  var obj       = $(this);
  var shortcode = obj.data("shortcode");
  var form      = obj.parents("div#singlepage_shortcodes_container form");
 
   $.ajax({
		type: "POST",
		url: singlepage_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "singlepage_shortcode_form" },
		success:function(data){
	
		   form.find(".singlepage_shortcodes_list").hide();
		   form.find("#singlepage-shortcodes-settings").show();
		   form.find("#singlepage-shortcodes-settings .current_shortcode").text(shortcode);
		   form.find("#singlepage-shortcodes-settings-inner").html(data);
		}
		});
	
});

$(".singlepage-shortcodes-home").bind("click",function(){
            $("#singlepage-shortcodes-settings").hide();
		    $("#singlepage-shortcodes-settings-innter").html("");
		    $(".singlepage_shortcodes_list").show();
		   
		});
		
// insert shortcode into editor
$(".singlepage-shortcode-insert").bind("click",function(e){

    var obj       = $(this);
	var form      = obj.parents("div#singlepage_shortcodes_container form");
	var shortcode = form.find("input#singlepage-curr-shortcode").val();

	$.ajax({
		type: "POST",
		url: singlepage_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "singlepage_get_shortcode",attr:form.serializeArray()},
		
		success:function(data){
		
		$.magnificPopup.close();
		form.find("#singlepage-shortcodes-settings").hide();
		form.find("#singlepage-shortcodes-settings-innter").html("");
		form.find(".singlepage_shortcodes_list").show();
        form.find(".singlepage-shortcode").val(data);
		if($('#singlepage-shortcode-textarea').val() !="" ){
			var textarea = $('#singlepage-shortcode-textarea').val();
			if(textarea !== "undefined"){
		    var position = $("#"+textarea).getCursorPosition();
			var content = $("#"+textarea).val();
            var newContent = content.substr(0, position) + data + content.substr(position);
            $("#"+textarea).val(newContent);
			
			}
			}else{
		window.singlepage_wpActiveEditor = window.wpActiveEditor;
		// Insert shortcode
		window.wp.media.editor.insert(data);
		// Restore previous editor
		window.wpActiveEditor = window.singlepage_wpActiveEditor;
		}
		},
		error:function(){
			$.magnificPopup.close();
		// return false;
		}
		});
		// return false;
   });

 //preview shortcode

$(".singlepage-shortcode-preview").bind("click",function(e){

    var obj       = $(this);
	var form      = obj.parents("div#singlepage_shortcodes_container form");
	var shortcode = form.find("input#singlepage-curr-shortcode").val();

	$.ajax({
		type: "POST",
		url: singlepage_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "singlepage_get_shortcode",attr:form.serializeArray()},
		
		success:function(data){
      
		$.ajax({type: "POST",url: singlepage_params.ajaxurl,dataType: "html",data: { shortcode: data, action: "singlepage_shortcode_preview"},	
		success:function(content){
			$("#singlepage-shortcode-preview").html(content);
	        tb_show(shortcode + " preview","#TB_inline?width=600&amp;inlineId=singlepage-shortcode-preview",null);
			}
		});
	
		},
		error:function(){
			
		// return false;
		}
		});
		// return false;
   });

/////

  $("#setting_header_template").find(".option-tree-ui-radio-image-selected").after("<div id='singlepage_header_checked'></div>");
  $("#setting_header_template").find(".option-tree-ui-radio-images").click(function(){
			$("#singlepage_header_checked").remove();
			$(this).append("<div id='singlepage_header_checked'></div>");
      });
  
  ////
 $(".option-tree-ui-buttons .option-tree-ui-button,#option-tree-sub-header .option-tree-ui-button").addClass("disable");
 $("#option-tree-settings-api input,#option-tree-settings-api select,#option-tree-settings-api textarea").on("change",function() {
 $(".option-tree-ui-buttons .option-tree-ui-button,#option-tree-sub-header .option-tree-ui-button").removeClass("disable");							 													 
													 });														  
 $(".singlepage-numeric-slider-wrap .ui-slider-handle").on("mouseup",function(){
 $(".option-tree-ui-buttons .option-tree-ui-button,#option-tree-sub-header .option-tree-ui-button").removeClass("disable");
												   });									
 
 $(document).on("click","#option-tree-settings-api .type-colorpicker",function(e) {								  
 $(".option-tree-ui-buttons .option-tree-ui-button,#option-tree-sub-header .option-tree-ui-button").removeClass("disable");											  
													  });
  
 $("#setting_global_color").find(".format-setting-inner").append('<div style="float:left; margin-top: -5px;"><a class="custom-color" style="background-color: #ff6f6f;"></a><a class="custom-color" style="background-color: #f88d45;"></a><a class="custom-color" style="background-color: #ffd02d; "></a><a class="custom-color" style="background-color: #8de06c;"></a><a class="custom-color" style="background-color: #3bc779; "></a><a class="custom-color" style="background-color: #3cc5ca;"></a><a class="custom-color" style="background-color: #2f80d4; "></a><a class="custom-color" style="background-color: #3d48d7; "></a><a class="custom-color" style="background-color: #b54ce1; "></a><a class="custom-color" style="background-color: #e14c9d; "></a></div>');
  
 $("#setting_global_color").on("click","a.custom-color",function(){
            var x = jQuery(this).css('backgroundColor');
             hexc(x);
			 
              $(this).parents("#setting_global_color").find(".wp-color-result").css({"background-color":x});
			  $(this).parents("#setting_global_color").find(".hide-color-picker").val(color);
   });
  
  ////
  var header_style = $("#setting_header_template").find(".option-tree-ui-images:checked").val();
      $("#setting_header_template").find("#setting_header_text,#setting_sns_list_item").show();
	  
  if(header_style != 2){
	  $("#setting_header_text").hide();
	  }
	if(header_style == 1 || header_style == 4){
	  $("#setting_sns_list_item").hide();
	  }
	  
  $("#setting_header_template").on("click",".option-tree-ui-radio-images",function(){
	 var header_style = jQuery(this).find(".option-tree-ui-images").val();

	 $("#setting_header_text").hide();
	 $("#setting_sns_list_item").hide();
	 
     if(header_style == 2){
	  $("#setting_header_text").show();
	  }
	  if(header_style != 1 && header_style != 4){
	  $("#setting_sns_list_item").show();
	  }
	  
      });
  
  $("#setting_breadcrumb_background").hide();
  if($("#breadcrumb_style").val() == 2){
	  $("#setting_breadcrumb_background").show();
	  }
	$("#setting_breadcrumb_style").on("change","#breadcrumb_style",function(){
		$("#setting_breadcrumb_background").hide();	
		if($(this).val() == 2){
			$("#setting_breadcrumb_background").show();
			}
        });
	
/* ------------------------------------------------------------------------ */
/* import demo tables										       		    */
/* ------------------------------------------------------------------------ */
$(".singlepage-data-restore").click(function(){
	if(confirm("WARNING: Clicking this button will replace your current theme options, sliders and widgets. It can also take a minute to complete. Importing data is recommended on fresh installs only once. Importing on sites with content or importing twice will duplicate menus, pages and all posts.")){
	$(this).parent().find(".loading").remove();								 
	$(this).parent().append('<div class="loading"><img src="'+singlepage_params.themeurl+'/images/AjaxLoader.gif" /></div>');							 
	$.ajax({type:"POST",dataType:"html",url:singlepage_params.ajaxurl,data:"action=singlepage_data_import",
	    success:function(data){
			$(".singlepage-data-restore").parent().find(".loading").html(data);
			},error:function(){
				$(".singlepage-data-restore").parent().find(".loading").html('Error.');
				} })
  }
  });

/* ------------------------------------------------------------------------ */
/*  import theme options       	  								  	    */
/* ------------------------------------------------------------------------ */
  $('#import-options').click(function(){
									  
			$.ajax({
				 type:"POST",
				 dataType:"html",
				 url:ajaxurl,
				 data: {
                'options': $('#import_data').val(),
				'action':'singlepage_import_options',
            },
				 success:function(data){ location.reload();},error:function(){location.reload();}
					   });						  
     });
  
 /* ------------------------------------------------------------------------ */
/*  Sort section             	  								  	    */
/* ------------------------------------------------------------------------ */
	sectionSort = function() {
		var i = 0;
	 $('.home-section').each(function(){
			$(this).find("[name^='singlepage']").each(function(){
				var name = $(this).attr('name');
				var id   = $(this).attr('id');
				var new_name = name.replace(/[0-9]+/, i);
				var new_id   = id.replace(/[0-9]+/, i);
				$(this).attr('name',new_name);
				$(this).attr('id',new_id);
               });
			i++;
	   });
	  $('#section_num').val(i);

		}

/* ------------------------------------------------------------------------ */
/*  delete section             	  								  	    */
/* ------------------------------------------------------------------------ */
 $('#optionsframework').on('click','.delete-section',function(){
	$(this).parents('.home-section').remove();	
	sectionSort();
	
  });
 
/* ------------------------------------------------------------------------ */
/*  sort home sections      	  								  	    */
/* ------------------------------------------------------------------------ */

 $( "#home-sections" ).sortable({
    stop: function(){
       sectionSort();
    }			   
 });
  
  $("body").bind("ajaxComplete", function(){
          $('.sp-color-picker').wpColorPicker();  
    });
/* ------------------------------------------------------------------------ */
/*  import demo     	  								  	    */
/* ------------------------------------------------------------------------ */


$(document).on('click','#import-demo',function(){	
	
  if(confirm(singlepage.confirm_text)){
  
  $('#import-status').text(singlepage.wait_text);
  $('.import-loading').show();
  var fetch_attachments = 0;
  if ($('#fetch_attachments').is(':checked')) 
   fetch_attachments = 1;

  $.ajax({type:"POST",dataType:"html",url:singlepage.ajaxurl,data:"action=hoo_import_demo_data&fetch_attachments="+fetch_attachments,
	  success:function(data){
		     $('.import-loading').hide();
			 $('.hoo_importer_wait').hide();
		     $('#import-status').text(data);
		   //  location.reload() ;
		  },error:function(){
			  $('.import-loading').hide();
			  $('.hoo_importer_wait').hide();
			  $('#import-status').text(singlepage.importer_failed);		
    }});
  }
  
  });
					
 });