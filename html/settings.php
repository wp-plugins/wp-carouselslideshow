<?php
global $wpdb, $gpp;
$ops = get_option('pp_settings', array());
//$ops = array_merge($pp_settings, $ops);
?>
<div class="wrap">
	<h2><?php _e('Create XML File'); ?></h2>
	<form action="" method="post">
		<input type="hidden" name="task" value="save_pp_settings" />
		<table>
		<tr>
			<td><?php _e('Slideshow Width (px)'); ?></td>
			<td><input type="text" name="settings[slideshow_width]" value="<?php print  @$ops['slideshow_width']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Slideshow Height (px)'); ?></td>
			<td><input type="text" name="settings[slideshow_height]" value="<?php print  @$ops['slideshow_height']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Main Image WIdth'); ?></td>
			<td><input type="text" name="settings[mainimage_width]" value="<?php print  @$ops['mainimage_width']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Main Image Height'); ?></td>
			<td><input type="text" name="settings[mainimage_height]" value="<?php print  @$ops['mainimage_height']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Background Color'); ?></td>
			<td><input type="text" name="settings[bgcolor]" class="color {hash:false,caps:true}"  value="<?php print  @$ops['bgcolor']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Auto Slide'); ?></td>
			<td>
				<select name="settings[auto_slide]">
					<option value="true" <?php print (@$ops['auto_slide'] == 'true') ? 'selected' : ''; ?>><?php _e('On');?></option>

					<option value="false" <?php print (@$ops['auto_slide'] == 'false') ? 'selected' : ''; ?>><?php _e('Off');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Autoslide Time'); ?></td>
			<td><input type="text" name="settings[autoslide_time]"  value="<?php print  @$ops['autoslide_time']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Transition Speed'); ?></td>
			<td><input type="text" name="settings[transition_speed]" value="<?php print  @$ops['transition_speed']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Slide effect'); ?></td>
			<td>
				<select name="settings[transition_type]">
					<option value="easeOut" <?php print (@$ops['transition_type'] == 'easeOut') ? 'selected' : ''; ?>><?php _e('Ease Out');?></option>

					<option value="easeOutBounce" <?php print (@$ops['transition_type'] == 'easeOutBounce') ? 'selected' : ''; ?>><?php _e('EaseOut Bounce');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Show Description'); ?></td>
			<td>
				<select name="settings[show_desc]">
					<option value="true" <?php print (@$ops['show_desc'] == 'true') ? 'selected' : ''; ?>><?php _e('Yes');?></option>

					<option value="false" <?php print (@$ops['show_desc'] == 'false') ? 'selected' : ''; ?>><?php _e('No');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Description Position'); ?></td>
			<td>
				<select name="settings[desc_position]">
					<option value="top" <?php print (@$ops['desc_position'] == 'top') ? 'selected' : ''; ?>><?php _e('Top');?></option>

					<option value="bottom" <?php print (@$ops['desc_position'] == 'bottom') ? 'selected' : ''; ?>><?php _e('Bottom');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Description Bgcolor'); ?></td>
			<td><input type="text" name="settings[desc_bgcolor]" class="color {hash:false,caps:true}"  value="<?php print  @$ops['desc_bgcolor']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Description Bgcolor Alpha'); ?></td>
			<td><input type="text" name="settings[desc_bgcoloralpha]" value="<?php print  @$ops['desc_bgcoloralpha']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Description Color'); ?></td>
			<td><input type="text" name="settings[desc_color]" class="color {hash:false,caps:true}" value="<?php print  @$ops['desc_color']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Description Corner Radius'); ?></td>
			<td><input type="text" name="settings[desc_roundness]" value="<?php print  @$ops['desc_roundness']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Slideshow Border Color'); ?></td>
			<td><input type="text" name="settings[slideshow_bordercolor]" class="color {hash:false,caps:true}" value="<?php print  @$ops['slideshow_bordercolor']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Image Reflection Type'); ?></td>
			<td>
				<select name="settings[image_reflection]">
					<option value="image" <?php print (@$ops['image_reflection'] == 'image') ? 'selected' : ''; ?>><?php _e('Reflection');?></option>

					<option value="off" <?php print (@$ops['image_reflection'] == 'off') ? 'selected' : ''; ?>><?php _e('No Reflection');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Show Navigation bar'); ?></td>
			<td>
				<select name="settings[progressbar]">
					<option value="true" <?php print (@$ops['progressbar'] == 'true') ? 'selected' : ''; ?>><?php _e('Yes');?></option>

					<option value="false" <?php print (@$ops['progressbar'] == 'false') ? 'selected' : ''; ?>><?php _e('No');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Navigation bar Position'); ?></td>
			<td>
				<select name="settings[progressbar_position]">
					<option value="top" <?php print (@$ops['progressbar_position'] == 'top') ? 'selected' : ''; ?>><?php _e('Top');?></option>

					<option value="bottom" <?php print (@$ops['progressbar_position'] == 'bottom') ? 'selected' : ''; ?>><?php _e('Bottom');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Navigation bar color'); ?></td>
			<td><input type="text" name="settings[progressbar_color]" class="color {hash:false,caps:true}" value="<?php print  @$ops['progressbar_color']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Navigation bar circle highlight color'); ?></td>
			<td><input type="text" name="settings[progressbar_highlightcolor]" class="color {hash:false,caps:true}" value="<?php print  @$ops['progressbar_highlightcolor']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Navigation bar Alpha'); ?></td>
			<td>
				<select name="settings[progressbar_alpha]">
					<option value="0" <?php print (@$ops['progressbar_alpha'] == '0') ? 'selected' : ''; ?>><?php _e('0');?></option>

					<option value="10" <?php print (@$ops['progressbar_alpha'] == '10') ? 'selected' : ''; ?>><?php _e('10');?></option>

					<option value="20" <?php print (@$ops['progressbar_alpha'] == '20') ? 'selected' : ''; ?>><?php _e('20');?></option>

					<option value="30" <?php print (@$ops['progressbar_alpha'] == '30') ? 'selected' : ''; ?>><?php _e('30');?></option>

					<option value="40" <?php print (@$ops['progressbar_alpha'] == '40') ? 'selected' : ''; ?>><?php _e('40');?></option>

					<option value="50" <?php print (@$ops['progressbar_alpha'] == '50') ? 'selected' : ''; ?>><?php _e('50');?></option>

					<option value="60" <?php print (@$ops['progressbar_alpha'] == '60') ? 'selected' : ''; ?>><?php _e('60');?></option>

					<option value="70" <?php print (@$ops['progressbar_alpha'] == '70') ? 'selected' : ''; ?>><?php _e('70');?></option>

					<option value="80" <?php print (@$ops['progressbar_alpha'] == '80') ? 'selected' : ''; ?>><?php _e('80');?></option>

					<option value="90" <?php print (@$ops['progressbar_alpha'] == '90') ? 'selected' : ''; ?>><?php _e('90');?></option>

					<option value="100" <?php print (@$ops['progressbar_alpha'] == '1') ? 'selected' : ''; ?>><?php _e('100');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Image Scaling'); ?></td>
			<td>
				<select name="settings[picture_scalling]">
					<option value="yes" <?php print (@$ops['picture_scalling'] == 'yes') ? 'selected' : ''; ?>><?php _e('Yes');?></option>

					<option value="no" <?php print (@$ops['picture_scalling'] == 'no') ? 'selected' : ''; ?>><?php _e('No');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('Snow Effect Type'); ?></td>
			<td>
				<select name="settings[snoweffect_type]">
					<option value="0" <?php print (@$ops['snoweffect_type'] == '0') ? 'selected' : ''; ?>><?php _e('No Snow Effect');?></option>

					<option value="1" <?php print (@$ops['snoweffect_type'] == '1') ? 'selected' : ''; ?>><?php _e('Type 1');?></option>

					<option value="2" <?php print (@$ops['snoweffect_type'] == '2') ? 'selected' : ''; ?>><?php _e('Type 2');?></option>

					<option value="3" <?php print (@$ops['snoweffect_type'] == '3') ? 'selected' : ''; ?>><?php _e('Type 3');?></option>

				</select>
			</td>
		</tr>


		<tr>
			<td><?php _e('Number of snow particles'); ?></td>
			<td><input type="text" name="settings[noof_particles]" value="<?php print  @$ops['noof_particles']; ?>" /></td>
		</tr>

		
		<tr>
			<td><?php _e('Small particle blur'); ?></td>
			<td><input type="text" name="settings[min_particle_blur]" value="<?php print  @$ops['min_particle_blur']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Big particle blur'); ?></td>
			<td><input type="text" name="settings[max_particle_blur]" value="<?php print  @$ops['max_particle_blur']; ?>" /></td>
		</tr>

		<tr>
			<td><?php _e('Target Link'); ?></td>
			<td>
				<select name="settings[target]">
					<option value="_self" <?php print (@$ops['target'] == '_self') ? 'selected' : ''; ?>><?php _e('Same Window');?></option>

					<option value="_blank" <?php print (@$ops['target'] == '_blank') ? 'selected' : ''; ?>><?php _e('New Window');?></option>

				</select>
			</td>
		</tr>

		<tr>
			<td><?php _e('wmode'); ?></td>
			<td>
				<select name="settings[wmode]">
					<option value="window" <?php print (@$ops['wmode'] == 'window') ? 'selected' : ''; ?>><?php _e('Window');?></option>

					<option value="opaque" <?php print (@$ops['wmode'] == 'opaque') ? 'selected' : ''; ?>><?php _e('Opaque');?></option>

					<option value="transparent" <?php print (@$ops['wmode'] == 'transparent') ? 'selected' : ''; ?>><?php _e('Transparent');?></option>

				</select>
			</td>
		</tr>

		</table>
	<p><button type="submit" class="button-primary"><?php _e('Save Config'); ?></button></p>
	</form>
</div>