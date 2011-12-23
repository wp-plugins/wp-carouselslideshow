<?php
/**
 * @package Carousel Slideshow for WordPress
 * @version 1.2
 */
/*
Plugin Name: wp-carouselslideshow
Plugin URI: http://wpslideshow.com/carousel-slideshow/
Description: Carousel slideshow is a plugin that allows you to display a slideshow on your website.It is also allow us to use it as a widget. You can also enable this Blaze slideshow on your wordpress site by placing code snippet in your template php file.
Author: wpslideshow.com
Version: 1.2
Author URI: http://wpslideshow.com 
*/

define("fbname_carouselslideshow","wp-carouselslideshow");
require_once (ABSPATH .'wp-content/plugins/'.constant("fbname_carouselslideshow").'/noimage_functions.php');

function carouselslideshow() {
	ob_start();
	$floatbarurl = get_bloginfo('wpurl').'/wp-content/plugins/'.constant("fbname_carouselslideshow").'/';

	$xmlUrl = str_replace("themes","plugins",get_theme_root()).'/'.constant("fbname_carouselslideshow").'/slideshow.xml'; // XML feed file/URL

	$xmlStr = file_get_contents($xmlUrl);
	$xmlObj = simplexml_load_string($xmlStr, null, LIBXML_NOCDATA);
	$arrXml = objectsIntoArray_carouselslideshow($xmlObj);
	$temp=FloatBar_read_config_carouselslideshow();

?>

<script type="text/javascript" src="<?php echo $floatbarurl; ?>Scripts/swfobject.js"></script>
<script type="text/javascript">

		var FlashVars = {
			dataFile: "<?php echo $floatbarurl; ?>slideshow.xml"
		};
		var params = {
			bgcolor: "<?php echo $temp['bgcolor'];?>",
			wmode: "<?php echo $temp['wmode'];?>"
		};
		
		var attributes = {
			id: "slideshow"
		};
		
		
		swfobject.embedSWF("<?php echo $floatbarurl; ?>wp-carouselslideshow.swf", "carouselSlideshow", "<?php echo $temp['slideshow_width'];?>", "<?php echo $temp['slideshow_height'];?>", "9,0,0,0", false, FlashVars, params, attributes);

</script>
<div id="carouselSlideshow"></div>

<?php

$o = ob_get_contents();
ob_end_clean();
return $o;

}

add_shortcode('carousel_slideshow', 'carouselslideshow');

function my_plugin_menu_carouselslideshow() {
  add_menu_page('My Plugin Options', 'Carousel Slideshow Settings', 'administrator', 'your-unique-identifier_carouselslideshow', 'my_plugin_options_carouselslideshow');

}

function uploadPic_carouselslideshow($a){
	$filetype = $a['type'];
	if(strpos($filetype,"jpeg")!==false){
	$type = '.jpg';
	}else if(strpos($filetype,"gif")!==false){
	$type = '.gif';
	}else if(strpos($filetype,"png")!==false){
	$type = '.png';
	}
	else {
	echo "Please upload only valid JPG, GIF or PNG files";
	return false;

	}
	$upfile = str_replace("themes","plugins",get_theme_root()).'/'.constant("fbname_carouselslideshow").'/images/'.$a['name'];

	move_uploaded_file($a['tmp_name'],$upfile);
	$b="wp-content/plugins/".constant("fbname_carouselslideshow")."/images/".$a['name'];
	return $b;

}

