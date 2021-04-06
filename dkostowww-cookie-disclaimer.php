<?php
/**
 * @package DkostowwwCookieDisclaimerExample
 */
 /** Plugin Name: Cookie Disclaimer Example
 * Description: Wordpress Cookie Disclaimer Plugin
 * Author: Dimitar Kostov
 **/

if (!defined('ABSPATH')) die;

//Activation
require_once plugin_dir_path(__FILE__).'inc/dkostowww-cookie-disclaimer-activate.php';
register_activation_hook(__FILE__, array('DkostowwwCookieDisclaimerActivate', 'activate'));

//Deactivation
require_once plugin_dir_path(__FILE__).'inc/dkostowww-cookie-disclaimer-deactivate.php';
register_deactivation_hook(__FILE__, array('DkostowwwCookieDisclaimerDeactivate', 'deactivate'));

add_action('wp_enqueue_scripts', 'enqueue');
function enqueue() {
    wp_enqueue_style('styles', plugins_url( '/assets/styles.css', __FILE__));

    $script_params = array(
        // script specific parameters
        'cookie_disclaimer_color' => get_option('cookie_disclaimer_color'),
        'cookie_disclaimer_width' => get_option('cookie_disclaimer_width'),
        'cookie_disclaimer_cookie_statement' => get_option('cookie_disclaimer_cookie_statement'),
        'cookie_disclaimer_site_ownership' => get_option('cookie_disclaimer_site_ownership'),
        'cookie_disclaimer_font_style' => get_option('cookie_disclaimer_font_style'),
        'cookie_disclaimer_font_family' => get_option('cookie_disclaimer_font_family'),
        'cookie_disclaimer_font_size' => get_option('cookie_disclaimer_font_size'),
        'cookie_disclaimer_line_height' => get_option('cookie_disclaimer_line_height'),
        'cookie_disclaimer_font_weight' => get_option('cookie_disclaimer_font_weight'),
        'cookie_disclaimer_font_color'=> get_option('cookie_disclaimer_font_color'),
        'cookie_disclaimer_letter_spacing' => get_option('cookie_disclaimer_letter_spacing')
    );
    // Enqueue the script
    wp_register_script('cookie_disclaimer_script', plugin_dir_url( __FILE__ ) . '/assets/scripts.js', array( 'jquery' ));
    wp_enqueue_script('cookie_disclaimer_script');
    wp_localize_script('cookie_disclaimer_script', 'params', $script_params);
}

add_action('admin_menu', 'cookie_disclaimer_menu');
function cookie_disclaimer_menu() {
    $manage_cookie_disclaimer = 'manage_cookie_disclaimer';
    $manage_options = 'manage_options';
    // Add admin access
    $admin = get_role( 'administrator' );
    $admin->add_cap( $manage_cookie_disclaimer );

    $permissions_array = get_option('permissions_array');

    // Add permissions for other roles
    foreach (get_editable_roles() as $role_name => $role_info) {
        if ( $role_name !== 'administrator') {
            if (in_array($role_name, explode(",", $permissions_array))) {
                $add_role = get_role( $role_name );
                $add_role->add_cap( $manage_cookie_disclaimer );
                $add_role->add_cap( $manage_options );
            } else {
                $remove_role = get_role( $role_name );
                // only remove capabilities if they were previously added
                if ($remove_role->has_cap( $manage_cookie_disclaimer )){
                    $remove_role->remove_cap( $manage_cookie_disclaimer );
                    $remove_role->remove_cap( $manage_options );
                }
            }
        }
    }
    add_menu_page('Cookie Disclaimer Settings', 'Cookie Disclaimer', $manage_cookie_disclaimer, 'cookie-disclaimer-settings', 'cookie_disclaimer_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init','cookie_disclaimer_settings');
function cookie_disclaimer_settings() {
    register_setting('cookie_disclaimer-settings-group', 'cookie_disclaimer_color');
    register_setting('cookie_disclaimer-settings-group', 'cookie_disclaimer_width');
    register_setting('cookie_disclaimer-settings-group', 'cookie_disclaimer_cookie_statement');
    register_setting('cookie_disclaimer-settings-group', 'cookie_disclaimer_site_ownership');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_font_style');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_font_family');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_font_size');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_line_height');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_font_weight');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_font_color');
    register_setting('cookie_disclaimer-settings-group','cookie_disclaimer_letter_spacing');

}

