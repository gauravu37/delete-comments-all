<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://prontoinfosys.com
 * @since      1.0.0
 *
 * @package    Delete_Comments_All
 * @subpackage Delete_Comments_All/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Delete_Comments_All
 * @subpackage Delete_Comments_All/public
 * @author     Gaurav Mittal <er.gauravmittal1989@gmail.com>
 */
class Delete_Comments_All_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_action('admin_menu', [$this, 'add_admin_menu']);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Delete_Comments_All_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Delete_Comments_All_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/delete-comments-all-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Delete_Comments_All_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Delete_Comments_All_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/delete-comments-all-public.js', array( 'jquery' ), $this->version, false );

	}
	
	// Add admin menu
    public function add_admin_menu() {
        add_menu_page(
            'Delete Comments',           // Page title
            'Delete Comments',           // Menu title
            'manage_options',            // Capability
            'delete-comments-filters',   // Menu slug
            [$this, 'render_admin_page'] // Callback function
        );
    }

    // Render admin page
    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Handle form submission
        if (isset($_POST['dcf_delete_comments'])) {
            $this->process_deletion();
        }

        ?>
        <div class="wrap">
            <h1>Delete Comments with Filters</h1>
            <form method="POST">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="dcf_user">Filter by User</label></th>
                        <td>
                            <input type="text" name="dcf_user" id="dcf_user" placeholder="Username">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="dcf_date">Filter by Date</label></th>
                        <td>
                            <input type="date" name="dcf_date" id="dcf_date">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="dcf_keyword">Filter by Keyword</label></th>
                        <td>
                            <input type="text" name="dcf_keyword" id="dcf_keyword" placeholder="Keyword in comment">
                        </td>
                    </tr>
                </table>
                <?php submit_button('Delete Comments', 'primary', 'dcf_delete_comments'); ?>
            </form>
        </div>
        <?php
    }
	
	// Process comment deletion
    private function process_deletion() {
        global $wpdb;

        $user    = sanitize_text_field($_POST['dcf_user'] ?? '');
        $date    = sanitize_text_field($_POST['dcf_date'] ?? '');
        $keyword = sanitize_text_field($_POST['dcf_keyword'] ?? '');

        $query = "SELECT comment_ID FROM $wpdb->comments WHERE 1=1";
        $query_args = [];

        if (!empty($user)) {
            $user_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_login = %s", $user));
            if ($user_id) {
                $query .= " AND user_id = %d";
                $query_args[] = $user_id;
            }
        }

        if (!empty($date)) {
            $query .= " AND DATE(comment_date) = %s";
            $query_args[] = $date;
        }

        if (!empty($keyword)) {
            $query .= " AND comment_content LIKE %s";
            $query_args[] = '%' . $wpdb->esc_like($keyword) . '%';
        }

        $comments = $wpdb->get_col($wpdb->prepare($query, $query_args));

        if (!empty($comments)) {
            foreach ($comments as $comment_id) {
                wp_delete_comment($comment_id, true);
            }
            echo '<div class="updated notice"><p>Comments deleted successfully.</p></div>';
        } else {
            echo '<div class="error notice"><p>No comments found matching the criteria.</p></div>';
        }
    }

}
