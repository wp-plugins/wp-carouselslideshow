var queue_files = 0;
var loading = new Image();
var def_rows_per_page = 5;
var test;
function sleep(millisegundos) 
{
	var inicio = new Date().getTime();
	while ((new Date().getTime() - inicio) < millisegundos);
}
function __log(str)
{
	if( window.console )
		console.log(str);
}
function __confirmation()
{
	return confirm('Are you sure to cotinue?');
	
}
function on_upload_success(file, serverData)
{
	//console.log(response);
//add replace on fileObj.filePath.replace("/wordpress/wp-admin/","") to workaround on windows server
	//__log(fileObj);
	//console.log(fileObj);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("Complete.");
		progress.toggleCancel(false);
	test=file;
	var params = 'myajax=1&filename='+ carousel_upload_dir+"/"+file.name + '&task=carousel_resize_image_and_add&album_id='+jQuery('#multi_album_id').val();
	params += '&image_price='+jQuery('#multi_image_price').val() + '&cpage='+
				jQuery('#cpage').val()+'&view='+jQuery('#view').val();
	jQuery.ajax({
			url: 'index.php',
			data: params,
			type: 'POST',
			async: false,
			success: function(res, textStatus, jqXHR)
			{
				if( res.status == 'ok' )
				{
					jQuery('#album_images tbody').append(res.row);
				}
				else
				{
//disable the error to workaround on windows server
					//alert(res.message);
				}
			}
	});
	return 1;
}
function on_queue_completed(file)
{
	__log('Queue completed');
	carousel_refresh_images_table(carousel_current_album_id);
	
	return 1;	
}
function on_select_image()
{
	queue_files++;
	jQuery('#queue_files').html(queue_files);
}
function on_remove_file()
{
	queue_files--;
	if( queue_files < 0 )
		queue_files = 0;
	jQuery('#queue_files').html(queue_files);
}
function carousel_refresh_albums_table()
{
	jQuery('#albums_table tbody').html('<tr><td colspan="7" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing albums</td></tr>');
	//sleep(2000);
	jQuery.post('index.php', 'task=carousel_get_albums_table', function(res)
	{
		carousel_set_data_tables();
		if (res.status == 'ok') 
		{
			jQuery('#albums_table tbody').html(res.rows);
		}
		else
		{
			alert(res.message);
		}
	});
}
function carousel_refresh_images_table(album_id)
{
	jQuery('#album_images tbody').html('<tr><td colspan="8" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing album images</td></td></tr>');
	jQuery.post('index.php', 'task=carousel_get_albums_images_table&album_id='+album_id, function(res)
	{
		carousel_set_data_tables();
		if (res.status == 'ok') 
		{
			jQuery('#album_images tbody').html(res.rows);
		}
		else
		{
			alert(res.message);
		}
	});
}
function carousel_delete_album()
{
	var res = confirm('Are you sure to cotinue deleteing this album?');
	if( res )
	{
		jQuery.get(jQuery(this).attr('href'), function(res)
		{
			if( res.status == 'ok')
			{
				carousel_refresh_albums_table();
			}
			else
			{
				alert(res.message);
			}
		});
	}
	return false;
}
function re_order()
{
	var album_id = this.album_id.value;
	var task = this.task.value;
	if( task == 'carousel_reorder_album' )
		jQuery('#albums_table tbody').html('<tr><td colspan="7" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing albums</td></tr>');
	if( task == 'carousel_reorder_image' )
		jQuery('#album_images tbody').html('<tr><td colspan="8" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing albums</td></tr>');
	var params = jQuery(this).serialize();
	jQuery.get('index.php?' + params, function(res)
	{
		if( task == 'carousel_reorder_image' )
		{
			carousel_refresh_images_table(album_id);
		}
		if( task == 'carousel_reorder_album' )
			carousel_refresh_albums_table();
			
	});
	return false;
}
var tpager = null;
var ipager = null;
function carousel_set_data_tables()
{
	//add event to bulk actions
	jQuery('.bulk_form').live('submit', carousel_submit_bulk);
	if( document.getElementById('albums_table') != null )
	{
		tpager = new Pager('albums_table', def_rows_per_page);
		tpager.init();
		tpager.showPageNav('tpager', 'albums_pager');
		tpager.showPage(1);	
	}
	if( document.getElementById('album_images') != null )
	{
		ipager = new Pager('album_images', def_rows_per_page);
		ipager.init();
		ipager.showPageNav('ipager', 'images_pager');
		ipager.showPage(1);	
	}
}
function carousel_submit_bulk()
{
	var task = this.task.value;
	var album_id = null;
	if( task == 'carousel_bulk_delete_albums' || task == 'carousel_bulk_enable_albums' || task == 'carousel_bulk_disable_albums')
	{
		var selected = jQuery('table#albums_table tbody input[type=checkbox]:checked');
		//delete selected albums
		if( selected.length <= 0) return false;
		var ids = '[';
		jQuery(selected).each(function(i,v)
		{
			ids += v.value+',';
		});
		ids = ids.substr(0, ids.length -1);
		ids += ']';
		
		__log(ids);
		jQuery('#albums_table tbody').html('<tr><td colspan="7" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing albums</td></tr>');
		jQuery.post('index.php', 'task='+task+'&ids='+ids, function(res)
		{
				carousel_refresh_albums_table();
				if( res.status == 'error')
				{
					alert(res.message);
				}
		});
	}
	else if( task == 'carousel_bulk_delete_images' || task == 'carousel_bulk_enable_images' || task == 'carousel_bulk_disable_images' )
	{
		var selected = jQuery('table#album_images tbody input[type=checkbox]:checked');
		if( selected.length <= 0 )
		{
			return false;
		}
		//delete selected images
		var ids = '[';
		jQuery(selected).each(function(i,v)
		{
			
			ids += v.value+',';
		});
		ids = ids.substr(0, ids.length -1);
		ids += ']';
		__log(ids);
		jQuery('#album_images tbody').html('<tr><td colspan="8" align="center"><img src="'+loading.src+'" alt="" /><br/>Please wait, refreshing albums</td></tr>');
		jQuery.post('index.php', 'task='+task+'&ids='+ids, function(res)
		{
			carousel_refresh_images_table(carousel_current_album_id);
			if( res.status == 'error')
			{
				alert(res.message);
			}
		});
	} 
	
	return false;
}
function set_table_rows(table, rows, pager_id)
{
	__log(document.getElementById(table));
	if( document.getElementById(table) == null )
	{
		__log("no table found: " + table);
		return false;
	}
	if( document.getElementById(pager_id) == null )
	{
		__log("no table pager: " + pager_id);
		return false;
	}
	rows = parseInt(rows);
	if(table == 'albums_table')
	{
		tpager = new Pager(table, rows);
		tpager.init();
		tpager.showPageNav('tpager', pager_id);
		tpager.showPage(1);	
	}
	else if( table == 'album_images' )
	{
		ipager = new Pager(table, rows);
		ipager.init();	
		ipager.showPageNav('ipager', pager_id);
		ipager.showPage(1);
	}
	
	return true;
}
function carousel_enable()
{
	var page = jQuery(this).attr('href');
	if( jQuery(this).hasClass('album') )
	{
		jQuery.get(page, function(res)
		{
			carousel_refresh_albums_table();	
		});
	}
	else if( jQuery(this).hasClass('image') )
	{
		jQuery.get(page, function(res)
		{
			carousel_refresh_images_table(carousel_current_album_id);	
		});
	}	
	return false;
}
function carousel_disable()
{
	var page = jQuery(this).attr('href');
	if( jQuery(this).hasClass('album') )
	{
		jQuery.get(page, function(res)
		{
			carousel_refresh_albums_table();	
		});
		
	}
	else if( jQuery(this).hasClass('image') )
	{
		jQuery.get(page, function(res)
		{
			carousel_refresh_images_table(carousel_current_album_id);	
		});
		
	}	
	return false;
}
jQuery(function($)
{
	//preload images
	loading.src = carousel_url + '/images/loading.gif';
	
	jQuery('#add_new_album').toggle(function()
	{
		jQuery('#add_new_album_form').slideDown();
	}, 
	function()
	{
		jQuery('#add_new_album_form').slideUp();
	});
	//show default tab for upload image
	if( jQuery('#single_upload').length > 0)
	{
		jQuery('#single_upload').css('display', 'block');
	}
	//add tabs events
	if(jQuery('.tab').length > 0)
	{
		jQuery('.tab').click(function()
		{
			//hide all tab content
			jQuery('.tab_content').css('display', 'none');
			jQuery('.tab').removeClass('current');
			jQuery(this).addClass('current');
			var tab_id = jQuery(this).attr('rel');
			jQuery(tab_id).fadeIn();
			return false;
		});
	}
	if( /*jQuery.uploadify &&*/ jQuery('#spanButtonPlaceHolder').length > 0)
	{
/*
		var ops = {
					'uploader'		: carousel_url + '/js/uploadify-2.1.4/uploadify.swf',
					'script'		: carousel_url + '/js/uploadify-2.1.4/uploadify.php',
					'cancelImg' 	: carousel_url + '/js/uploadify-2.1.4/cancel.png',
				    'folder'    	: carousel_upload_dir,
				    'auto'			: true,
					'multi'			: true,
					'fileExt'        : '*.jpg;*.gif;*.png',
  					'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
					'queueID'        : 'upload_queue',
					'queueSizeLimit' : 10,
  					'simUploadLimit' : 2,
					'removeCompleted': true,
					'onSelectOnce'   : on_select_image,
					'onCancel'		: on_remove_file,
				    'onComplete' 	: on_upload_success,
					'onAllComplete'	: on_queue_completed
				};
		jQuery('#uploadify').uploadify(ops);
*/
		var swfu;


			var settings = {
				flash_url : carousel_url+"/js/swfupload/js/swfupload.swf",
				upload_url: carousel_url+"/js/swfupload/js/upload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>","folder":carousel_upload_dir, "secw":carousel_secw, nopar: "n" + new Date().getTime()},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: carousel_url+"/js/swfupload/js/TestImageNoText_65x29.png",
				button_width: "130",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Select Images</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : on_upload_success,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : on_queue_completed	// Queue plugin event
			};

			swfu = new SWFUpload(settings);


	}
	jQuery('.confirmation').click(__confirmation);
	
	carousel_set_data_tables();
	//add delete album event
	jQuery('.carousel_delete_album').live('click', carousel_delete_album);
	//set event for reorder forms
	jQuery('.order_form').live('submit', re_order);
	//reset checkbox
	jQuery('.select_all_images').attr('checked', false);
	//set bulk event
	jQuery('.select_all_images').bind('mouseup',select_all_images);//, deselect_all_images);
	//set enable disable album event
	jQuery('table#album_images .enable, table#albums_table .enable').live('click', carousel_enable);
	jQuery('table#album_images .disable, table#albums_table .disable').live('click', carousel_disable);
	
});
function select_all_images(evt)
{
	var table = jQuery(this).parents('table:first');
	__log(jQuery(this).attr('checked'));
	
	if( !jQuery(this).attr('checked') )
	{
		jQuery(table).find('tbody input[type=checkbox]').attr('checked', true);
	}	
	else
	{
		jQuery(table).find('tbody input[type=checkbox]').attr('checked', false);
	}
		
	
	return true;
	
}
function deselect_all_images()
{
	var table = jQuery(this).parents('table:first');
	jQuery(table).find('input[type=checkbox]').attr('checked', false);
	jQuery(this).attr('checked', false);
	return true;
}