function my_plugin_options_carouselslideshow() {

$temp=get_option("product_list_url"); 
preg_match("/\?[^=]*=\d+/",$temp,$b);

	if ($_POST["wmode"]!="")
	{

		$configxml="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
	<slideshow>";

	$configxml.=" 
	
	<settings>
		<panel width=\"".$_POST["slideshow_width"]."\" height=\"".$_POST["slideshow_height"]."\" />
		<main_image width=\"".$_POST["mainimage_width"]."\" height=\"".$_POST["mainimage_height"]."\" /> <background>".$_POST["bgcolor"]."</background>
		<autoslide on=\"".$_POST["auto_slide"]."\" time=\"".$_POST["autoslide_time"]."\" />
		<transition_speed>".$_POST["transition_speed"]."</transition_speed>
		<transition_type>".$_POST["transition_type"]."</transition_type>
		<description>
			<location >".$_POST["desc_position"]."</location>
			<background>".$_POST["desc_bgcolor"]."</background>
			<alpha>".$_POST["desc_bgcoloralpha"]."</alpha>
			<text>".$_POST["desc_color"]."</text>
			<roundness>".$_POST["desc_roundness"]."</roundness>
			
		</description>
		<border size=\"".$_POST["slideshow_bordersize"]."\" color=\"".$_POST["slideshow_bordercolor"]."\" />
		<reflection>".$_POST["image_reflection"]."</reflection>
		<progress>
			<show>".$_POST["progressbar"]."</show>
			<location>".$_POST["progressbar_position"]."</location>
			<color>".$_POST["progressbar_color"]."</color>
			<highlight>".$_POST["progressbar_highlightcolor"]."</highlight>
			<alpha>".$_POST["progressbar_alpha"]."</alpha>
		</progress>
	</settings>
	<snow_effect 	
		type=\"".$_POST["snoweffect_type"]."\"
		
		minimumSize=\"".$_POST["min_particle_size"]."\"
		maximumSize=\"".$_POST["max_particle_size"]."\" 		
		minimumSpeedY=\"".$_POST["min_particle_yspeed"]."\"
		maximumSpeedY=\"".$_POST["max_particle_yspeed"]."\"		
		minimumSpeedX=\"".$_POST["min_particle_xspeed"]."\"
		maximumSpeedX=\"".$_POST["max_particle_xspeed"]."\"		
		numOfParticles=\"".$_POST["noof_particles"]."\"
		minimumRotation=\"0\"
		maximumRotation=\"0\"		
		minimumAlpha=\"".$_POST["min_particle_alpha"]."\"
		maximumAlpha=\"".$_POST["max_particle_alpha"]."\"
		minimumBlur=\"".$_POST["min_particle_blur"]."\"
		maximumBlur=\"".$_POST["max_particle_blur"]."\"
	/>
	<pictures>";


$exist_url = get_bloginfo('wpurl');
$server_path = getCurUrl($exist_url);

//////////////////////////////////////////

	$jsondata=preg_split("/,,/",stripslashes($_POST["picStorage"]));


	for($i=0;$i<count($jsondata);$i++)
	{
		$www=json_decode($jsondata[$i],true);
	
		if($www["fileimage"]!="")
		{

		$imagesPath_image=uploadPic_carouselslideshow($_FILES[$www["fileimage"]]);
		$www["Pic"]=$imagesPath_image;

		}

		//// Main Image url
$substr_cnt_main = substr_count($www["Pic"], 'http://');

if($substr_cnt_main > 0){
	if(substr_count($server_path, 'www'))
		{
		  if(substr_count($www["Pic"], 'www'))
				{
					$main_image = $www["Pic"];
				}else{
					$main_image = str_replace("http://","http://www.",$www["Pic"]);
				}
		}else{
		$main_image = $www["Pic"];
		}


}else{
	$main_image = get_bloginfo('wpurl')."/".$www["Pic"];
}

$configxml.=" <picture src=\"".$main_image."\" scale=\"".$_POST["picture_scalling"]."\">";

$configxml.=" <link target=\"".$_POST["target"]."\">".$www["Url"]."</link>";

$configxml.=" <description>".$www["Desc"]."</description>";

$configxml.=" </picture>";
	}

	$configxml.="</pictures></slideshow>";

       if(!$file = @fopen(str_replace("themes","plugins",get_theme_root()).'/'.constant("fbname_carouselslideshow").'/slideshow.xml', 'w')){
           	echo "Can't open the file!";
          } else {
            fwrite($file, $configxml);
            fclose($file);
			echo "Successfully made the config.xml.";
           }	

	}

	$temp=FloatBar_read_config_carouselslideshow();
?>

<h2>data.xml build up:</h2>

<form name="form1" method="post" action="" enctype="multipart/form-data">

Slideshow Width (px): <input type="text" name="slideshow_width" value="<?php echo $temp["slideshow_width"];?>" /><br />

Slideshow Height (px): <input type="text" name="slideshow_height" value="<?php echo $temp["slideshow_height"];?>" /><br />

Main Image Width: <input type="text" name="mainimage_width" value="<?php echo $temp["mainimage_width"];?>" /><br />

Main Image Height: <input type="text" name="mainimage_height" value="<?php echo $temp["mainimage_height"];?>" /><br />

Background Color: <input type="text" name="bgcolor" value="<?php echo $temp["bgcolor"];?>" /><br />

Auto Slide: <select name="auto_slide">
<option value="true" <?php if($temp["auto_slide"]=="true")echo "selected=\"selected\""; ?>>Yes</option>
<option value="false" <?php if($temp["auto_slide"]=="false")echo "selected=\"selected\""; ?>>No</option></select><br />

Autoslide Time: <input type="text" name="autoslide_time" value="<?php echo $temp["auto_slidetime"];?>" /><br />

Transition Speed: <input type="text" name="transition_speed" value="<?php echo $temp["transition_speed"];?>" /><br />

Transition Type: <select name="transition_type">
<option value="easeOut" <?php if($temp["transition_type"]=="easeOut")echo "selected=\"selected\""; ?>>EaseOut</option>
<option value="easeOutBounce" <?php if($temp["transition_type"]=="easeOutBounce")echo "selected=\"selected\""; ?>>EaseOut Bounce</option></select><br />

Description Position: <select name="desc_position">
<option value="top" <?php if($temp["desc_position"]=="top")echo "selected=\"selected\""; ?>>Top</option>
<option value="bottom" <?php if($temp["desc_position"]=="bottom")echo "selected=\"selected\""; ?>>Bottom</option></select><br />

Description Bgcolor: <input type="text" name="desc_bgcolor" value="<?php echo $temp["desc_bgcolor"];?>" /><br />

Description Bgcolor Alpha: <input type="text" name="desc_bgcoloralpha" value="<?php echo $temp["desc_bgcoloralpha"];?>" /><br />

Description Color: <input type="text" name="desc_color" value="<?php echo $temp["desc_color"];?>" /><br />

Description Corner Radious: <input type="text" name="desc_roundness" value="<?php echo $temp["desc_roundness"];?>" /><br />

Slideshow Border Size: <input type="text" name="slideshow_bordersize" value="<?php echo $temp["slideshow_bordersize"];?>" /><br />

Slideshow Border Color: <input type="text" name="slideshow_bordercolor" value="<?php echo $temp["slideshow_bordercolor"];?>" /><br />

Image Reflection Type: <input type="text" name="image_reflection" value="<?php echo $temp["image_reflection"];?>" />(1.image,2.noimage,3.color(Ex:000000))<br />

Show Progress bar: <select name="progressbar">
<option value="true" <?php if($temp["progressbar"]=="true")echo "selected=\"selected\""; ?>>Yes</option>
<option value="false" <?php if($temp["progressbar"]=="false")echo "selected=\"selected\""; ?>>No</option></select><br />

Progress bar Position: <select name="progressbar_position">
<option value="top" <?php if($temp["progressbar_position"]=="top")echo "selected=\"selected\""; ?>>Top</option>
<option value="bottom" <?php if($temp["progressbar_position"]=="bottom")echo "selected=\"selected\""; ?>>Bottom</option></select><br />

Progress bar color: <input type="text" name="progressbar_color" value="<?php echo $temp["progressbar_color"];?>" /><br />

Progress bar circle highlight color: <input type="text" name="progressbar_highlightcolor" value="<?php echo $temp["progressbar_highlightcolor"];?>" /><br />

Progressbar Alpha: <input type="text" name="progressbar_alpha" value="<?php echo $temp["progressbar_alpha"];?>" /><br />

Picture Scalling: <select name="picture_scalling">
<option value="true" <?php if($temp["picture_scalling"]=="true")echo "selected=\"selected\""; ?>>Yes</option>
<option value="false" <?php if($temp["picture_scalling"]=="false")echo "selected=\"selected\""; ?>>No</option></select><br />

<!--- Snow Effect settings -->
Snow Effect Type: <select name="snoweffect_type">
<option value="0" <?php if($temp["snoweffect_type"]=="0")echo "selected=\"selected\""; ?>>No Snow Effect</option>
<option value="1" <?php if($temp["snoweffect_type"]=="1")echo "selected=\"selected\""; ?>>Type 1</option>
<option value="2" <?php if($temp["snoweffect_type"]=="2")echo "selected=\"selected\""; ?>>Type 2</option>
<option value="3" <?php if($temp["snoweffect_type"]=="3")echo "selected=\"selected\""; ?>>Type 3</option>
</select><br />

Small particle size: <input type="text" name="min_particle_size" value="<?php echo $temp["min_particle_size"];?>" /><br />

Big particle size: <input type="text" name="max_particle_size" value="<?php echo $temp["max_particle_size"];?>" /><br />

Small particle Y-speed: <input type="text" name="min_particle_yspeed" value="<?php echo $temp["min_particle_yspeed"];?>" /><br />

Big particle Y-speed: <input type="text" name="max_particle_size" value="<?php echo $temp["max_particle_size"];?>" /><br />

Small particle X-speed: <input type="text" name="min_particle_xspeed" value="<?php echo $temp["min_particle_xspeed"];?>" /><br />

Big particle X-speed: <input type="text" name="max_particle_xspeed" value="<?php echo $temp["max_particle_xspeed"];?>" /><br />

Number of particles: <input type="text" name="noof_particles" value="<?php echo $temp["noof_particles"];?>" /><br />

<!--Small particle rotation: <input type="text" name="min_particle_rotation" value="<?php echo $temp["min_particle_rotation"];?>" /><br />

Big particle rotation: <input type="text" name="max_particle_rotation" value="<?php echo $temp["max_particle_rotation"];?>" /><br />-->

Small Particle alpha: <select name="min_particle_alpha">
<option value="0" <?php if($temp["min_particle_alpha"]=="0")echo "selected=\"selected\""; ?>>0</option>
<option value="0.1" <?php if($temp["min_particle_alpha"]=="0.1")echo "selected=\"selected\""; ?>>0.1</option>
<option value="0.2" <?php if($temp["min_particle_alpha"]=="0.2")echo "selected=\"selected\""; ?>>0.2</option>
<option value="0.3" <?php if($temp["min_particle_alpha"]=="0.3")echo "selected=\"selected\""; ?>>0.3</option>
<option value="0.4" <?php if($temp["min_particle_alpha"]=="0.4")echo "selected=\"selected\""; ?>>0.4</option>
<option value="0.5" <?php if($temp["min_particle_alpha"]=="0.5")echo "selected=\"selected\""; ?>>0.5</option>
<option value="0.6" <?php if($temp["min_particle_alpha"]=="0.6")echo "selected=\"selected\""; ?>>0.6</option>
<option value="0.7" <?php if($temp["min_particle_alpha"]=="0.7")echo "selected=\"selected\""; ?>>0.7</option>
<option value="0.8" <?php if($temp["min_particle_alpha"]=="0.8")echo "selected=\"selected\""; ?>>0.8</option>
<option value="0.9" <?php if($temp["min_particle_alpha"]=="0.9")echo "selected=\"selected\""; ?>>0.9</option>
<option value="1" <?php if($temp["min_particle_alpha"]=="1")echo "selected=\"selected\""; ?>>1</option>
</select><br />

Big Particle alpha: <select name="max_particle_alpha">
<option value="0" <?php if($temp["max_particle_alpha"]=="0")echo "selected=\"selected\""; ?>>0</option>
<option value="0.1" <?php if($temp["max_particle_alpha"]=="0.1")echo "selected=\"selected\""; ?>>0.1</option>
<option value="0.2" <?php if($temp["max_particle_alpha"]=="0.2")echo "selected=\"selected\""; ?>>0.2</option>
<option value="0.3" <?php if($temp["max_particle_alpha"]=="0.3")echo "selected=\"selected\""; ?>>0.3</option>
<option value="0.4" <?php if($temp["max_particle_alpha"]=="0.4")echo "selected=\"selected\""; ?>>0.4</option>
<option value="0.5" <?php if($temp["max_particle_alpha"]=="0.5")echo "selected=\"selected\""; ?>>0.5</option>
<option value="0.6" <?php if($temp["max_particle_alpha"]=="0.6")echo "selected=\"selected\""; ?>>0.6</option>
<option value="0.7" <?php if($temp["max_particle_alpha"]=="0.7")echo "selected=\"selected\""; ?>>0.7</option>
<option value="0.8" <?php if($temp["max_particle_alpha"]=="0.8")echo "selected=\"selected\""; ?>>0.8</option>
<option value="0.9" <?php if($temp["max_particle_alpha"]=="0.9")echo "selected=\"selected\""; ?>>0.9</option>
<option value="1" <?php if($temp["max_particle_alpha"]=="1")echo "selected=\"selected\""; ?>>1</option>
</select><br />

Small particle blur: <input type="text" name="min_particle_blur" value="<?php echo $temp["min_particle_blur"];?>" /><br />

Big particle blur: <input type="text" name="max_particle_blur" value="<?php echo $temp["max_particle_blur"];?>" /><br />

Target Link: <select name="target">
<option value="_self" <?php if($temp["target"]=="_self")echo "selected=\"selected\""; ?>>Same Window</option>
<option value="_blank" <?php if($temp["target"]=="_blank")echo "selected=\"selected\""; ?>>New Window</option>
</select><br />

wmode: <select name="wmode"><option value="transparent" <?php if($temp["wmode"]=="transparent")echo "selected=\"selected\""; ?>>transparent</option><option value="opaque" <?php if($temp["wmode"]=="opaque")echo "selected=\"selected\""; ?>>opaque</option><option value="window" <?php if($temp["wmode"]=="window")echo "selected=\"selected\""; ?>>window</option></select><br />

<div id="slidePics">
Images Directory: wp-content/plugins/<?php echo constant("fbname_carouselslideshow"); ?>/images/<br><br/>
<fieldset  style="border:1px solid #000000;padding:10px;">
    <legend>Images & Data </legend>
<?php

for ($i=0;$i<count($temp["picStorage"]);$i++)
{
?>
<fieldset  style="border:1px solid #000000;padding:10px;">
<legend>content image <?php echo $i+1?></legend>
<span><select onchange="handleSelectChange(this)"><option value="YES" <?php if($temp["picStorage"][$i]["Pic"]==""){"selected=\"selected\"";} ?>>Upload Image</option><option value="NO" <?php if($temp["picStorage"][$i]["Pic"]!=""){echo "selected=\"selected\"";} ?>>Use image path</option></select> <div style="display:inline;"><div style="display:inline;<?php if($temp["picStorage"][$i]["Pic"]==""){echo "display:none";} ?>">Full Image:<input type="text" value="<?php echo $temp["picStorage"][$i]["Pic"]; ?>" /></div> <div style="<?php if($temp["picStorage"][$i]["Pic"]!=""){echo "display:none";} ?>">image: <input type='file' name='file_image<?php echo $i; ?>' /></div></div><br/> Desc:<input type="text" value="<?php echo $temp["picStorage"][$i]["Desc"]; ?>" /><br/>Image Link:<input type="text" value="<?php echo $temp["picStorage"][$i]["Url"]; ?>" /><input type="button" value="+" onclick="slidePicsAdd(this)" /><input type="button" value="-" onclick="slidePicsDelete(this)" /></span><br>

</fieldset>
<?php
}


?>
</fieldset>
</div>
<p>To display this slideshow on your blog, type in <code>[carousel_slideshow]</code> on any page.</p>
<input type="hidden" name="picStorage" id="picStorage" value="aaaaaaaa" /><br>

<input type="submit" value="Make Config.xml" onclick="slidePicsStorage()" />
</form>
<script>
var countImages=<?php echo count($temp["picStorage"]);?>;
	
function handleSelectChange(a){
if(a.value=="YES")
{
jQuery(a).next().children().first().hide()
jQuery(a).next().children().last().show()

}
else
{
jQuery(a).next().children().first().show()
jQuery(a).next().children().last().hide()

}
}
function slidePicsAdd(a){
jQuery(a).parent().parent().append('<span><select onchange="handleSelectChange(this)"><option value="YES">Upload Image</option><option value="NO">Use image path</option></select> <div style="display:inline;"><div style="display:inline;display:none;">Full Image:<input type="text" /></div> <div style="<?php if($temp["picStorage"][$i]["pic"]!=""){echo "display:none";} ?>"> image:<input type=\'file\' name=\'file_image'+(++countImages)+'\' /></div></div><br> Desc:<input type="text" /> <br/>Image Link:<input type="text" /><input type="button" value="+" onclick="slidePicsAdd(this)" /><input type="button" value="-" onclick="slidePicsDelete(this)" /></span><br>');

}	
function slidePicsDelete(a){
jQuery(a).parent().remove();
}	
function slidePicsStorage(){
	var temp="";
	var limit=jQuery("#slidePics span").length;
	for (var i=0;i<limit ;i++ )
	{
		temp+="{";
		if(jQuery("#slidePics span:eq("+i+") select").val()=="YES")
		{
		temp+="\"fileimage\":\""+jQuery("#slidePics span:eq("+i+") input[type=file]:eq(0)").attr("name")+"\",";
		}
		else
		{
		temp+="\"Pic\":\""+jQuery("#slidePics span:eq("+i+") input[type=text]")[0].value+"\",";		
		}
		
		temp+="\"Desc\":\""+jQuery("#slidePics span:eq("+i+") input[type=text]")[1].value+"\",\"Url\":\""+jQuery("#slidePics span:eq("+i+") input[type=text]")[2].value+"\"},,";
	}
	temp=temp.slice(0,temp.length-2);
	jQuery("#picStorage").val(temp);
}

</script>

<?php

}

