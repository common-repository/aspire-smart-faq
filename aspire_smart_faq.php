<?php
/*
Plugin Name: Aspire Smart FAQ plugin
Description: With Aspire Smart FAQ you can use custom post types and taxonomies to manage FAQs section for your site along with many more features.
Version: 1.0
Author: Aspire Solution
Author URI: http://www.aspiresolution.com
*/


//including scripts of color picker for admin
wp_enqueue_script( 'wp-color-picker' );
wp_enqueue_style( 'wp-color-picker' );

$expand = get_option('multifaq_expand');
if($expand == 'true')
{
add_action("init","aspire_smart_scripts");
				function aspire_smart_scripts(){
					wp_enqueue_script("jquery");
					wp_enqueue_script("jquery-ui-accordion");
					wp_enqueue_script("faq_accordion_aspire",plugins_url('/inc/js/faq_asp.js', __FILE__));
				}
}

$css = get_option('multifaq_css');
if($css == 'true')
{
	wp_enqueue_style( 'asp_faq_front', plugins_url('/inc/style.css', __FILE__), array(), FAQ_VER, 'all' );
	wp_enqueue_style( '', plugins_url('/inc/jquery-ui.css', __FILE__), array(), FAQ_VER, 'all' );
}
//including style sheet for front-end. its a mandatory file.	

wp_enqueue_style( 'asp_faq_front', plugins_url('/inc/style.css', __FILE__), array(), FAQ_VER, 'all' );

