<?php
/*
Plugin Name: Slideshow Press 
Plugin URI: 
Description: Turn your category, tag and archives into a <a href="http://meyerweb.com/eric/tools/s5/">s5</a> slideshow.  <a href="options-general.php?page=SlideShowPress.php">Options configuration panel</a>
Version: 1
Author: OLT UBC 
Author URI: http://blogs.ubc.ca/oltdev
*/
 
/*
== Installation ==
 
1. Upload SlideShowPress.zip to the /wp-content/plugins/SlideShowPress/SlideShowPress.php directory
2. Unzip into its own folder /wp-content/plugins/
3. Activate the plugin through the 'Plugins' menu in WordPress by clicking "SlideShowPress"
4. Go to your Options Panel and open the "SlideShowPress" submenu. /wp-admin/options-general.php?page=SlideShowPress.php
*/
 
/*
/--------------------------------------------------------------------\
|                                                                    |
| License: GPL                                                       |
|                                                                    |
| SlideShowPress - Turn your category, tag and archives into a s5    |
| slide                                                              |
| 																	 |
|Copyright (C) 2009, OLT, www.olt.ubc.ca                     	     |
| All rights reserved.                                               |
|                                                                    |
| This program is free software; you can redistribute it and/or      |
| modify it under the terms of the GNU General Public License        |
| as published by the Free Software Foundation; either version 2     |
| of the License, or (at your option) any later version.             |
|                                                                    |
| This program is distributed in the hope that it will be useful,    |
| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
| GNU General Public License for more details.                       |
|                                                                    |
| You should have received a copy of the GNU General Public License  |
| along with this program; if not, write to the                      |
| Free Software Foundation, Inc.                                     |
| 51 Franklin Street, Fifth Floor                                    |
| Boston, MA  02110-1301, USA                                        |   
|                                                                    |
\--------------------------------------------------------------------/
*/



/**
 * Creation of the SlideShowPressClass
 * This class should host all the functionality that the plugin requires.
 */
