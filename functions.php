<?php
function carousel_get_def_settings()
{
	$carousel_settings = array('slideshow_width' => '550',
	'slideshow_height' => '390',
	'mainimage_width' => '400',
	'mainimage_height' => '300',
	'bgcolor' => 'E0E0E0',
	'auto_slide' => 'true',
	'autoslide_time' => '10',
	'transition_speed' => '50',
	'transition_type' => 'easeOut',
	'show_desc' => 'true',
	'desc_position' => 'bottom',
	'desc_bgcolor' => 'FF0000',
	'desc_bgcoloralpha' => '90',
	'desc_color' => 'FFFFFF',
	'desc_roundness' => '0',
	'slideshow_bordercolor' => 'FFFFFF',
	'image_reflection' => 'image',
	'progressbar' => 'true',
	'progressbar_position' => 'top',
	'progressbar_color' => 'A8A8A8',
	'progressbar_highlightcolor' => '000000',
	'progressbar_alpha' => '100',
	'picture_scalling' => 'true',
	'snoweffect_type' => '1',
	'noof_particles' => '125',
	'min_particle_blur' => '0',
	'max_particle_blur' => '6',
	'wmode' => 'opaque',
	'target' => '_self'
			);
	return $carousel_settings;
}
function __get_carousel_xml_settings()
{
	// (($ops['auto_play'] == 'yes') ? 'true' : 'false')
	//CRS_PLUGIN_URL.'/price_images/'.$ops['pricebtn_img']
	$ops = get_option('carousel_settings', array());
	$xml_settings = '<settings>
		<main_image width="'.$ops['mainimage_width'].'" height="'.$ops['mainimage_height'].'" />
		<background>'.$ops['bgcolor'].'</background>
		<autoslide on="'.$ops['auto_slide'].'" time="'.$ops['autoslide_time'].'" />
		<transition_speed>'.$ops['transition_speed'].'</transition_speed>
		<transition_type>'.$ops['transition_type'].'</transition_type>

		<description>
			<show>'.$ops['show_desc'].'</show>
			
			<location >'.$ops['desc_position'].'</location>
			<background>'.$ops['desc_bgcolor'].'</background>
			<alpha>'.$ops['desc_bgcoloralpha'].'</alpha>
			<text>'.$ops['desc_color'].'</text>

			<roundness>'.$ops['desc_roundness'].'</roundness>
			
		</description>
		<border size="4" color="'.$ops['slideshow_bordercolor'].'" />
		<reflection>'.$ops['image_reflection'].'</reflection>
		<progress>
			<show>'.$ops['progressbar'].'</show>
			<location>'.$ops['progressbar_position'].'</location>

			<color>'.$ops['progressbar_color'].'</color>
			<highlight>'.$ops['progressbar_highlightcolor'].'</highlight>
			<alpha>'.$ops['progressbar_alpha'].'</alpha>
		</progress>
	</settings><snow_effect 	
		type="'.$ops['snoweffect_type'].'"
		
		minimumSize="0.7"
		maximumSize="1.2"
		
		minimumSpeedY="2"
		maximumSpeedY="4"
		
		minimumSpeedX="0"
		maximumSpeedX="0"
		
		numOfParticles="'.$ops['noof_particles'].'"
		
		minimumRotation="0"
		maximumRotation="0"
		
		minimumAlpha="1"
		maximumAlpha="1"
		
		minimumBlur="'.$ops['min_particle_blur'].'"
		maximumBlur="'.$ops['max_particle_blur'].'"
	/>';
	return $xml_settings;
}
function carousel_get_album_dir($album_id)
{
	global $gcrs;
	$album_dir = CRS_PLUGIN_UPLOADS_DIR . "/{$album_id}_uploadfolder";
	return $album_dir;
}
/**
 * Get album url
 * @param $album_id
 * @return unknown_type
 */
