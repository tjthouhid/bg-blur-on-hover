<?php
/* 
Plugin Name: BG Blur On Hover
Plugin URI: https://github.com/tjthouhid/bg-blur-on-hover/
Description: This Wordpress Plugin blur background on hover 
Version: 1.0.1
Author: Tj Thouhid 
Author URI: https://tjthouhid.me/
License: GPLv2 or later 
*/

function add_bg_blur_code(){
	$bgb_class = get_option('bgb_class_names');
	if($bgb_class != ""){
	?>
	<div id="bgb-overlay"></div>
	<style type="text/css">
		.body-relative{position: relative;}
		#bgb-overlay{
			background-size: 100% 100%;
			position: absolute;
		    top: 0px;
		    bottom: 0px;
		    left: 0px;
		    right: 0px;
		    -webkit-filter: blur(5px);
		    -moz-filter: blur(5px);
		    -o-filter: blur(5px);
		    -ms-filter: blur(5px);
		    filter: blur(5px);
		    visibility: hidden;
	      	opacity: 0;
	      	transition: visibility 0s, opacity 0.5s linear;
		}
		#bgb-overlay.show{
			visibility: visible;
  			opacity: 1;
		}
		.elemBGB{position: relative;z-index: 999;}
	</style>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ );?>js/html2canvas.min.js"></script>
	<script type="text/javascript">
		html2canvas(document.body).then(function(canvas) {
			document.getElementById("bgb-overlay").style.backgroundImage = "url('"+canvas.toDataURL('image/jpeg')+"')";
		});
		var bgb_class  = "<?php echo $bgb_class;?>";
		console.log(bgb_class)
		var BGBtarget = document.querySelectorAll(bgb_class);
		for (let i = 0; i < BGBtarget.length; i++) {
			BGBtarget[i].classList.add('elemBGB');
			BGBtarget[i].addEventListener("mouseover", mOver, false);
		    BGBtarget[i].addEventListener("mouseout", mOut, false);
		}

		function mOver() {
		   document.querySelector("body").classList.add('body-relative');
		   document.getElementById("bgb-overlay").classList.add('show');
		   
		}

		function mOut() {  
		   document.querySelector("body").classList.remove('body-relative');
		   document.getElementById("bgb-overlay").classList.remove('show');
		}
		
	</script>
	<?php
	}
}
 add_action( 'wp_footer', 'add_bg_blur_code' );


 add_action( 'admin_menu', 'BGB_menu' );

function BGB_menu() {
	$page_title='BG Blur Setting';
	$menu_title='BG Blur Setting';
	$capability=1;
	$menu_slug='bg_blur_menu';
	$function='bg_blur_template';
	$icon_url='';
	$position=68.9;

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	
}
function bg_blur_template(){
	global $wpdb;
	if(isset($_POST['save'])){
		update_option('bgb_class_names',$_POST['bgb_class']);
	}
	$bgb_class = get_option('bgb_class_names');
	?>
	<style type="text/css">
		.bgb-form{}
		.bgb-form label{
			font-size: 18px;
		    font-weight: bold;
		    display: block;
		    margin: 20px 0px;
		}
		.bgb-form textarea{
			display: block;
			width: 300px;
			height: 100px;
			margin: 0px 0px 20px 0px;
		}
		.bgb-form input[type='submit']{
			border: 1px solid;
		    background-color: #2a8603;
		    color: #fff;
		    padding: 10px 30px;
		    cursor: pointer;
		}
		.bgb-form input[type='submit']:hover{
			background-color: #36940f;
		}
		.bgb-form  span{
			display: block;
		    font-size: 12px;
		    color: #8e8c8c;
		    margin: 0px 0px 20px 0px;
		}
	</style>
	<h1>BG Blur Setting</h1>
	<form action="" method="post" class="bgb-form">
		<label>Class Names </label>
		<textarea name="bgb_class"><?php echo $bgb_class;?></textarea>
		<span>Please type the element class name for having the blur effect using comma  separator. Example : .site-title,.entry-title  </span>
		<input type="submit" name="save" value="Save">
	</form>
	
	
	<?php 

}