function cookie_disclaimer_settings_page() {
    ?>
    <div class="wrap">
        <div style="display: flex;justify-content: space-between;">
            <h2>Cookie Disclaimer Settings</h2>
        </div>

        <p>Use Hex color values for the color fields.</p>
        <p>Links in the disclaimer text must be typed in with HTML <code>&lt;a&gt;</code> tags.
            <br />e.g. <code>This is a &lt;a href=&#34;http:&#47;&#47;www.wordpress.com&#34;&gt;Link to Wordpress&lt;&#47;a&gt;</code>.</p>

        <!-- Settings Form -->
        <form class="cookie-disclaimer-settings-form" method="post" action="options.php">
            <?php settings_fields( 'cookie_disclaimer-settings-group' ); ?>
            <?php do_settings_sections( 'cookie_disclaimer-settings-group' ); ?>

            <table class="form-table">
                <!-- Background Color -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer border and accept button color
                        <br><span style="font-weight:400;">Leaving this blank sets the color to the default value #f7c413</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_color" name="cookie_disclaimer_color" placeholder="Hex value"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_color') ); ?>" />
                        <input style="height: 30px;width: 100px;" type="color" id="cookie_disclaimer_color_show"
                               value="<?php echo ((get_option('cookie_disclaimer_color') == '') ? '#f7c413' : esc_attr( get_option('cookie_disclaimer_color') )); ?>">
                    </td>
                </tr>
                <!-- Container width -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer container width
                        <br><span style="font-weight:400;">Leaving this blank sets the width to the default value 211px</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_width" name="cookie_disclaimer_width" placeholder="Width in px eg. 5px"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_width') ); ?>" />
                    </td>
                </tr>
                <!-- Font style -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer font style
                        <br><span style="font-weight:400;">Leaving this blank sets the font style the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_font_style" name="cookie_disclaimer_font_style" placeholder="Enter font style"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_font_style') ); ?>" />
                    </td>
                </tr>
                <!-- Font family -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer font family
                        <br><span style="font-weight:400;">Leaving this blank sets the font family the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_font_family" name="cookie_disclaimer_font_family" placeholder="Enter font family"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_font_family') ); ?>" />
                    </td>
                </tr>
                <!-- Font size -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer font size
                        <br><span style="font-weight:400;">Leaving this blank sets the font size the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_font_size" name="cookie_disclaimer_font_size" placeholder="Font size in px eg. 5px"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_font_size') ); ?>" />
                    </td>
                </tr>
                <!-- Line height -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer line height
                        <br><span style="font-weight:400;">Leaving this blank sets the line height the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_line_height" name="cookie_disclaimer_line_height" placeholder="Line height in px eg. 5px"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_line_height') ); ?>" />
                    </td>
                </tr>
                <!-- Font weight -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer font weight
                        <br><span style="font-weight:400;">Leaving this blank sets the font weight the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_font_weight" name="cookie_disclaimer_font_weight" placeholder="Enter font weight"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_font_weight') ); ?>" />
                    </td>
                </tr>
                <!-- Font color -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer font color
                        <br><span style="font-weight:400;">Leaving this blank sets the font color the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_font_color" name="cookie_disclaimer_font_color" placeholder="Hex color"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_font_color') ); ?>" />
                    </td>
                </tr>
                <!-- Letter spacing -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer letter spacing
                        <br><span style="font-weight:400;">Leaving this blank sets the letter spacing the same as the active theme</span>
                    </th>
                    <td style="vertical-align:top;">
                        <input type="text" id="cookie_disclaimer_letter_spacing" name="cookie_disclaimer_letter_spacing" placeholder="Enter letter spacing"
                               value="<?php echo esc_attr( get_option('cookie_disclaimer_letter_spacing') ); ?>" />
                    </td>
                </tr>
                <!-- Cookie statement -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer Cookie statement
                        <br>
                        <span style="font-weight:400;">Leaving this blank sets "We use cookies to give you the best online experience." as default value.</span>
                    </th>
                    <td>
                        <textarea id="cookie_disclaimer_cookie_statement" class="large-text code" style="height: 150px;width: 97%;" name="cookie_disclaimer_cookie_statement"><?php echo get_option('cookie_disclaimer_cookie_statement'); ?></textarea>
                    </td>
                </tr>
                <!-- Site ownership -->
                <tr align="top">
                    <th scope="row">
                        Cookie disclaimer Site ownership
                        <br>
                        <span style="font-weight:400;">Leaving this blank sets "By using our website, you agree to our <a href="/privacy-policy" target="_blank" class="privacy_policy_link">privacy policy</a>" as default value.</span>
                    </th>
                    <td>
                        <textarea id="cookie_disclaimer_site_ownership" class="large-text code" style="height: 150px;width: 97%;" name="cookie_disclaimer_site_ownership"><?php echo get_option('cookie_disclaimer_site_ownership'); ?></textarea>
                    </td>
                </tr>
            </table>
            <!-- Save Changes Button -->
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