class FAQ_Post_Type
{
	/**
	*  This is our constructor
	* @return FAQ_Post_Type
	*/
	public function __construct()
	{
		//Creating Custom Post Typ and Custom taxonomies
		$this->register_post_type();
		$this->taxonomies();
		
		// Creating Admin menu
		add_action( 'admin_menu',array( $this, 'admin_pages'));
		
		// Adding Scripts for admin menu
		add_action( 'admin_enqueue_scripts',array( $this, 'admin_scripts'	));
		add_action( 'wp_ajax_save_sort',array( $this, 'save_sort'));
	}
	/**
	*  This is our post type register function
	*
	 * @return FAQ_Post_Type
	*/
	public function register_post_type()
	{
		$labels = array(
			'name' => 'FAQs',
			'singular_name' => 'FAQ',
			'add_new' => 'Add New FAQ',
			'add_new_item' => 'Add New FAQ',
			'edit_item' => 'Edit FAQ',
			'new_item' => 'New FAQ',
			'all_items' => 'All FAQs',
			'view_item' => 'View FAQ',
			'search_items' => 'Search FAQs',
			'not_found' =>  'No FAQs found',
			'not_found_in_trash' => 'No FAQ found in Trash', 
			'parent_item_colon' => '',
			
			'menu_name' => 'FAQs'
		  );
	
		  $args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'asp_faq/' ),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => true,
			'menu_icon'	=> plugins_url( '/plugin_images/faq_menu.png', __FILE__ ),
			'menu_position' => null,
			'supports' => array( 'title', 'editor', 'excerpt'),
			//'taxonomies' => array('post_tag'),
			'can_export' => true
		  ); 
	  // registering post type of faq		
	  register_post_type( 'asp_faq', $args );
	}
	
	/**
	*  This is our taxonomy register function
	* 
	 * @return FAQ_Post_Type
	*/
	public function taxonomies()
	{
		$taxanomies = array();
		$taxanomies['asp_cat']=array(
			'hierarchical' => true,
			'query_var' => 'asp_faq_cat',
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite' => array(
				'slug' => 'asp_faq/asp_cat',
			),
			$labels = array(
				'name' => 'FAQs Categories',
				'singular_name' => 'FAQ Category',
				'edit_item' => 'Edit FAQ Category',
				'update_item' => 'Update FAQ Category',
				'add_new_item' => 'New FAQ Category',
				'all_items' => 'All FAQs',
				'new_item_name' => 'Add New FAQ Category',
				'search_items' => 'Search FAQ Category',
				'popular_items' => 'Popular FAQ Category',
				'search_item_with_comments' => ' Seprate FAQ Category with comments',
				'add_or_remove_items' => 'Add or remove FAQ Category',
				'choose_from_most_used' => 'Choose from most used FAQ Category'
			  ),
		);
		
		$taxanomies['asp_tag']=array(
			'hierarchical' => false,
			'query_var' => 'asp_faq_tag',
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite' => array(
				'slug' => 'asp_faq/asp_tag',
			),
			$labels = array(
				'name' => 'FAQs TAGs',
				'singular_name' => 'FAQ TAGs',
				'edit_item' => 'Edit FAQ TAGs',
				'update_item' => 'Update FAQ TAGs',
				'add_new_item' => 'New FAQ TAGs',
				'all_items' => 'All TAGs',
				'new_item_name' => 'Add New FAQ TAGs',
				'search_items' => 'Search FAQ TAGs',
				'popular_items' => 'Popular FAQ TAGs',
				'search_item_with_comments' => ' Seprate FAQ TAGs with comments',
				'add_or_remove_items' => 'Add or remove TAGs Category',
				'choose_from_most_used' => 'Choose from most used FAQ TAGs'
			  ),
		);
		
		//parsing array to the function register_all_taxanomies
		$this->register_all_taxanomies($taxanomies);
	}
	
	/**
	*registering all taxonomies
	*
	 * @return FAQ_Post_Type
	*/
	public function register_all_taxanomies($taxanomies)
	{
		foreach($taxanomies as $name => $arr)
		{
			register_taxonomy($name,array('asp_faq'),$arr);

		}
		
	}
	/**
	 * Call admin pages
	 *
	* @return FAQ_Post_Type
	 */

	public function admin_pages() {
		
		add_submenu_page('edit.php?post_type=asp_faq', __('Sort FAQs', ''), __('Sort FAQs', 'wp_multifaq'), apply_filters( 'asp_faq', 'manage_options', 'asp_faqsort' ), 'asp_faq-sort', array( &$this, 'sort_asp_faq' ));
		add_submenu_page('edit.php?post_type=asp_faq', __('Settings', ''), __('Settings', 'wp_multifaq'), apply_filters( 'asp_faq', 'manage_options', 'settings' ), 'asp_faq-options', array( &$this, 'settings_asp_faq' ));
		add_submenu_page('edit.php?post_type=asp_faq', __('Instructions', ''), __('Instructions', 'wp_multifaq'), apply_filters( 'asp_faq', 'manage_options', 'instructions' ), 'asp_faq-instructions', array( &$this, 'instructions_asp_faq' ));
		
	}
	

	
	/**
	 * Admin scripts and styles
	 *
	 * @return FAQ_Post_Type
	 */

	public function admin_scripts($hook) {

		$screen = get_current_screen();

		if ( is_object($screen) && 'asp_faq' == $screen->post_type ) :

			wp_enqueue_style( 'asp_faq-admin', plugins_url('/inc/css/faq-admin.css', __FILE__), array(), FAQ_VER, 'all' );

		endif;


			wp_enqueue_style( 'faq-admin', plugins_url('/inc/css/faq-admin.css', __FILE__), array(), FAQ_VER, 'all' );

			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script( 'faq-admin', plugins_url('/inc/js/faq.admin.init.js', __FILE__) , array('jquery'), FAQ_VER, true );

	
	}
	
	/**
	 * Save main options page structure
	 *
	 * @return FAQ_Post_Type
	 */
	public function save_options($option){
		global $wpdb;
		$table_options = $wpdb->prefix . "options"; 
		
		if($option!='')
		{
			if($option['css'] == '') { $option['css'] = 'false';}
			if($option['expand'] == '') { $option['expand'] = 'false';}
			$myopt = get_option('multifaq_htype');
			if($myopt != '') { 
			update_option('multifaq_htype', $option['htype']);  
			}
			else { 
			add_option( 'multifaq_htype', $option['htype'], '', 'yes' ); 
			}
			
			$myopt2 = get_option('multifaq_expand');
			if($myopt != '') { 
			update_option('multifaq_expand', $option['expand']);  
			}
			else { 
			add_option( 'multifaq_expand', $option['expand'], '', 'yes' ); 
			}
			
			$myopt3 = get_option('multifaq_css');
			if($myopt != '') { 
			update_option('multifaq_css', $option['css']);  
			}
			else { 
			add_option( 'multifaq_css', $option['css'], '', 'yes' ); 
			}
			
			$myopt4 = get_option('multifaq_color');
			
			if($myopt != '') { 
			update_option('multifaq_color', $option['color']);  
			}
			else { 
			add_option( 'multifaq_color', $option['color'], '', 'yes' ); 
			}
			
		
		}
	}
	
	/**
	 * Display main options page structure
	 *
	 * @return FAQ_Post_Type
	 */

	public function settings_asp_faq() {
		if (!current_user_can('manage_options') )
			return;
		if(isset($_POST['save_mutli_faq_setting']))
		{
			$options= array();
			$options= $_POST;
			$option = $options['faq_options'];
			$this->save_options($option);
		}
		?>

        <div class="wrap">
        	<div id="icon-faq-admin" class="icon32"><br /></div>
        	<h2><?php _e('Multiple FAQ Settings', 'wp_multifaq') ?></h2>

			<?php
			if ( isset( $_GET['settings-updated'] ) )
    			echo '<div id="message" class="updated below-h2"><p>'. __('FAQ Manager settings updated successfully.', 'wp_multifaq').'</p></div>';
			?>


			<div id="poststuff" class="metabox-holder has-right-sidebar">

			<?php
			//echo $this->settings_side();
			echo $this->settings_open();
			?>

	            <form method="post" action="?post_type=asp_faq&page=asp_faq-options">
                <h2 class="inst-title"><?php _e('Display Options') ?></h2>
			    <?php
				$heading = get_option('multifaq_htype');
				echo '<select class="faq_htype  $htype; " name="faq_options[htype]" id="faq_htype">';
				for($i=1; $i<=6; $i++)
				{
					$h = 'h'.$i;
					if($h=='')
					{
						$h= 'h1';
					}
				?>
                <option value="<?php echo $h; ?>" <?php if($h == $heading) { echo 'selected'; }?> ><?php echo $h; ?></option>
                <?php
				}
                echo '</select>';
				?>
				<label type="select" for="faq_options[htype]"><?php _e('Choose your heading type for FAQ title'); ?></label>
				
				<p>
                
                </p>
				

				<p>
                <?php $expand = get_option('multifaq_expand'); ?>
				    <input type="checkbox" name="faq_options[expand]" id="faq_expand" value="true" <?php checked( $expand, 'true' ); ?> <?php if($expand == 'true') { echo 'checked'; }?>  />
				    <label for="faq_options[expand]" rel="checkbox"><?php _e('Include jQuery collapse / expand', 'wp_multifaq'); ?></label>
				</p>

				<p>
                <?php $css = get_option('multifaq_css'); ?>
				    <input type="checkbox" name="faq_options[css]" id="faq_css" value="true" <?php checked( $css, 'true' ); ?> <?php if($css == 'true') { echo 'checked'; }?> />
				    <label for="faq_options[css]" rel="checkbox"><?php _e('Load default CSS', 'wp_multifaq'); ?></label>
				</p>
                <script type="text/javascript">
					jQuery(document).ready(function($){
						$('.my-color-field').wpColorPicker();
					});
				</script>
                <p>
                <?php $color = get_option('multifaq_color'); ?>
                    <input type="text" id="color" name="faq_options[color]" class="my-color-field" value="<?php echo $color; ?>">
                    <div id="colorpicker"></div>
                    <label for="faq_options[color]" rel="checkbox"><?php _e('Select display color for FAQ', 'wp_multifaq'); ?></label>
                </p>	
    			<!-- submit -->
	    		<p id="faq-submit" class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="save_mutli_faq_setting" /></p>

				<p id="faq-desc" class="description"><?php _e('<strong>Note:</strong> You may need to flush your permalinks after changing settings.', 'wp_multifaq'); ?> <a href="<?php echo admin_url( 'options-permalink.php'); ?>"><?php _e('Go to your Permalink Settings here', 'wp_multifaq'); ?></a></p>

				</form>

	<?php echo $this->settings_close(); ?>

	</div>
	</div>


	<?php }
	
	/**
	 * Instructions Page
	 *
	 * @return FAQ_Post_Type
	 */

	public function instructions_asp_faq() {
		?>
        <div class="wrap">
        	<div id="icon-faq-admin" class="icon32"><br /></div>
        	<h2><?php _e('FAQ Instructions', 'wp_multifaq'); ?></h2>
			<div id="poststuff" class="metabox-holder has-right-sidebar">
			<?php
			//echo $this->settings_side();
			echo $this->settings_open();
			?>
			<p><?php _e('The Aspire Smart FAQ plugin uses a combination of custom post types, and taxonomies. The plugin will automatically create single post using your existing permalink structure. FAQ categories and tags can be added to the menu by using the WP Menu Manager.', 'wp_asp_faq'); ?></p>

			<h2 class="inst-title"><?php _e('Shortcodes', 'wp_asp_faq'); ?></h2>
			<p><?php _e('The plugin provides ability to add short codes. Please follow the below mentioned syntax accordingly in the HTML tab:', 'asp_faq'); ?></p>
			<ul class="faqinfo">
			<li><strong>For the complete list (including title and content) see below:</strong></li><br />
			<li>Shortcode <code>[multi_faq]</code> will list all FAQs in all categories and all tags.</li><br />
            <li>Shortcode <code>[multi_faq cat_name="general"]</code> will list all the FAQs related to a particular category. User must input category's slug and not the category name.</li><br />
            <li>Shortcode <code>[multi_faq tag_name="support"]</code> will list all the FAQs related to a particular tag slug.</li><br />
            <li>Shortcode <code>[multi_faq limit="5"]</code> will list FAQs for a defined limit. In this case only 5 FAQs will be listed.</li><br />
            <li>Shortcode <code>[multi_faq limit="5" cat_name="general"]</code> will list the FAQs for a defined limit but within a specific category slug.</li><br />
            <li>Shortcode <code>[multi_faq limit="5" tag_name="support"]</code>will list the FAQs for a defined limit but within a specific tag slug.</li><br />
            <li>Shortcode <code>[multi_faq cat_name="general, payment, order"]</code> will list all the FAQs related to multiple categories (comma separated).  User must input category's slug and not the category name in each case.</li><br />
            <li>Shortcode <code>[multi_faq tag_name="support, delivery"]</code> will list all the FAQs related to multiple tags (comma separated).  User must input tag's slug and not the tag name in each case.</li><br />
            <br>
            <li>Shortcode <code>[single_faq id="34"] </code> will list the FAQ of id of 34. </li><br />
            <li>Shortcode <code>[list_faq]</code> will list all the FAQs without answers. Clicking on a particular question will open up a new page with same question and related answer.</li><br />
            <li>Shortcode <code>[list_faq]</code> can also be used with <code>limit=""</code> <code>cat_name=""</code> <code>tag_name=""</code> like <code>[list_faq limit="5" cat_name="general"]</code></li><br />
            <li><strong>Note:</strong> <code>tag_name</code> and <code>cat_name</code>, If both are used in any short code, preference will given to <code>tag_name</code> and related results will be shown.</li><br />
			</ul>
            
            <h2 class="inst-title"><?php _e('Widgets instructions', 'wp_asp_faq'); ?></h2>
            <p><?php _e('With Aspire Smart FAQ plugin we have 3 widgets that will perform multiple functions, below is the list of these widgets and their explanation.', 'wp_asp_faq'); ?></p>
			<ol class="faqinfo">
            	<li>Aspire Smart FAQ plugin  : Categories</li>
                <li>Aspire Smart FAQ plugin  : Tags</li>
                <li>Aspire Smart FAQ plugin  : Single</li>

            </ol>
            <ul class="faqinfo">
            	<li><strong>Aspire Smart FAQ plugin : Categories</strong></li>
                <li>This widget has two input parameters
                	<ol class="faqinfo">
                    	<li>Categories slug</li>
                        <li>FAQs Limit</li>
                    </ol>
                </li>
                <li>Categories slug can be singular or multiple (e.g.  general, payment)</li>
                <li>Limit should be a positive number (e.g. 5)</li>
                <li>Example (Category: general and Limit: 5) so it will be showing Recent 5 records from General Category</li><br>
                <li><strong>Aspire Smart FAQ plugin : Tags</strong></li>
                <li>This widget has two input parameters
                	<ol class="faqinfo">
                    	<li>Tags slug</li>
                        <li>FAQs Limit</li>
                    </ol>
                </li>
                <li>Tags slug can be singular or multiple (e.g.  support, order)</li>
                <li>Limit should be a positive number (e.g. 5)</li>
                <li>Example (Tag: support and Limit: 5) so it will be showing Recent 5 records from Support tag</li><br>
                <li><strong>Aspire Smart FAQ plugin : Single</strong></li>
                <li>
                	<ol class="faqinfo">
                    	<li>FAQ ID</li>
                    </ol>
                </li>
                <li>FAQ ID should be ID for your any existing FAQ (e.g.   68)</li>
                <li>Example (FAQ ID: 68) so it will be showing FAQ whose ID is 68</li>
            </ul>
	<?php echo $this->settings_close(); ?>

	</div>
	</div>

	<?php 
}
	
	 /**
     * Some extra stuff for the settings page
     *
     * this is just to keep the area cleaner
     *
     * @return FAQ_Post_Type
     */

    public function settings_side() { ?>

		<div id="side-info-column" class="inner-sidebar">
			<div class="meta-box-sortables">
				<div id="faq-admin-about" class="postbox">
					<h3 class="hndle" id="about-sidebar"><?php _e('About the Plugin', 'wp_multifaq'); ?></h3>
					<div class="inside">
						<p><?php _e('Talk to') ?> <a href="http://twitter.com/norcross" target="_blank">@norcross</a> <?php _e('on twitter or visit the', 'wp_multifaq'); ?> <a href="http://wordpress.org/support/plugin/wordpress-faq-manager/" target="_blank"><?php _e('plugin support form') ?></a> <?php _e('for bugs or feature requests.', 'wp_multifaq'); ?></p>
						<p><?php _e('<strong>Enjoy the plugin?</strong>', 'wp_multifaq'); ?><br />
						<a href="http://twitter.com/?status=I'm using @norcross's WordPress FAQ Manager plugin - check it out! http://l.norc.co/wp_multifaq/" target="_blank"><?php _e('Tweet about it', 'wp_multifaq'); ?></a> <?php _e('and consider donating.', 'wp_multifaq'); ?></p>
						<p><?php _e('<strong>Donate:</strong> A lot of hard work goes into building plugins - support your open source developers. Include your twitter username and I\'ll send you a shout out for your generosity. Thank you!', 'wp_multifaq'); ?><br />
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="11085100">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form></p>
					</div>
				</div>
			</div>

			<div class="meta-box-sortables">
				<div id="faq-admin-more" class="postbox">
					<h3 class="hndle" id="about-sidebar"><?php _e('Links', 'wp_multifaq'); ?></h3>
					<div class="inside">
						<ul>
						<li><a href="http://wordpress.org/extend/plugins/wordpress-faq-manager/" target="_blank"><?php _e('Plugin on WP.org', 'wp_multifaq'); ?></a></li>
						<li><a href="https://github.com/norcross/WordPress-FAQ-Manager" target="_blank"><?php _e('Plugin on GitHub', 'wp_multifaq'); ?></a></li>
						<li><a href="http://wordpress.org/support/plugin/wordpress-faq-manager" target="_blank"><?php _e('Support Forum', 'wp_multifaq'); ?></a><li>
            			<li><a href="<?php echo menu_page_url( 'faq-instructions', 0 ); ?>"><?php _e('Instructions page', 'wp_multifaq'); ?></a></li>
            			</ul>
					</div>
				</div>
			</div>
		</div> <!-- // #side-info-column .inner-sidebar -->

    <?php }

	public function settings_open() { ?>

		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<div id="normal-sortables" class="meta-box-sortables">
					<div id="about" class="postbox">
						<div class="inside">

    <?php }

	public function settings_close() { ?>

						<br class="clear" />
						</div>
					</div>
				</div>
			</div>
		</div>

    <?php }
	
	
	/**
	 * Sort Page
	 *
	 * @return FAQ_Post_Type
	 */


	public function sort_asp_faq() {
		$questions = new WP_Query('post_type=asp_faq&posts_per_page=-1&orderby=menu_order&order=ASC');
	?>
		<div id="faq-admin-sort" class="wrap">
		<div id="icon-faq-admin" class="icon32"><br /></div>
		<h2><?php _e('Sort FAQs', 'wp_multifaq'); ?> <img src=" <?php echo admin_url(); ?>/images/loading.gif" id="loading-animation" /></h2>
			<?php if ( $questions->have_posts() ) : ?>
	    	<p><?php _e('<strong>Note:</strong> This only affects the FAQs listed using the shortcode functions', 'wp_multifaq'); ?></p>
			<ul id="custom-type-list">
				<?php while ( $questions->have_posts() ) : $questions->the_post(); ?>
					<li id="<?php the_id(); ?>"><?php the_title(); ?></li>
				<?php endwhile; ?>
	    	</ul>
			<?php else: ?>
			<p><?php _e('You have no FAQs to sort.', 'wp_multifaq'); ?></p>
			<?php endif; ?>
		</div>

	<?php }

	/**
	 * Save sort order
	 *
	 * @return FAQ_Post_Type
	 */

	public function save_sort() {
		global $wpdb; // WordPress database class

		$order = explode(',', $_POST['order']);
		$counter = 0;

		foreach ($order as $item_id) {
			$wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $item_id) );
			$counter++;
		}
		die(1);
	}
	/**
	 * load scripts and styles for front end
	 *
	 * @return WP_FAQ_Manager
	 */

	public function front_style() {

		wp_enqueue_style( 'faq-style', plugins_url('/inc/css/faq-style.css', __FILE__), array(), FAQ_VER, 'all' );

	}

	public function front_script() {

		wp_enqueue_script( 'faq-init', plugins_url('/inc/js/faq.init.js', __FILE__) , array('jquery'), FAQ_VER, true );

	}

	public function scroll_script() {

		wp_enqueue_script( 'faq-scroll', plugins_url('/inc/js/faq.scroll.js', __FILE__) , array('jquery'), FAQ_VER, true );

	}

			
} 


/**
* Icluding Widget Files Aspire Smart Plugin
*/
include 'class.widget_cat.php';
include 'class.widget_tag.php';
include 'class.widget_single.php';

// register Widgets of Aspire Smart Plugin

function register_faq_widget_cat() {
	
    register_widget( 'multi_faq_widgets_cat' );
}

function register_faq_widget_tag() {
	
    register_widget( 'multi_faq_widgets_tag' );
}

function register_faq_widget_single() {
	
    register_widget( 'multi_faq_widgets_single' );
}

add_action( 'widgets_init', 'register_faq_widget_cat' );
add_action( 'widgets_init', 'register_faq_widget_tag' );
add_action( 'widgets_init', 'register_faq_widget_single' ); 

//initializing add_action and coresponding function
function codex_custom_init() {
  new FAQ_Post_Type();
  // including shortcode's file 
  include dirname(__FILE__).'/mutiple_faq_shortcode.php';
}
add_action( 'init', 'codex_custom_init' );
?>