function objectsIntoArray_carouselslideshow($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();

	if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray_carouselslideshow($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}



function FloatBar_read_config_carouselslideshow(){

$exist_url = get_bloginfo('wpurl');
$server_path = getCurUrl($exist_url);

$xmlUrl = str_replace("themes","plugins",get_theme_root()).'/'.constant("fbname_carouselslideshow").'/slideshow.xml'; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr, null, LIBXML_NOCDATA);
$arrXml = objectsIntoArray_carouselslideshow($xmlObj);
$a["slideshow_width"]=$arrXml["settings"]["panel"]["@attributes"]["width"];
$a["slideshow_height"]=$arrXml["settings"]["panel"]["@attributes"]["height"];
$a["mainimage_height"]=$arrXml["settings"]["main_image"]["@attributes"]["height"];
$a["mainimage_width"]=$arrXml["settings"]["main_image"]["@attributes"]["width"];
$a["mainimage_height"]=$arrXml["settings"]["main_image"]["@attributes"]["height"];
$a["bgcolor"]=$arrXml["settings"]["background"];
$a["title_autohide"]=$arrXml["settings"]["autoslide"]["@attributes"]["on"];
$a["auto_slidetime"]=$arrXml["settings"]["autoslide"]["@attributes"]["time"];
$a["transition_speed"]=$arrXml["settings"]["transition_speed"];
$a["transition_type"]=$arrXml["settings"]["transition_type"];
$a["desc_position"]=$arrXml["settings"]["description"]["location"];
$a["desc_bgcolor"]=$arrXml["settings"]["description"]["background"];
$a["desc_bgcoloralpha"]=$arrXml["settings"]["description"]["alpha"];
$a["desc_color"]=$arrXml["settings"]["description"]["text"];
$a["desc_roundness"]=$arrXml["settings"]["description"]["roundness"];
$a["slideshow_bordersize"]=$arrXml["settings"]["border"]["@attributes"]["size"];
$a["slideshow_bordercolor"]=$arrXml["settings"]["border"]["@attributes"]["color"];
$a["image_reflection"]=$arrXml["settings"]["reflection"];
$a["progressbar"]=$arrXml["settings"]["progress"]["show"];
$a["progressbar_position"]=$arrXml["settings"]["progress"]["location"];
$a["progressbar_color"]=$arrXml["settings"]["progress"]["color"];
$a["progressbar_highlightcolor"]=$arrXml["settings"]["progress"]["highlight"];
$a["progressbar_alpha"]=$arrXml["settings"]["progress"]["alpha"];
$a["picture_scalling"]=$arrXml["pictures"]["picture"]["@attributes"]["scale"];

$a["snoweffect_type"]=$arrXml["snow_effect"]["@attributes"]["type"];
$a["min_particle_size"]=$arrXml["snow_effect"]["@attributes"]["minimumSize"];
$a["max_particle_size"]=$arrXml["snow_effect"]["@attributes"]["maximumSize"];
$a["min_particle_yspeed"]=$arrXml["snow_effect"]["@attributes"]["minimumSpeedY"];

$a["max_particle_yspeed"]=$arrXml["snow_effect"]["@attributes"]["maximumSpeedY"];
$a["min_particle_xspeed"]=$arrXml["snow_effect"]["@attributes"]["minimumSpeedX"];
$a["max_particle_xspeed"]=$arrXml["snow_effect"]["@attributes"]["maximumSpeedX"];
$a["noof_particles"]=$arrXml["snow_effect"]["@attributes"]["numOfParticles"];

$a["min_particle_rotation"]=$arrXml["snow_effect"]["@attributes"]["minimumRotation"];
$a["max_particle_rotation"]=$arrXml["snow_effect"]["@attributes"]["maximumRotation"];
$a["min_particle_alpha"]=$arrXml["snow_effect"]["@attributes"]["minimumAlpha"];
$a["max_particle_alpha"]=$arrXml["snow_effect"]["@attributes"]["maximumAlpha"];

$a["min_particle_blur"]=$arrXml["snow_effect"]["@attributes"]["minimumBlur"];
$a["max_particle_blur"]=$arrXml["snow_effect"]["@attributes"]["maximumBlur"];

$a["target"]=$arrXml["settings"]["target"];
$a["wmode"]=$arrXml["settings"]["wmode"];


$a["picStorage"]=array();
if($xmlObj->pictures->picture->attributes()->src)
{

	$num=count($xmlObj->pictures->picture);
	for ($i=0;$i<$num;$i++)
	{
		$a["picStorage"][$i]=array();
		
		$image = $xmlObj->pictures->picture[$i]->attributes()->src;
		$substr_cnt_image = substr_count($image, 'http://');
		if($substr_cnt_image > 0){
		if(substr_count($server_path, 'www'))
			{
		  if(substr_count($image, 'www'))
				{
					$slideshow_image = $image;
				}else{
					$slideshow_image = str_replace("http://","http://www.",$image);
				}
		}else{
		$slideshow_image = $image;
		}


		}else{
			$slideshow_image = get_bloginfo('wpurl')."/".$image;
		}

		$a["picStorage"][$i]["Pic"]=$slideshow_image;

		$a["picStorage"][$i]["Desc"]=$xmlObj->pictures->picture[$i]->description;
		$a["picStorage"][$i]["Url"]=$xmlObj->pictures->picture[$i]->link;
	}
}
else
{
	$num=1;
	$a["picStorage"][0]=array();
	$a["picStorage"][0]["Pic"]=$xmlObj->pictures->picture[$i]->attributes()->src;
	$a["picStorage"][0]["Desc"]=$xmlObj->pictures->picture[$i]->description;
	$a["picStorage"][0]["Url"]=$xmlObj->pictures->picture[$i]->link;
	
}

return $a;
}

add_action('admin_menu', 'my_plugin_menu_carouselslideshow');

///////// widget initialising code

function widget_carouselslideshow($args) {
  extract($args);
  echo $before_widget;
  echo do_shortcode('[carousel_slideshow]');
  echo $after_widget;
}
 
function myCarouselslideshow_init()
{
  register_sidebar_widget(__('Carousel Slideshow'), 'widget_carouselslideshow');
}
add_action("plugins_loaded", "myCarouselslideshow_init");
?>
