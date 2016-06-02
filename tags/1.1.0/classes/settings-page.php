<?php

require_once( __DIR__ . '/script-installed.php');

class Settings_Page {

  private $settings_api;

  function __construct() {
    $page = $_GET['page'];
    $this->settings_api = new WeDevs_Settings_API;
    add_action( 'admin_menu', array($this, 'admin_menu') );
    add_action( 'admin_init', array($this, 'admin_init') );
    if ($page == 'podbuzzz') {
      add_action( 'admin_notices', array($this, 'script_installed') );
      add_action( 'admin_enqueue_scripts', array($this, 'settings_page_style') );
    }
  }

  // Initialize
  function admin_init() {
    $this->settings_api->set_sections( $this->get_settings_sections() );
    $this->settings_api->set_fields( $this->get_settings_fields() );
    $this->settings_api->admin_init();
  }

  // Creates settings page
  function admin_menu() {
    add_options_page( 'PodBuzzz', 'PodBuzzz', 'manage_options', 'podbuzzz', array($this, 'settings_page') );
  }

  // Gets settings sections
  function get_settings_sections() {
    $sections = array(
      array(
        'id' => 'podbuzzz'
      )
    );
    return $sections;
  }

  // Gets settings fields
  function get_settings_fields() {
    $settings_fields = array(
      'podbuzzz' => array(
        array(
          'name'       => 'key',
          'label'       => __( 'PodBuzz Key', 'podbuzzz' ),
          'desc'       => __( 'Your PodBuzzz Key', 'podbuzzz' ),
          'type'       => 'text',
          'default'      => ''
        ),
        array(
          'name'  => 'enabled',
          'label'  => __( 'Enabled', 'podbuzzz' ),
          'desc'  => __( 'Enables the PodBuzzz inline script', 'podbuzzz' ),
          'type'  => 'radio',
          'default' => 'yes',
          'options' => array(
            'yes' => 'Yes',
            'no' => 'No'
          )
        )
      )
    );

    return $settings_fields;
  }

  // Settings page
  function settings_page() {
    ?><div class="wrap">
      <h1>PodBuzzz</h1>
      <div class="left">
        <img id="podbuzzzImage" src="<?php echo plugins_url( 'assets/images/podbuzzz.png', dirname(__FILE__) ) ?>" />
      </div>
      <div class="right">
        <?php
       // $this->settings_api->show_navigation();
          $this->settings_api->show_forms();
        ?>
      </div>
    </div><?php
  }
  
  // Settings page style
  function settings_page_style() {
    wp_enqueue_style( 'admin_css', plugins_url( 'assets/styles/settings-page.css', dirname(__FILE__) ), false );
  }
  
  // Check if script is installed
  function script_installed() {
    $scriptInstalled = new Script_Installed;
    $scriptStatus = $scriptInstalled->verify();
    $noticeType = 'notice-success';
    switch ($scriptStatus) {
      case 'installed':
          $scriptStatus = 'Your podcast widget is installed!';
          break;
      case 'not_installed':
          $scriptStatus = 'The script is not installed. Make sure you have a valid key and the plugin is enabled.';
          $noticeType = 'notice-warning';
          break;
      case 'no_curl':
          $scriptStatus = 'Cannot check if script is installed without the PHP curl module.';
          $noticeType = 'notice-error';
          break;
      default:
          $scriptStatus = 'There was an error checking if the script was installed.';
          $noticeType = 'notice-error';
          break;
    }
    echo '<div class="notice '.$noticeType.' is-dismissible"><p>'.$scriptStatus.'</p></div>';
  }

}