if (!class_exists("SlideShowPressClass")) {

	class SlideShowPressClass {
		/**
		 * Global Class Variables
		 */

		var $optionsName = "SlideShowPressOptions";
		
		var $version = "0.5";
		var $options;
		/**
		 * Constructor 
		 */

		function SlideShowPressClass() { 

			

		}
		/**
		 * Function to call once the plugin is activated
		 */

		function init() {

			$this->options = $this->getOptions();

			

		}
		/**
		 * Function to call once the plugin is deactivated
		 */		
		function nomore()
		{
			delete_option($this->optionsName);
		}

		/**
		 * Example of how to define options used in the plugin 
		 * Default Options are defined here as well
		 * Returns Options 
		 */

		function getOptions() {
		    // Default options 

			$SlideShowPressDefaultOptions = 
			array( 
				
				'style'			=> "blank_state",
				'background_url'=> false,
				'bg_color'		=> "#FFFFFF",
				'text_color'	=> "#333333",
				'hd_bg_color'	=> "#FFFFFF",
				'hd_text_color'=> "#333333",
				'font_family'	=> false,
				'font_size'		=> false,
				'footer_text'	=> false,
				'order'			=> false,
				'css'			=> false
			);
				   

			$SlideShowPressOptions = get_option($this->optionsName);

			if (!empty($SlideShowPressOptions)) {

				foreach ($SlideShowPressOptions as $key => $option)

					$SlideShowPressDefaultOptions[$key] = $option;

			}				

			update_option($this->optionsName, $SlideShowPressDefaultOptions);

			return $SlideShowPressDefaultOptions;

		}
		/* 
		 * Reverses the posts 
		 **********************************/
		function reverse_order($the_posts)
		{
			
			return array_reverse($the_posts);		
		}
		
		function makeSlides()
		{
		
		if(isset($_GET['slideshow']) && (is_category() || is_archive())) :
		 $background = "#275bb3" ;
		 $options = $this->getOptions();
		
		 
		
		
		 
		 
		?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php bloginfo('name'); ?></title>
<!-- metadata -->
<meta name="generator" content="S5" />
<meta name="version" content="S5 1.1" />
<meta name="presdate" content="20050128" />
<meta name="author" content="Eric A. Meyer" />
<meta name="company" content="Complex Spiral Consulting" />
<!-- configuration parameters -->
<meta name="defaultView" content="slideshow" />
<meta name="controlVis" content="hidden" />
<!-- style sheet links -->

<link rel="stylesheet" href="/wp-content/plugins/SlideShowPress/ui/default/slides.css" type="text/css" media="projection" id="slideProj" />
<link rel="stylesheet" href="/wp-content/plugins/SlideShowPress/ui/default/outline.css" type="text/css" media="screen" id="outlineStyle" />
<link rel="stylesheet" href="/wp-content/plugins/SlideShowPress/ui/default/print.css" type="text/css" media="print" id="slidePrint" />
<link rel="stylesheet" href="/wp-content/plugins/SlideShowPress/ui/default/opera.css" type="text/css" media="projection" id="operaFix" />
<style>
	<?php
		
	 switch($options['style']) {
	
		case "blank_state": ?>
		
	
			body .presentation{
				color: <?php echo $options['text_color'];?> !important;
			}
			
			body {
				background: <?php echo $options['bg_color'];?>;
			}
			body div#header, 
			body .slide h1.slide-title{
				color: <?php echo $options['hd_text_color'];?> !important;
				background: <?php echo $options['hd_bg_color'];?> !important;
				font-size:1.3em !important;
			}
			, 
			body #controls #navLinks a {
				color: <?php echo $options['text_color'];?> !important;
			}
		
		
		
		
		<?php 
		break; 
		case "gray_gradiant": ?>
		body{
			background:url(/wp-content/plugins/SlideShowPress/ui/default/gray_gradient.jpg) repeat-x top left;
		}
		div#header, div#footer, .slide h1.slide-title, #controls #navLinks a {
			font-size:1.3em !important;
			background: none;
		}
		
		<?php 
		break; 
		/*case "background_image":
		
		break;
		*/
		}?>
	
		body{
			font-family: <?php echo $options['font_family'];?>;
			font-size: <?php echo $options['font_size'];?>px;
		}
		body .presentation{
			font-size: <?php echo $options['font_size'];?>px !important;
		}
		body .presentation .slide h1.slide-title{
			font-size:1.3em !important;
			font-family: <?php echo $options['font_family'];?>;
		}
		div#header{
			<?php 
			
			$height = ($options['font_size']/10 - $options['font_size']/36);
			?>
			
			height: <?php echo $height; ?>em;
		}
		body .presentation .slide h1.slide-title{
			position:absolute;
			left:auto;
			top:15px;
			
		}
		body .presentation .slide h1{
			position:relative;
			left:auto;
			top:auto;
		}
	
	<?php echo $options['css']; ?>
	

</style>
<!-- S5 JS -->
<script src="/wp-content/plugins/SlideShowPress/ui/default/slides.js" type="text/javascript"></script>
</head>
<body>

<div class="layout">
<div id="controls"><!-- DO NOT EDIT --></div>
<div id="currentSlide"><!-- DO NOT EDIT --></div>
<div id="header"></div>


</div>

	<div class="presentation">
		<?php
			 while (have_posts()) : the_post(); 
		?>
            <div class="slide">
            <h1 class="slide-title"><?php the_title();?></h1>
            <div class="content"><?php the_content('<span class="more-link">'.__('Continued reading &gt;', 'simplr').'</span>'); ?></div>
            </div>
		<?php endwhile; ?>
			
                
            		    
	</div>