function carousel_get_album_url($album_id)
{
	global $gcrs;
	$album_url = CRS_PLUGIN_UPLOADS_URL . "/{$album_id}_uploadfolder";
	return $album_url;
}
function carousel_get_table_actions(array $tasks)
{
	?>
	<div class="bulk_actions">
		<form action="" method="post" class="bulk_form">Bulk action
			<select name="task">
				<?php foreach($tasks as $t => $label): ?>
				<option value="<?php print $t; ?>"><?php print $label; ?></option>
				<?php endforeach; ?>
			</select>
			<button class="button-secondary do_bulk_actions" type="submit">Do</button>
		</form>
	</div>
	<?php 
}
function shortcode_display_carousel_gallery($atts)
{
	$vars = shortcode_atts( array(
									'cats' => '',
									'imgs' => '',
								), 
							$atts );
	//extract( $vars );
	
	$ret = display_carousel_gallery($vars);
	return $ret;
}
function display_carousel_gallery($vars)
{
	global $wpdb, $gcrs;
	$ops = get_option('carousel_settings', array());
	//print_r($ops);
	$albums = null;
	$images = null;
	$cids = trim($vars['cats']);
	if (strlen($cids) != strspn($cids, "0123456789,")) {
		$cids = '';
		$vars['cats'] = '';
	}
	$imgs = trim($vars['imgs']);
	if (strlen($imgs) != strspn($imgs, "0123456789,")) {
		$imgs = '';
		$vars['imgs'] = '';
	}
	$categories = '';
	$xml_filename = '';
	if( !empty($cids) && $cids{strlen($cids)-1} == ',')
	{
		$cids = substr($cids, 0, -1);
	}
	if( !empty($imgs) && $imgs{strlen($imgs)-1} == ',')
	{
		$imgs = substr($imgs, 0, -1);
	}
	//check for xml file
	if( !empty($vars['cats']) )
	{
		$xml_filename = "cat_".str_replace(',', '', $cids) . '.xml';	
	}
	elseif( !empty($vars['imgs']))
	{
		$xml_filename = "image_".str_replace(',', '', $imgs) . '.xml';
	}
	else
	{
		$xml_filename = "carousel_all.xml";
	}
	//die(CRS_PLUGIN_XML_DIR . '/' . $xml_filename);

	$imageContainer = "";
	
	if( !empty($vars['cats']) )
	{
		$query = "SELECT * FROM {$wpdb->prefix}carousel_albums WHERE album_id IN($cids) AND status = 1 ORDER BY `order` ASC";
		//print $query;
		$albums = $wpdb->get_results($query, ARRAY_A);
		foreach($albums as $key => $album)
		{
			$images = $gcrs->carousel_get_album_images($album['album_id']);
			if ($images && !empty($images) && is_array($images)) {
				$album_dir = carousel_get_album_url($album['album_id']);//CRS_PLUGIN_UPLOADS_URL . '/' . $album['album_id']."_".$album['name'];
				foreach($images as $key => $img)
				{
					if( $img['status'] == 0 ) continue;
					
					$imageContainer .= "<picture src=\"".str_replace(" ","-",$album_dir)."/big/{$img['image']}\" scale=\"".$ops['picture_scalling']."\"><link target=\"".$ops['target']."\">{$img['link']}</link><description>".($ops['show_desc']=='no'||$img['description']==""?"":$img['description'])."</description></picture>";

				}
			}
		}
		//$xml_filename = "cat_".str_replace(',', '', $cids) . '.xml';
	}
	elseif( !empty($vars['imgs']))
	{
		$query = "SELECT * FROM {$wpdb->prefix}carousel_images WHERE image_id IN($imgs) AND status = 1 ORDER BY `order` ASC";
		$images = $wpdb->get_results($query, ARRAY_A);
		if ($images && !empty($images) && is_array($images)) {
			foreach($images as $key => $img)
			{
				$album = $gcrs->carousel_get_album($img['category_id']);
				$album_dir = carousel_get_album_url($album['album_id']);//CRS_PLUGIN_UPLOADS_URL . '/' . $album['album_id']."_".$album['name'];
				if( $img['status'] == 0 ) continue;
				
				$imageContainer .= "<picture src=\"".str_replace(" ","-",$album_dir)."/big/{$img['image']}\" scale=\"".$ops['picture_scalling']."\"><link target=\"".$ops['target']."\">{$img['link']}</link><description>".($ops['show_desc']=='no'||$img['description']==""?"":$img['description'])."</description></picture>";

			}
		}
	}
	//no values paremeters setted
	else//( empty($vars['cats']) && empty($vars['imgs']))
	{
		$query = "SELECT * FROM {$wpdb->prefix}carousel_albums WHERE status = 1 ORDER BY `order` ASC";
		$albums = $wpdb->get_results($query, ARRAY_A);
		foreach($albums as $key => $album)
		{
			$images = $gcrs->carousel_get_album_images($album['album_id']);
			$album_dir = carousel_get_album_url($album['album_id']);//CRS_PLUGIN_UPLOADS_URL . '/' . $album['album_id']."_".$album['name'];
			if ($images && !empty($images) && is_array($images)) {
				foreach($images as $key => $img)
				{
					if($img['status'] == 0 ) continue;
					
					$imageContainer .= "<picture src=\"".str_replace(" ","-",$album_dir)."/big/{$img['image']}\" scale=\"".$ops['picture_scalling']."\"><link target=\"".$ops['target']."\">{$img['link']}</link><description>".($ops['show_desc']=='no'||$img['description']==""?"":$img['description'])."</description></picture>";

				}
			}
		}
		//$xml_filename = "carousel_all.xml";
	}
	
	$xml_tpl = __get_carousel_xml_template();
	$settings = __get_carousel_xml_settings();
//	$xml = str_replace(array('{settings}', '{default_category}', '{categories}'), 
//						array($settings, $album['album_id'], $categories), $xml_tpl);
	$xml = str_replace(array('{settings}', '{image_container}'), 
						array($settings, $imageContainer), $xml_tpl);
						
	//write new xml file
	$fh = fopen(CRS_PLUGIN_XML_DIR . '/' . $xml_filename, 'w+');
	fwrite($fh, $xml);
	fclose($fh);
	//print "<h3>Generated filename: $xml_filename</h3>";
	//print $xml;
	if( file_exists(CRS_PLUGIN_XML_DIR . '/' . $xml_filename ) )
	{
		$fh = fopen(CRS_PLUGIN_XML_DIR . '/' . $xml_filename, 'r');
		$xml = fread($fh, filesize(CRS_PLUGIN_XML_DIR . '/' . $xml_filename));
		fclose($fh);
		//print "<h3>Getting xml file from cache: $xml_filename</h3>";
		$ret_str = "
		<script language=\"javascript\">AC_FL_RunContent = 0;</script>
<script src=\"".CRS_PLUGIN_URL."/js/AC_RunActiveContent.js\" language=\"javascript\"></script>

		<script language=\"javascript\"> 
	if (AC_FL_RunContent == 0) {
		alert(\"This page requires AC_RunActiveContent.js.\");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '".$ops['slideshow_width']."',
			'height', '".$ops['slideshow_height']."',
			'src', '".CRS_PLUGIN_URL."/js/carouselslideshow',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', '".$ops['wmode']."',
			'devicefont', 'false',
			'id', 'xmlswf_vmcrs',
			'bgcolor', '".$ops['bgcolor']."',
			'name', 'xmlswf_vmcrs',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'movie', '".CRS_PLUGIN_URL."/js/carouselslideshow',
			'salign', '',
			'flashVars','dataFile=".CRS_PLUGIN_URL."/xml/$xml_filename'
			); //end AC code
	}
</script>
";
//echo CRS_PLUGIN_UPLOADS_URL."<hr>";
//		print $xml;
		return $ret_str;
	}
	return true;
}
function __get_carousel_xml_template()
{
	$xml_tpl = '<?xml version="1.0" encoding="utf-8" ?>
				<slideshow>
					{settings}<!-- end settings -->
					<pictures>
					{image_container}					    
					</pictures><!-- end images -->
				</slideshow>';
	return $xml_tpl;
}
?>