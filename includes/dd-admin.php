<?php
class DDAdmin
{
	protected static $instance = null;

    public static function get_instance() 
    {
	 	// create an object
	 	NULL === self::$instance and self::$instance = new self;

	 	return self::$instance;
	 }

    public function init()
    { 	
    	$this->fileInlcudes();

        add_action('admin_menu', array($this, 'menuItems')); 

        add_action( 'init', array($this, 'userFiles')); 

        add_action('wp_footer', array($this, 'ddUserInlineJS'), 20);
    }

    public function fileInlcudes()
    {
        require_once DD_PLUGIN_DIR .'/includes/post-requests.php';
        require_once DD_PLUGIN_DIR .'/includes/dd-data.php';
        require_once DD_PLUGIN_DIR .'/includes/user-post-requests.php';
        require_once DD_PLUGIN_DIR .'/includes/dd-helper.php';
        require_once DD_PLUGIN_DIR .'/includes/dd-view.php';
        require_once DD_PLUGIN_DIR .'/includes/dd-listtable.php';
        require_once DD_PLUGIN_DIR .'/includes/dd-shortcodes.php';
    }

    public function menuItems()
    {
        add_menu_page('Data Dash', 'Data Dash', 'manage_options', 'data-dash', array($this, 'pageDashboard'));

        $PageA = add_submenu_page( 'data-dash', 'Dashboard', 'Dashboard', 'manage_options', 'data-dash', array($this, 'pageDashboard'));
        $PageB = add_submenu_page( 'data-dash', 'Data Counter', 'Data Counter', 'manage_options', 'dd-data-counter', array($this, 'pageDataCounter') ); 
        $PageC = add_submenu_page( null, 'Create Counter', 'Create Counter', 'manage_options', 'dd-create-counter', array($this, 'pageCreateCounter') ); 
        $PageD = add_submenu_page( null, 'Update Counter', 'Update Counter', 'manage_options', 'dd-update-counter', array($this, 'pageUpdateCounter') ); 

        add_action('admin_print_scripts-' . $PageA, array($this, 'adminScriptStyles'));
        add_action('admin_print_scripts-' . $PageB, array($this, 'adminScriptStyles'));
        add_action('admin_print_scripts-' . $PageC, array($this, 'adminScriptStyles'));
        add_action('admin_print_scripts-' . $PageD, array($this, 'adminScriptStyles'));
    }

    public function adminScriptStyles()
    {
        if(is_admin()) 
        {   
            wp_enqueue_script( 'dd-validate-form', plugins_url( 'data-dash/js/think201-validator.js' ), array( 'jquery' ), false, true );

            wp_enqueue_script( 'dd-ajax-request', plugins_url( 'data-dash/js/ddjs.js' ), array( 'jquery' ), false, true );
            wp_localize_script( 'dd-ajax-request', 'DDAjax', array( 'ajaxurl' => plugins_url( 'admin-ajax.php' ) ) );
            
            wp_enqueue_style( 'dd-css', plugins_url( 'data-dash/assets/css/dd.css' ), array(), DD_VERSION, 'all' );
        }
    }

    public function userFiles()
    {
        if (!is_admin()) 
        {
            wp_enqueue_style( 'dd-css', plugins_url( 'data-dash/assets/css/dd.css' ), array(), DD_VERSION, 'all' );
            wp_enqueue_script( 'user-ajax-request', plugins_url( 'data-dash/js/dd-user.js' ), array( 'jquery' ), false, true );
            wp_localize_script( 'user-ajax-request', 'DDUserAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );                 
        }
    }     

    public function ddUserInlineJS()
    {
        require_once DD_PLUGIN_DIR .'/pages/user-footer.php'; 
    }

    public function pageDashboard()
    {
        require_once DD_PLUGIN_DIR .'/pages/admin-dashboard.php';     
    }

    public function pageDataCounter()
    {
        require_once DD_PLUGIN_DIR .'/pages/admin-data-counter.php';
    }

    public function pageCreateCounter()
    {
        require_once DD_PLUGIN_DIR .'/pages/admin-create-counter.php';
    }

    public function pageUpdateCounter()
    {
        require_once DD_PLUGIN_DIR .'/pages/admin-update-counter.php';   
    }
}
?>