</body>
</html>
                <?php		
				die();
				// end everything now 
			endif; // procede as usual 
		
		}
		

		function showSlideLink()
		{ 
			
			if(is_category() || is_archive()) {
			?>
				<div id="wpSlideshow"><a href="?slideshow">Go to Slideshow</a></div>
			<?php
			}
		}

		
	   
		/**
		 * Prints out the admin page
		 */

		function printAdminPage() {
		
			$options = $this->getOptions();
		
			if($_POST) : 
				check_admin_referer('plugin-action-slideshow'); # check for the header we don't go any further if this is not satisfied 
				
				// set new options 
				// this filtering might not be that neccessery
				// 
				$options = array( 
					'style'			=> strip_tags($_POST['style']),
					'background_url'=> strip_tags($_POST['background_url']),
					'bg_color'		=> substr(trim( $_POST['bg_color']),0,7),
					'text_color'	=> substr(trim( $_POST['text_color']),0,7),
					'hd_bg_color'	=> substr(trim( $_POST['hd_bg_color']),0,7),
					'hd_text_color' => substr(trim( $_POST['hd_text_color']),0,7),
					'font_family'	=> strip_tags  ($_POST['font_family'] ),
					'font_size'		=> strip_tags  ($_POST['font_size'] ),
					'footer_text'	=> $_POST['footer_text'],
					'order'			=> strip_tags($_POST['order']),
					'css'			=> strip_tags  ($_POST['css'])
				);
			
			
				update_option($this->optionsName, $options);
				
				
			endif; // end of the post 
			
			
			?> 
            <link rel="stylesheet" media="screen" type="text/css" href="/wp-content/plugins/SlideShowPress/colorpicker/css/colorpicker.css" />
			<script type="text/javascript" src="/wp-content/plugins/SlideShowPress/colorpicker/js/colorpicker.js"></script>
            <script>
				jQuery(document).ready(function(){
				
				jQuery("#blank_state").change(function(){
					if(this.checked)
					{
						jQuery("#blank_shell").show();
						jQuery("#background_image_shell").hide();
					}
					
				
				});
				jQuery("#background_image").change(function(){
					if(this.checked)
					{
						jQuery("#background_image_shell").show();
						jQuery("#blank_shell").hide();
					}
					
				
				});
				jQuery("#gray_gradient").change(function(){
					if(this.checked)
					{
						jQuery("#blank_shell").hide();
						jQuery("#background_image_shell").hide();
					}
					
				
				});
				jQuery("#advanced").hide();
				jQuery("#toggle-advanced").click(function(){
					jQuery("#advanced").slideToggle();
					return false;
				
				});
				
				// id="background_image"
				// id="gray_gradient"
				// id="blank_state"
				
				/* background color */
				jQuery('#bg_color').ColorPicker({
					onChange: function(hsb, hex, rgb) {
						
						jQuery('#bg_color').val("#"+hex);
						jQuery('#bg_color_show').css("backgroundColor","#"+hex);
						jQuery('#example_slide').css("backgroundColor","#"+hex);
					},
					onBeforeShow: function () {
						jQuery(this).ColorPickerSetColor(this.value);
					},
					onSubmit: function(hsb, hex, rgb) {
						jQuery('#bg_color').val("#"+hex);
						jQuery('#bg_color_show').css("backgroundColor","#"+hex);
						jQuery('#example_slide').css("backgroundColor","#"+hex);
			
					}
				})
				.bind('keyup', function(){
					jQuery(this).ColorPickerSetColor(this.value);
					jQuery('#bg_color_show').css("backgroundColor",this.value);
					jQuery('#example_slide').css("backgroundColor",this.value);
					
				});
				
				/* text color */
				jQuery('#text_color').ColorPicker({
					
					onChange: function(hsb, hex, rgb) {
						jQuery('#text_color').val("#"+hex);
						jQuery('#text_color_show').css("backgroundColor","#"+hex);
						jQuery('#example_slide').css("color","#"+hex);
					},
					onBeforeShow: function () {
	
						jQuery(this).ColorPickerSetColor(this.value);
					},
					onSubmit: function(hsb, hex, rgb) {
						jQuery('#text_color').val("#"+hex);
						jQuery('#text_color_show').css("backgroundColor","#"+hex);
						jQuery('#example_slide').css("color","#"+hex);
						return false;
			
					}
				})
				.bind('keyup', function(){
					jQuery(this).ColorPickerSetColor(this.value);
					jQuery('#text_color_show').css("backgroundColor",this.value);
					jQuery('#example_slide').css("color",this.value);
				});
				
				
				
				/* Header and footer */
				/* background color */
				jQuery('#hd_bg_color').ColorPicker({
					
					onChange: function(hsb, hex, rgb) {
						jQuery('#hd_bg_color').val("#"+hex);
						jQuery('#hd_bg_color_show').css("backgroundColor","#"+hex);
						jQuery('#slide_header').css("backgroundColor","#"+hex);
						
						
						
					},
					onBeforeShow: function () {
						jQuery(this).ColorPickerSetColor(this.value);
					},
					onSubmit: function(hsb, hex, rgb) {
						jQuery('#hd_bg_color').val("#"+hex);
						jQuery('#hd_bg_color_show').css("backgroundColor","#"+hex);
						jQuery('#slide_header').css("backgroundColor","#"+hex);
						
			
					}
					
				})
				.bind('keyup', function(){
					jQuery(this).ColorPickerSetColor(this.value);
					jQuery('#hd_bg_color_show').css("backgroundColor",this.value);
					jQuery('#slide_header').css("backgroundColor",this.value);
					
				});
				
				/* text color */
				jQuery('#hd_text_color').ColorPicker({
					
					onChange: function(hsb, hex, rgb) {
						jQuery('#hd_text_color').val("#"+hex);
						jQuery('#hd_text_color_show').css("backgroundColor","#"+hex);
						jQuery('#slide_header').css("color","#"+hex);
					},
					onBeforeShow: function () {
						jQuery(this).ColorPickerSetColor(this.value);
					},
					onSubmit: function(hsb, hex, rgb) {
						jQuery('#hd_text_color').val("#"+hex);
						jQuery('#hd_text_color_show').css("backgroundColor","#"+hex);
						jQuery('#slide_header').css("color","#"+hex);
					}
				})
				.bind('keyup', function(){
					jQuery(this).ColorPickerSetColor(this.value);
					jQuery('#hd_text_color_show').css("backgroundColor",this.value);
					jQuery('#slide_header').css("color",this.value);
				});
				
			
			});		
            
            </script>
			<style>
			/*
            .one-third {
				width:32%;
				float:left;
			}
			.one-third input{ width:60px; border:1px solid #CCC;}
			.one-third h4{
				margin:15px 0 5px;
			}
			.right{ border-left:1px solid #CCC; padding-left:10px;}
			input.radio{ width:auto;}
			input.long{ width:200px;}
			*/
			.square{width:20px; height:10px; margin:0 3px; padding:5px 10px 1px; display:inline; border:1px solid #000;}
			
			
			#example_slide{
				border:1px solid #333;
				width:380px;
				padding:10px;
			}
			#slide_header,#slide_footer{
				margin:-10px -10px 5px;
				padding:5px 10px ;
			}
			
			
            </style>
            <div class="wrap">
			<h2><?php _e("SlideshowPress Settings"); ?></h2>
			
            <h3>Presentation</h3>
            <form action="" method="post">
            <?php
			if ( function_exists('wp_nonce_field') )
				wp_nonce_field('plugin-action-slideshow'); #check the header 
			?>
            <table class="form-table">
            
            	<tr>
                    <th scope="row">Presentation</th>
                    <td>
                        <fieldset><legend class="hidden">Presentation</legend>
                            <label><input type="radio" name="style" value="blank_state"  class="radio" id="blank_state" <?php if($options["style"] == "blank_state") {?> checked="checked"<?php } ?> /> Blank </label><br />
                            <label><input type="radio" name="style" value="gray_gradiant" class="radio" id="gray_gradient" <?php if($options["style"] == "gray_gradiant") {?> checked="checked"<?php } ?> /> Gray Gradient</label> <br />
                           <!--
                            <label><input type="radio" name="style" value="background_image"  class="radio" id="background_image" <?php if($options["style"] == "background_image") {?> checked="checked"<?php } ?> /> Background Image</label> <br />
                            
                            -->
                        </fieldset>
                    </td>
                </tr>
                <!-- 
                <tr id="background_image_shell" style=" <?php if($options["style"] != "background_image") {?> display:none;<?php } ?> background:#DDD;" >
                    <th scope="row">URL to the Image</th>
                    <td>
                        <fieldset><legend class="hidden">URL to the Image</legend>
                            http://<input type="text" name="background_url" size="40" value="<?php echo $options["background_url"]; ?>"  /><br />
                        </fieldset>
                    </td>
                </tr>
                -->
                <tr id="blank_shell" style=" <?php if($options["style"] != "blank_state") {?> display:none;<?php } ?> background:#DDD;"  >
                    <th scope="row">Blank Template Options</th>
                    <td>
                        <fieldset><legend class="hidden">Blank Template Options</legend>
                            <strong>body</strong><br />
                            <div id="bg_color_show" class="square" style="background: <?php echo $options["bg_color"]; ?>;">&nbsp;</div>
                            <input type="input" name="bg_color" id="bg_color"  size="7"  value="<?php echo $options["bg_color"]; ?>" />  Background Color <br />
                            
                            <div id="text_color_show" class="square" style="background:<?php echo $options["text_color"]; ?>;">&nbsp;</div>
                            <input type="input" name="text_color" id="text_color"  size="7" value="<?php echo $options["text_color"]; ?>" /> Text Color <br />
                            <br />
                            <strong>header / footer</strong><br />
                            <div id="hd_bg_color_show" class="square" style="background:<?php echo $options["hd_bg_color"]; ?>;">&nbsp;</div>
                            <input type="input" name="hd_bg_color" id="hd_bg_color" size="7" value="<?php echo $options["hd_bg_color"]; ?>"  /> Background Color <br />
                            
                            <div id="hd_text_color_show" class="square" style="background:<?php echo $options["hd_text_color"]; ?>;">&nbsp;</div>
                            <input type="input" name="hd_text_color" id="hd_text_color" size="7" value="<?php echo $options["hd_text_color"]; ?>" /> Text Color <br />
                        </fieldset>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row" >Font</th>
                    <td>
                        <fieldset>
                            <legend class="hidden">Font</legend>
                            <select name="font_family" >
                                <optgroup label="------ sans-serif ------">
                                    <option <?php if($options["font_family"] == "Arial") {?> selected="selected" <?php } ?> 
                                    style="font-family: Arial;" value="Arial">Arial </option>
                                    <option <?php if($options["font_family"] == "Tahoma") {?> selected="selected" <?php } ?> 
                                    style="font-family: Tahoma;" value="Tahoma">Tahoma</option>
                                    <option <?php if($options["font_family"] == "Verdana") {?> selected="selected" <?php } ?> 
                                    style="font-family: Verdana;" value="Verdana">Verdana</option>
                                    <option <?php if($options["font_family"] == "Gill Sans") {?> selected="selected" <?php } ?> 
                                    style="font-family: Gill Sans;" value="Gill Sans">Gill Sans</option>
                                    <option <?php if($options["font_family"] == "Arial Black") {?> selected="selected" <?php } ?> 
                                    style="font-family: Arial Black;" value="Arial Black">Arial Black</option>
                                    <option <?php if($options["font_family"] == "Lucida Console") {?> selected="selected" <?php } ?> 
                                    style="font-family: Lucida Console;" value="Lucida Console">Lucida Console</option>
                                    <option <?php if($options["font_family"] == "Impact") {?> selected="selected" <?php } ?> 
                                    style="font-family: Impact;" value="Impact">Impact</option>
                                 </optgroup>
                                 <optgroup label="------ serif ----------">
                                    <option <?php if($options["font_family"] == "Georgia") {?> selected="selected" <?php } ?> 
                                    style="font-family: Georgia;" value="Georgia">Georgia</option>
                                    <option <?php if($options["font_family"] == "Times New Roman") {?> selected="selected" <?php } ?> 
                                    style="font-family: Times New Roman;" value="Times New Roman">Times New Roman</option>
                                    <option <?php if($options["font_family"] == "System") {?> selected="selected" <?php } ?> 
                                    style="font-family: System;" value="System">System</option>
                                    <option <?php if($options["font_family"] == "Palatino Linotype") {?> selected="selected" <?php } ?> 
                                    style="font-family: Palatino Linotype;" value="Palatino Linotype">Palatino Linotype</option> 
                                    
                                </optgroup>
                                <optgroup label="------ monospace ------">
                                    <option <?php if($options["font_family"] == "Andale Mono") {?> selected="selected" <?php } ?> 
                                    style="font-family: Andale Mono;" value="Andale Mono">Andale Mono</option>
                                    <option <?php if($options["font_family"] == "Courier") {?> selected="selected" <?php } ?> 
                                    style="font-family: Courier;" value="Courier">Courier</option>
                                    <option <?php if($options["font_family"] == "Fixed") {?> selected="selected" <?php } ?> 
                                    style="font-family: Fixed;" value="Fixed">Fixed</option>
                                </optgroup>
                            </select>
                            <select name="font_size" >
                                <optgroup label="font size">
                                		<?php 
										$font_sizes = array(16,18,20,22,24,26,28,30,32,34,36);
										foreach($font_sizes as $size) : ?>
											<option <?php if($options["font_size"] == $size) {?> selected="selected" <?php } ?> style="font-size: <?php echo $size; ?>px " value="<?php echo $size; ?>"><?php echo $size; ?></option>
                              
										<?php endforeach; ?>
                                   
                                </optgroup>
                            </select>                        
                           
                        </fieldset>
                    </td>
                </tr>
                
                <tr id="preview">
                    <th scope="row" >Post Order</th>
                    <td>
                        <fieldset>
                            <legend class="hidden">Post Order</legend>
                            <label><input type="checkbox" name="order" value="true" <?php if($options["order"] == "true") {?> checked="checked"<?php } ?>  /> Reverse Chronological Order</label>
                           
                        </fieldset>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row" id="preview">Preview</th>
                    <td>
                        <div id="example_slide" style="background-color:<?php echo $options["bg_color"]?>; color:<?php echo $options["text_color"]?>;">
                            <div id="slide_header" style="background-color:<?php echo $options["hd_bg_color"]?>; color:<?php echo $options["hd_text_color"]?>;" >Header Text</div>
                            Slide Text 
                            <br /><br /><br /><br /><br /><br /><br /><br /><br />
                            
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row" id="preview"><a href="#advanced" id="toggle-advanced">Advanced Options </a></th>
                    <td>
                        <div id="advanced">
                        
                        <label>CSS (Place your CSS here)<br />
                        <textarea name="css" rows="10" cols="60"><?php echo $options['css']; ?></textarea></label>
                        <br />
                        <!-- 
                        <label>Footer Text<br />
                        <textarea name="footer_text" rows="10" cols="60"><?php echo $options['footer_text']; ?></textarea></label>
                        
                        -->
                        </div>
                        
                    </td>
                </tr>
              
            	
            </table>
          	<p class="submit">
            	<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
            </p>
            
            
            <h3>Categories Links</h3>
            <form name="embedForm">
            <ul>
            <?php $categories = get_categories(); 
			
			foreach ($categories as $category):
			
				$category_link = get_category_link( $category->cat_ID ); 
				?>
				
				<li><a href="<?php echo $category_link; ?>?slideshow" ><?php echo $category_link; ?>?slideshow</a><br />
               	<label>Embed <input type="text" name="link<?php echo $category->cat_ID;?>" value='<a href="<?php echo $category_link; ?>?slideshow"  ><?php echo $category->name; ?>slideshow</a>' onclick="this.focus();this.select();"/> </label>
                </li>
                
            <?php 
			endforeach;
			
			?>
            </form>
            </ul>
            </div>
			<?php

				

		}// End function printAdminPage()

	

	} // End Class SlideShowPressPluginSeries

} 







