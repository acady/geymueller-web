// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    window.singlepage_tb_height = (92 / 100) * jQuery(window).height();
    window.singlepage_hoo_shortcodes_height = (71 / 100) * jQuery(window).height();
    if(window.singlepage_hoo_shortcodes_height > 550) {
        window.singlepage_hoo_shortcodes_height = (74 / 100) * jQuery(window).height();
    }

    jQuery(window).resize(function() {
        window.singlepage_tb_height = (92 / 100) * jQuery(window).height();
        window.singlepage_hoo_shortcodes_height = (71 / 100) * jQuery(window).height();

        if(window.singlepage_hoo_shortcodes_height > 550) {
            window.singlepage_hoo_shortcodes_height = (74 / 100) * jQuery(window).height();
        }
    });

    themehoo_shortcodes = {
    	loadVals: function()
    	{
    		var shortcode = $('#_hoo_shortcode').text(),
    			uShortcode = shortcode;

    		// fill in the gaps eg {{param}}
    		$('.hoo-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('hoo_', ''),		// gets rid of the hoo_ prefix
    				re = new RegExp("{{"+id+"}}","g");
                    var value = input.val();
                    if(value == null) {
                      value = '';
                    }
    			uShortcode = uShortcode.replace(re, value);
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_hoo_ushortcode').remove();
    		$('#hoo-sc-form-table').prepend('<div id="_hoo_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_hoo_cshortcode').text(),
    			pShortcode = '';

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = "\r\n";
    			} else {
    				shortcodes = '';
    			}

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;

                if($(this).find('#hoo_slider_type').length >= 1) {
                    if($(this).find('#hoo_slider_type').val() == 'image') {
                        rShortcode = '[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]';
                    } else if($(this).find('#hoo_slider_type').val() == 'video') {
                        rShortcode = '[slide type="{{slider_type}}"]{{video_content}}[/slide]';
                    }
                }
    			$('.hoo-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('hoo_', '')		// gets rid of the hoo_ prefix
    					re = new RegExp("{{"+id+"}}","g");
                        var value = input.val();
                        if(value == null) {
                          value = '';
                        }
    				rShortcode = rShortcode.replace(re, input.val());
    			});

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = shortcodes + rShortcode + "\r\n";
    			} else {
    				shortcodes = shortcodes + rShortcode;
    			}
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_hoo_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_hoo_cshortcodes" class="hidden">' + shortcodes + '</div>');

    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_hoo_ushortcode').html().replace('{{child_shortcode}}', shortcodes);

    		// add updated parent shortcode
    		$('#_hoo_ushortcode').remove();
    		$('#hoo-sc-form-table').prepend('<div id="_hoo_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false,
                onAdd: function(row) {
                    // Get Upload ID
                    var prev_upload_id = jQuery(row).prev().find('.hoo-upload-button').data('upid');
                    var new_upload_id = prev_upload_id + 1;
                    jQuery(row).find('.hoo-upload-button').attr('data-upid', new_upload_id);

                    // activate chosen
                    jQuery('.hoo-form-multiple-select').chosen({
                        width: '100%',
                        placeholder_text_multiple: 'Select Options or Leave Blank for All'
                    });

                    // activate color picker
                    jQuery('.wp-color-picker-field').wpColorPicker({
                        change: function(event, ui) {
                            themehoo_shortcodes.loadVals();
                            themehoo_shortcodes.cLoadVals();
                        }
                    });

                    // changing slide type
                    var type = $(row).find('#hoo_slider_type').val();

                    if(type == 'video') {
                        $(row).find('#hoo_image_content, #hoo_image_url, #hoo_image_target, #hoo_image_lightbox').closest('li').hide();
                        $(row).find('#hoo_video_content').closest('li').show();

                        $(row).find('#_hoo_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
                    }

                    if(type == 'image') {
                        $(row).find('#hoo_image_content, #hoo_image_url, #hoo_image_target, #hoo_image_lightbox').closest('li').show();
                        $(row).find('#hoo_video_content').closest('li').hide();

                        $(row).find('#_hoo_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');
                    }

                    themehoo_shortcodes.loadVals();
                    themehoo_shortcodes.cLoadVals();
                }
    		});

    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();

    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}

    			return false;
    		});

    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row',
                cancel: 'div.iconpicker, input, select, textarea, a'
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				hooPopup = $('#hoo-popup');

            tbWindow.css({
                height: window.singlepage_tb_height,
                width: hooPopup.outerWidth(),
                marginLeft: -(hooPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: window.singlepage_tb_height,
				overflow: 'auto', // IMPORTANT
				width: hooPopup.outerWidth()
			});

            tbWindow.show();

			$('#hoo-popup').addClass('no_preview');
            $('#hoo-sc-form-wrap #hoo-sc-form').height(window.singlepage_hoo_shortcodes_height);
    	},
    	load: function()
    	{
    		var	hoo = this,
    			popup = $('#hoo-popup'),
    			form = $('#hoo-sc-form', popup),
    			shortcode = $('#_hoo_shortcode', form).text(),
    			popupType = $('#_hoo_popup', form).text(),
    			uShortcode = '';

            // if its the shortcode selection popup
            if($('#_hoo_popup').text() == 'shortcode-generator') {
                $('.hoo-sc-form-button').hide();
            }

    		// resize TB
    		themehoo_shortcodes.resizeTB();
    		$(window).resize(function() { themehoo_shortcodes.resizeTB() });

    		// initialise
            themehoo_shortcodes.loadVals();
    		themehoo_shortcodes.children();
    		themehoo_shortcodes.cLoadVals();

    		// update on children value change
    		$('.hoo-cinput', form).live('change', function() {
    			themehoo_shortcodes.cLoadVals();
    		});

    		// update on value change
    		$('.hoo-input', form).live('change', function() {
    			themehoo_shortcodes.loadVals();
    		});

            // change shortcode when a user selects a shortcode from choose a dropdown field
            $('#hoo_select_shortcode').change(function() {
                var name = $(this).val();
                var label = $(this).text();

                if(name != 'select' ) {
					
					 var popup = 'shortcode-generator';

					if(typeof name != 'undefined' && name) { popup = name;   }
		
					tb_show("Shortcodes", ajaxurl + "?action=hoo_shortcodes_popup&popup=" + popup + "&width=" + 800);

                    jQuery('#TB_window').hide();

                    $('#TB_window').hide();
                }
            });

            // activate chosen
            $('.hoo-form-multiple-select').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Options'
            });

            // update upload button ID
            jQuery('.hoo-upload-button:not(:first)').each(function() {
                var prev_upload_id = jQuery(this).data('upid');
                var new_upload_id = prev_upload_id + 1;
                jQuery(this).attr('data-upid', new_upload_id);
            });
    	}
	}

    // run
    $('#hoo-popup').livequery(function() {
        themehoo_shortcodes.load();

        $('#hoo-popup').closest('#TB_window').addClass('hoo-shortcodes-popup');

        $('#hoo_video_content').closest('li').hide();

            // activate color picker
            $('.wp-color-picker-field').wpColorPicker({
                change: function(event, ui) {
                    setTimeout(function() {
                        themehoo_shortcodes.loadVals();
                        themehoo_shortcodes.cLoadVals();
                    },
                    1);
                }
            });
    });

    // when insert is clicked
    $('.hoo-insert').live('click', function() {
        if(window.tinyMCE)
        {
         //   window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, $('#_hoo_ushortcode').html());
       //     tb_remove();
        }
		
		window.singlepage_wpActiveEditor = window.wpActiveEditor;
		// Insert shortcode
		window.wp.media.editor.insert($('#_hoo_ushortcode').html());
		// Restore previous editor
		window.wpActiveEditor = window.singlepage_wpActiveEditor;
		tb_remove();
    });

    //tinymce.init(tinyMCEPreInit.mceInit['hoo_content']);
    //tinymce.execCommand('mceAddControl', true, 'hoo_content');
    //quicktags({id: 'hoo_content'});

    // activate upload button
    $('.hoo-upload-button').live('click', function(e) {
	    e.preventDefault();

        upid = $(this).attr('data-upid');

        if($(this).hasClass('remove-image')) {
            $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', '').hide();
            $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', '');
            $('.hoo-upload-button[data-upid="' + upid + '"]').text('Upload').removeClass('remove-image');

            return;
        }

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image',
            },
	        frame: 'post',
            multiple: false  // Set to true to allow multiple files to be selected
        });

	    file_frame.open();

        $('.media-menu a:contains(Insert from URL)').remove();

        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();

                $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
                $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

                themehoo_shortcodes.loadVals();
                themehoo_shortcodes.cLoadVals();
            });

            $('.hoo-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
            $('.media-modal-close').trigger('click');
        });

	    file_frame.on( 'insert', function() {
		    var selection = file_frame.state().get('selection');
		    var size = jQuery('.attachment-display-settings .size').val();

		    selection.map( function( attachment ) {
			    attachment = attachment.toJSON();

			    if(!size) {
				    attachment.url = attachment.url;
			    } else {
				    attachment.url = attachment.sizes[size].url;
			    }

			    $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
			    $('.hoo-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

			    themehoo_shortcodes.loadVals();
			    themehoo_shortcodes.cLoadVals();
		    });

		    $('.hoo-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
		    $('.media-modal-close').trigger('click');
	    });
    });

    // activate iconpicker
    $('.iconpicker i').live('click', function(e) {
        e.preventDefault();

        var iconWithPrefix = $(this).attr('class');
        var fontName = $(this).attr('data-name');

        if($(this).hasClass('active')) {
            $(this).parent().find('.active').removeClass('active');

            $(this).parent().parent().find('input').attr('value', '');
        } else {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().find('input').attr('value', fontName);
        }

        themehoo_shortcodes.loadVals();
        themehoo_shortcodes.cLoadVals();
    });

    // table shortcode
    $('#hoo-sc-form-table .hoo-insert').live('click', function(e) {
        e.stopPropagation();

        var shortcodeType = $('#hoo_select_shortcode').val();

        if(shortcodeType == 'table') {
            var type = $('#hoo-sc-form-table #hoo_type').val();
            var columns = $('#hoo-sc-form-table #hoo_columns').val();

            var text = '<div class="hoo-table table-' + type + '"><table width="100%"><thead><tr>';

            for(var i=0;i<columns;i++) {
                text += '<th>Column ' + (i + 1) + '</th>';
            }

            text += '</tr></thead><tbody>';

            for(var i=0;i<columns;i++) {
                text += '<tr>';
                if(columns >= 1) {
                    text += '<td>Item #' + (i + 1) + '</td>';
                }
                if(columns >= 2) {
                    text += '<td>Description</td>';
                }
                if(columns >= 3) {
                    text += '<td>Discount:</td>';
                }
                if(columns >= 4) {
                    text += '<td>$' + (i + 1) + '.00</td>';
                }
                if(columns >= 5) {
                    text += '<td>$ 0.' + (i + 1) + '0</td>';
                }
                text += '</tr>';
            }

            text += '<tr>';

            if(columns >= 1) {
                text += '<td><strong>All Items</strong></td>';
            }
            if(columns >= 2) {
                text += '<td><strong>Description</strong></td>';
            }
            if(columns >= 3) {
                text += '<td><strong>Your Total:</strong></td>';
            }
            if(columns >= 4) {
                text += '<td><strong>$10.00</strong></td>';
            }
            if(columns >= 4) {
                text += '<td><strong>Tax</strong></td>';
            }
            text += '</tr>';
            text += '</tbody></table></div>';

            if(window.tinyMCE)
            {
                window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, text);
                tb_remove();
            }
        }
    });

    // slider shortcode
    $('#hoo_slider_type').live('change', function(e) {
        e.preventDefault();

        var type = $(this).val();
        if(type == 'video') {
            $(this).parents('ul').find('#hoo_image_content, #hoo_image_url, #hoo_image_target, #hoo_image_lightbox').closest('li').hide();
            $(this).parents('ul').find('#hoo_video_content').closest('li').show();

            $('#_hoo_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
        }

        if(type == 'image') {
            $(this).parents('ul').find('#hoo_image_content, #hoo_image_url, #hoo_image_target, #hoo_image_lightbox').closest('li').show();
            $(this).parents('ul').find('#hoo_video_content').closest('li').hide();

            $('#_hoo_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');
        }
    });

    $('.hoo-add-video-shortcode').live('click', function(e) {
        e.preventDefault();

        var shortcode = $(this).attr('href');
        var content = $(this).parents('ul').find('#hoo_video_content');

        content.val(content.val() + shortcode);
        themehoo_shortcodes.cLoadVals();
    });

    $('#hoo-popup textarea').live('focus', function() {
        var text = $(this).val();

        if(text == 'Your Content Goes Here') {
            $(this).val('');
        }
    });

    $('.hoo-gallery-button').live('click', function(e) {
	    var gallery_file_frame;

        e.preventDefault();

	    alert('To add images to this post or page for attachments layout, navigate to "Upload Files" tab in media manager and upload new images.');

        gallery_file_frame = wp.media.frames.gallery_file_frame = wp.media({
            title: 'Attach Images to Post/Page',
            button: {
                text: 'Go Back to Shortcode',
            },
            frame: 'post',
            multiple: true  // Set to true to allow multiple files to be selected
        });

	    gallery_file_frame.open();

        $('.media-menu a:contains(Insert from URL)').remove();
        
        $('.media-menu-item:contains("Upload Files")').trigger('click');

        gallery_file_frame.on( 'select', function() {
            $('.media-modal-close').trigger('click');

            themehoo_shortcodes.loadVals();
            themehoo_shortcodes.cLoadVals();
        });
    });
});