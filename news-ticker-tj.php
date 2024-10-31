<?php 
/**
Plugin Name: News ticker
Plugin URI: http://breakingnews.com
Author: Mohammad Tajul Islam
Author URI: https://www.facebook.com/tajulislamdu
Version: 1.0.2
Description: Premium Type Latest News Stiker For Free
License: GPLv2 or later
Text Domain: comet
*/


defined('ABSPATH') or die("Get Lost from here, you idot");


Class comet_breaking_news{

	public function __construct(){

		

		// settings api
		add_action('admin_init', array($this, 'comet_settings_api'));

		// new menu for api settings
		 add_action('admin_menu', array($this, 'breaking_news_menu'));


		// custom metabox
		add_action('add_meta_boxes', array($this, 'braking_news_comet'));

		add_action('save_post', array($this, 'breaking_news_save'));
		

		// shortcode
		add_shortcode('c_breaking_news', array($this, 'breaking_news_shortcode'));


		// theme css and js files
		add_action('wp_enqueue_scripts', array($this, 'comet_theme_files'));

		// header css
		add_action('wp_head', array($this, 'comet_header_css'));

		// footer js
		add_action('wp_footer', array($this, 'comet_footer_js'));

		// activate post_type: breaking_news
		add_action('init', array($this, 'breaking_news'));

		

	}


/**
*
*
*
* Settings Api Start Here
*
*
*
*
*/

public function comet_settings_api(){

/**
*
* Title section
*
*
*/
	add_settings_section('breaking_news_change_text', 'News Title Section', array($this,'breaking_news_change_text_cb'), 'breaking_news_slug');


// title text change
	add_settings_field('breaking_news_text', 'Breaking News Text', array($this, 'b_news_text_cb'), 'breaking_news_slug', 'breaking_news_change_text');

	register_setting('breaking_news_change_text', 'comet_breaking_news_common');


// title text color
	add_settings_field('breaking_news_text_color', 'Breaking News Text Color', array($this, 'breaking_news_text_color_cb'), 'breaking_news_slug', 'breaking_news_change_text');

	register_setting('breaking_news_change_text', 'comet_breaking_news_common');


// title text bg-color and 
	add_settings_field('breaking_news_text_bg_color', 'Background Color', array($this, 'b_text_bg_color'), 'breaking_news_slug', 'breaking_news_change_text');
	register_setting('breaking_news_change_text', 'comet_breaking_news_common');



}


// section subtitle
public function breaking_news_change_text_cb(){
?>

<p>Welcome to Breaking news section</p>

<?php
}


// change breaking news title
public function b_news_text_cb(){
	$options =(array)get_option('comet_breaking_news_common');
	$title = $options['breaking_news_text'];
?>
	
	<input type="text" name="comet_breaking_news_common[breaking_news_text]"  class="regular-text" value="<?php echo $title; ?>">

<?php 
}


// breaking news text color
public function breaking_news_text_color_cb(){
	$options = (array)get_option('comet_breaking_news_common');
	$text_color = $options['breaking_news_text_color'];
?>

<input type="color" name="comet_breaking_news_common[breaking_news_text_color]"  value="<?php echo $text_color; ?>" id="breaking_news_text_color"><br />


<?php 
}

// breaking news text background
public function b_text_bg_color(){
	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['breaking_news_text_bg_color'];
?>

<input type="color" name="comet_breaking_news_common[breaking_news_text_bg_color]" id=""  value="<?php echo $bg_color; ?>">

<?php 
}





/**
*
*
* menu for news options
*
*
*
*/
public function breaking_news_menu(){

	add_submenu_page('edit.php?post_type=comet_news', 'Breaking News Options', 'News Options', 'manage_options', 'breaking_news_slug', array($this, 'breaking_news_cb') );

}

// callback
public function breaking_news_cb(){
?>
	<h1 style="text-align:center; color:green; margin:25px 0;">Breaking News Options</h1>


	<form action="options.php" method="post">
			
	<?php echo do_settings_sections('breaking_news_slug'); ?>

	<?php echo settings_fields('breaking_news_change_text'); ?>

		<?php echo submit_button(); ?>
	</form>
		<?php echo settings_errors(); ?>
<?php 
}




/**
*
*
*
* Settings api ends
*
*
*
*/

	// metabox callback function
	public function braking_news_comet(){
		add_meta_box('braking_news_comet_info', 'Breaking News', array($this, 'braking_news_comet_cb'), 'comet_news', 'normal');

	}

	// metabox input form
	function braking_news_comet_cb(){
		
	?>
	<p>
		<label for="news_cat"><strong>News Category :</strong></label> <br />
		<input type="text" name="news_cat" id="news_cat" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'b_news_cat', true); ?>">
	</p>


	<p>
		<label for="news_content"><strong>News Summary : </strong></label>
		<input type="text" name="news_content" id="news_content" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'b_news_content', true); ?> ">

	</p>


	<p>
		<label for="news_link"><strong>News Link :</strong></label>
		<input type="url" name="news_link" id="news_link" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'b_news_link', true); ?>">

	</p>
	<?php
	}

	// breaking news save
	public function breaking_news_save(){

		$news_catagory = $_REQUEST['news_cat']; 
		$news_content	= $_REQUEST['news_content'];
		$news_link	= $_REQUEST['news_link'];

		update_post_meta( get_the_ID(), 'b_news_cat', $news_catagory);
		update_post_meta( get_the_ID(), 'b_news_content', $news_content);
		update_post_meta( get_the_ID(), 'b_news_link', $news_link);

	}

	// showing metadata in dashboard 




	// breaking news shortcode
	public function breaking_news_shortcode($atts, $content){

	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['breaking_news_text_bg_color'];


	$bg_color = $options ['breaking_news_text_bg_color'];

		extract( shortcode_atts(array(
			'title_cat_color' => $bg_color,
		), $atts));

	ob_start();	
	?>	


    <div class="breakingNews" id="bn4" style="border-color:<?php echo $bg_color; ?>;" >
    	<div class="bn-title" style="background-color: <?php echo $bg_color ; ?>;">

    		<h2 style="color:<?php 

    $options = (array)get_option('comet_breaking_news_common');
	$text_color = $options['breaking_news_text_color'];

    		if( $text_color ){
    			echo $text_color; 
    		}else{
    			#fff
    		}

    		?>;">

    		<?php 
    		$options =(array)get_option('comet_breaking_news_common');
			$title = $options['breaking_news_text'];

    		if( $title ): ?>
    			<?php echo $title; ?>
    		<?php else: ?>
    			Latest News	
    		<?php endif; ?>
    			
    		</h2>
    		<span style="border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) <?php echo $bg_color; ?>;"></span>
    	</div>


        <ul>
<?php

$q = new WP_Query(array(
	'post_type'	=> 'comet_news',
	'posts_per_page'	=> -1,
));

while( $q->have_posts() ):$q->the_post();

?>
        	<li>
        	<a href="<?php echo get_post_meta(get_the_id(), 'b_news_link', true); ?>"><span style="color:<?php echo $title_cat_color; ?>;"><?php echo get_post_meta(get_the_ID(), 'b_news_cat', true); ?></span> - 
        	<?php echo get_post_meta( get_the_id(), 'b_news_content', true); ?></a>
        	</li>

<?php endwhile; ?>
<?php wp_reset_postdata(); ?>

        </ul>
        <div class="bn-navi">
        	<span></span>
            <span></span>
        </div>
    </div>



	<?php  return ob_get_clean();
	}





	// plugin all css and js files
	public function comet_theme_files(){

		/**
		*
		* css files
		*
		*/		
		wp_register_style('comet-breakingNews', Plugins_url('/css/breakingNews.css', __FILE__), array(), '1.0.1', 'all');

		wp_register_style('comet-PT-Sans', Plugins_url('//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin-ext'), array(), '1.0.2', 'all');

		wp_enqueue_style('comet-breakingNews');
		wp_enqueue_style('comet-PT-Sans');


		/**
		*
		* js files
		*
		*/
		wp_register_script('comet_breakingNews', Plugins_url('/js/breakingNews.js', __FILE__), array('jquery'), '6.0.1', true);

		wp_register_script('comet_custom', Plugins_url('/js/custom.js', __FILE__), array('jquery'), '6.0.2', true);

		wp_enqueue_script('comet_breakingNews');
		wp_enqueue_script('comet_custom');


	}


// header theme css
	public function comet_header_css(){

	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['breaking_news_text_bg_color'];
	?>

	<style>

		.breakingNews > ul > li > a:hover {
		  color: <?php echo $bg_color; ?>;
		}

	</style>


	<?php 
	}

// wp footer js

	public function comet_footer_js(){
		?>
			<script>
				

	jQuery(window).load(function(e) {
        jQuery("#bn4").breakingNews({
			effect		:"slide-h",
			autoplay	:true,
			timer		:5000,
			// color		:"red"
		});
		
	});
			</script>

		<?php 
	}



	// callback function for post_type: breaking_news
	public function breaking_news(){
		register_post_type('comet_news', array(
			'label'		=> 'News',
			'labels'	=> array(
				'name'	=> 'News',
				'add_new'	=> 'Add New News',
				'add_new_item'	=> 'Add New News'
				),
			'public'	=> true,
			'menu_icon'	=> 'dashicons-megaphone',
			'supports'	=> array('title')
		));

	}

}

$news = new comet_breaking_news();