/**
 * Initialize the admin panel function 
 */

if (!function_exists("SlideShowPressPluginSeries_ap")) {

	function SlideShowPressPluginSeries_ap() {

		global $SlideShowPressInstance;

		if (!isset($SlideShowPressInstance)) {

			return;

		}

		if (function_exists('add_options_page')) {
		

			add_options_page( 'SlideshowPress', 
							  'SlideshowPress', 
							   9, 
							   basename(__FILE__), 
							   array(&$SlideShowPressInstance, 'printAdminPage'));

		}

	}	

} 


if (class_exists("SlideShowPressClass")) {

	$SlideShowPressInstance = new SlideShowPressClass();

}


/**
  * Set Actions and Filters
  */

if (isset($SlideShowPressInstance)) {
    
    // load the textdomain 
	load_plugin_textdomain( 'SlideShowPress', 'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/locale' );

	
	//Actions

	add_action( 'admin_menu', 'SlideShowPressPluginSeries_ap' );
	add_action( 'template_redirect',array(&$SlideShowPressInstance, 'makeSlides'));
	$SlideShowPressoptions = get_option("SlideShowPressOptions");
	
	if($SlideShowPressoptions['order'])
		add_filter('the_posts',array(&$SlideShowPressInstance, 'reverse_order'));
	
	
	add_action( 'wp_footer',array(&$SlideShowPressInstance, 'showSlideLink'));
	
	//Filters

	
	
	// On Activate Plugin
	register_activation_hook( __FILE__, array(&$SlideShowPressInstance, 'init') );
	
	// On Deactivated Plugin
	register_deactivation_hook( __FILE__, array(&$SlideShowPressInstance, 'nomore') );
	


}
?>