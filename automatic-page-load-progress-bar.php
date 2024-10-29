<?php
/**
 * Automatic Page Load Progress Bar
 *
 * @package   Automatic_Page_Load_Progress_Bar
 * @author    Arnaud TILBIAN <atilbian@protonmail.com>
 * @license   GPL-2.0+
 * @link      https://gitlab.com/atilb/automatic-page-load-progress-bar-wordpress-plugin
 * @copyright 2020 Arnaud TILBIAN
 *
 * @wordpress-plugin
 * Plugin Name:       Automatic Page Load Progress Bar
 * Plugin URI:        https://gitlab.com/atilb/automatic-page-load-progress-bar-wordpress-plugin
 * Description:       Light and efficient extension to add a progress bar in less than a minute.
 * Version:           1.1.2
 * Author:            Arnaud TILBIAN
 * Author URI:        https://www.arnaudtilbian.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
function aplpb_hook_progress_bar_front_content($isShortcode = FALSE) {
    if( (get_post_type( get_the_ID() ) == 'page' && get_option("aplpb_option_checkbox_page") == '1') ||  (get_post_type( get_the_ID() ) == 'post' && get_option("aplpb_option_checkbox_post") == '1') || ( is_custom_post_type() ) && get_option("aplpb_option_checkbox_custom") == '1' )
    {
        $page_id = get_queried_object_id();
        $page_object = get_page( $page_id );
        if ( !has_shortcode($page_object->post_content, "aplpb_shortcode") ) // and the page didn't contain any progress bar shortcode
        {
            aplpb_add_javascript();
            aplpb_add_style(get_option( 'aplpb_option_theme' ), get_option( 'aplpb_option_color' ));
        }
    }
}

// thx to https://wordpress.stackexchange.com/a/95906
function is_custom_post_type( $post = NULL )
{
    $all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

    if ( empty ( $all_custom_post_types ) )
        return FALSE;

    $custom_types      = array_keys( $all_custom_post_types );
    $current_post_type = get_post_type( $post );

    if ( ! $current_post_type )
        return FALSE;

    return in_array( $current_post_type, $custom_types );
}

function aplpb_hook_progress_bar_front_content_shortcode($theme = NULL, $color = NULL) {
        aplpb_add_javascript();
        aplpb_add_style($theme, $color);
}

function aplpb_add_javascript() {
    wp_enqueue_script( 'aplpb', plugins_url( 'public/js/pace.js', __FILE__ ), array(), false, false );
}

function aplpb_add_style($theme, $color) {
    wp_enqueue_style( $theme, plugins_url( 'public/css/' . $theme . '.css' , __FILE__ ), array(), false, false);
    
    $custom_css = " .pace .pace-progress{ background:" . $color . "!important;border:" . $color . "!important; }
     .pace .pace-activity {  border-color: " . $color . " transparent transparent!important; } 
     .pace {   border-color: ". $color ."!important; }";

    wp_add_inline_style( $theme, $custom_css );

    if(get_option('aplpb_option_query_desktop' ) != "1")
        wp_enqueue_style( "desktop", plugins_url( 'public/css/media_queries/aplpb_' . "desktop" . '.css' , __FILE__ ), array(), false, false);

    if(get_option( 'aplpb_option_query_tablet' ) != "1")
        wp_enqueue_style( "tablet", plugins_url( 'public/css/media_queries/aplpb_' . "tablet" . '.css' , __FILE__ ), array(), false, false);
    
    if(get_option( 'aplpb_option_query_mobile' ) != "1")
        wp_enqueue_style( "mobile", plugins_url( 'public/css/media_queries/aplpb_' . "mobile" . '.css' , __FILE__ ), array(), false, false);

    if ( is_admin_bar_showing() )
        wp_add_inline_style( $theme, ".pace .pace-progress, .pace {z-index:100000;}" );
}

function aplpb_register_settings() {
	add_option( 'aplpb_option_theme', 'minimal');
    add_option( 'aplpb_option_color', '#ffffff');
    add_option( 'aplpb_option_checkbox_page', '1');
    add_option( 'aplpb_option_checkbox_custom', '1');
    add_option( 'aplpb_option_checkbox_post', '1');
    add_option( 'aplpb_option_query_desktop', '1');
    add_option( 'aplpb_option_query_tablet', '1');
    add_option( 'aplpb_option_query_mobile', '1');
	register_setting( 'aplpb_options_group', 'aplpb_option_theme' );
	register_setting( 'aplpb_options_group', 'aplpb_option_color' );
	register_setting( 'aplpb_options_group', 'aplpb_option_checkbox_page' );
	register_setting( 'aplpb_options_group', 'aplpb_option_checkbox_custom' );
    register_setting( 'aplpb_options_group', 'aplpb_option_checkbox_post' );
    register_setting( 'aplpb_options_group', 'aplpb_option_query_desktop' );
    register_setting( 'aplpb_options_group', 'aplpb_option_query_tablet' );
    register_setting( 'aplpb_options_group', 'aplpb_option_query_mobile' );
}

function aplpb_register_options_page() {
	add_options_page('Progress bar', 'Automatic Page Load Progress Bar', 'manage_options', 'aplpb', 'aplpb_options_page');
}

function aplpb_options_page()
{
	?>
		<div>
		<?php screen_icon(); ?>
		<h2>Automatic Page Load Progress Bar Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'aplpb_options_group' ); ?>
			<table id="aplpb_options_table">
				<tr valign="top">
                    <th>
                        <label for="aplpb_option_theme">Progress bar theme</label>
                    </th>
                    <td> 
                        <p>
                            <select id="aplpb_option_theme" name="aplpb_option_theme">
                            <?php 
                            $file_paths = glob( plugin_dir_path( __FILE__ ) . "/public/css/*.css");
                            $lastChoiceValue = get_option( 'aplpb_option_theme' );
                            echo "<option value='$lastChoiceValue '>$lastChoiceValue </option>";
                            foreach($file_paths as $file)
                            {
                                $fileName = basename($file, '.css');
                                if($fileName != $lastChoiceValue)
                                {
                                    echo "<option value='$fileName'>$fileName</option>";
                                }
                            }
                            ?>
                            </select>
                        </p>
                    </td>
				</tr>
				<tr valign="top">
                    <th scope="row">                         
                        <label for="aplpb_option_color">Progress bar color</label>
                    </th>
                    <td>           
                        <p>           
                            <input type="color" id="aplpb_option_color" name="aplpb_option_color" value="<?php echo get_option( 'aplpb_option_color' ); ?>"/>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">                         
                            <label>Select page to display progress bar</label>
                    </th>
                    <td>
                        <p>
                            <input type="checkbox" id="aplpb_option_checkbox_page" name="aplpb_option_checkbox_page" value="1" <?php checked( get_option( 'aplpb_option_checkbox_page' ), '1' ); ?>/>
                            <label for="aplpb_option_checkbox_page">Enable on all static page</label>
                        </p>
                        <p>
                            <input type="checkbox" id="aplpb_option_checkbox_post" name="aplpb_option_checkbox_post" value="1" <?php checked( get_option( 'aplpb_option_checkbox_post' ), '1' ); ?>/>
                            <label for="aplpb_option_checkbox_post">Enable on blog post</label>
                        </p>
                        <p>
                            <input type="checkbox" id="aplpb_option_checkbox_custom" name="aplpb_option_checkbox_custom" value="1" <?php checked( get_option( 'aplpb_option_checkbox_custom' ), '1' ); ?>/>
                            <label for="aplpb_option_checkbox_custom">Enable on all custom post</label>
                        </p>
                    </td>
                </tr>
                <tr valign="top">                
                    <th scope="row">                         
                            <label>Select media to display progress bar</label>
                    </th>
                    <td>
                        <p>
                            <input type="checkbox" id="aplpb_option_query_desktop" name="aplpb_option_query_desktop" value="1" <?php checked( get_option( 'aplpb_option_query_desktop' ), '1' ); ?>/>
                            <label for="aplpb_option_query_desktop">Enable on desktop</label>
                        </p>
                        <p>
                            <input type="checkbox" id="aplpb_option_query_tablet" name="aplpb_option_query_tablet" value="1" <?php checked( get_option( 'aplpb_option_query_tablet' ), '1' ); ?>/>
                            <label for="aplpb_option_query_tablet">Enable on tablet</label>
                        </p>
                        <p>
                            <input type="checkbox" id="aplpb_option_query_mobile" name="aplpb_option_query_mobile" value="1" <?php checked( get_option( 'aplpb_option_query_mobile' ), '1' ); ?>/>
                            <label for="aplpb_option_query_mobile">Enable on mobile</label>
                        </p>
                    </td>
                </tr>
			</table>
			<?php  submit_button(); ?>
		</form>
		</div>
	<?php
}

function aplpb_load_custom_wp_admin_style() {
    wp_register_style( 'admin', plugins_url( '/public/css/admin/aplpb_admin.css' , __FILE__ ), false, '1.0.0' );
    wp_enqueue_style( 'admin' );
}


function aplpb_add_setting_link( $links ) {
    $settings_link = '<a href="options-general.php?page=aplpb">' . __( 'Settings' ) . '</a>';	
    array_push( $links, $settings_link );
  	return $links;
}

function aplpb_shortcode($atts) {
    $a = shortcode_atts( array(
        'theme' => NULL,
        'color' => NULL,
    ), $atts);

    aplpb_hook_progress_bar_front_content_shortcode(esc_html( $a['theme'] ), esc_html( $a['color'] ));
}


$plugin = plugin_basename( __FILE__ );

add_action( 'admin_init','aplpb_register_settings');
add_action( 'admin_menu','aplpb_register_options_page');
add_filter( "plugin_action_links_$plugin", 'aplpb_add_setting_link');
add_shortcode( 'aplpb_shortcode', 'aplpb_shortcode');
add_action( 'admin_enqueue_scripts', 'aplpb_load_custom_wp_admin_style' );
add_action( 'wp_head', 'aplpb_hook_progress_bar_front_content');