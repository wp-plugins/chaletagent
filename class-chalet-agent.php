<?php
/**
 * Plugin Name: ChaletAgent
 * Plugin URI: http://ChaletAgent.com/
 * Description: This plugin integrates ChaletAgent with your WordPress based chalet web site.
 * Version: 0.1
 * Author: ChaletAgent
 * Author URI: http://ChaletAgent.com/
 * License: GPL2
 */

 /*  Copyright 2014  ChaletAgent  (email : info@chaletagent.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");

include 'class-chalet-agent-api.php';

$chaletAgent = new Chalet_Agent();

/**
 * Class Chalet_Agent
 */
class Chalet_Agent
{
	/**
	 * @var string
	 */
	protected $pluginPath;

	/**
	 * @var string
	 */
	protected $pluginUrl;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * Constructor method
	 */
	public function __construct ()
	{
		// Set Plugin Path
		$this->pluginPath = dirname(__FILE__);

		// Set Plugin URL
		$this->pluginUrl = WP_PLUGIN_URL . '/chalet-agent';

		// Create the config option if it doesn't already exist.
		add_option('chaletagent_id', 'test');

		// Get the current value of the option
		$this->username = get_option('chaletagent_id');

		// Register the admin menu
		add_action('admin_menu', array($this, 'chaletagent_menu'));

		// Define shortcodes
		add_shortcode('chaletagent_availability', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_transfers', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_testimonials', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_seasons', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_properties', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_lift_passes', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_lift_pass_types', array($this, 'chaletops_shortcode'));

		// Enqueue custom CSS
		add_action('wp_enqueue_scripts', array($this, 'enqueue_style'));
	}

	/*#######################################################################################*/

	/**
	 * Create template tag
	 *
	 * @param string $name The API method name to call
	 * @param array  $attr The parameters to send to the method
	 *
	 * @return string
	 */
	public function chaletagent_template ($name, $attr)
	{
		$api = new Chalet_Agent_API($this->username);

		$name = 'get_' . str_replace('chaletagent_', '', $name);

		return $api->get_{$name}($attr);
	}

	/**
	 * Create shortcode
	 *
	 * @param string $name The API method name to call
	 * @param array  $attr The parameters to send to the method
	 *
	 * @return string
	 */
	public function chaletops_shortcode ($attr, $content='', $name)
	{
		$api = new Chalet_Agent_API($this->username);

		$name = 'get_' . str_replace('chaletagent_', '', $name);

		$parameters = shortcode_atts(array(
			'season' => null,
			'property' => null,
		), $attr );

		return $api->{$name}($parameters);
	}

	/*#######################################################################################*/

	/**
	 * Define the admin navigation entry
	 */
	public function chaletagent_menu ()
	{
		add_options_page(
			'ChaletAgent Options',
			'ChaletAgent',
			'manage_options',
			'chaletagent-options',
			array($this, 'chaletagent_options')
		);
	}

	/**
	 * Define the admin screen that allows setting of options
	 */
	public function chaletagent_options ()
	{
		if (!current_user_can('manage_options'))
		{
			wp_die(__( 'You do not have sufficient permissions to access this page.' ));
		}

		// Variables for the field and option names
		$opt_name 			= 'chaletagent_id';
		$hidden_field_name 	= 'chaletagent_submit_hidden';
		$data_field_name 	= 'chaletagent_favorite_color';

		// Read in existing option value from database
		$opt_val = get_option($opt_name);

		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y')
		{
			// Read their posted value
			$opt_val = $_POST[$data_field_name];

			// Save the posted value in the database
			update_option($opt_name, $opt_val);

			// Put an settings updated message on the screen
			?><div class="updated">
				<p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p>
			</div><?php
		}

		// Now display the settings editing screen
		echo '<div class="wrap" style="height: 2000px;">';
		echo "<h2>" . __( 'ChaletAgent Settings', 'menu-test' ) . "</h2>";

			// Settings form
			?>
			<p>Please configure the plugin here before use.</p>

			<form name="form1" method="post" action="">
				<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
				<p>
					<?php _e("ChaletAgent Username:", 'menu-test' ); ?>
					<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
					.chaletagent.com
				</p>
				<hr />
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
				</p>
			</form>

			<?php include 'help-text.php'; ?>

		</div>

		<?php
	}

	/**
	 * Proper way to enqueue scripts and styles
	 */
	public function enqueue_style ()
	{
		wp_enqueue_style('chalet-agent', plugins_url('chalet-agent.css', __FILE__));
	}

}
