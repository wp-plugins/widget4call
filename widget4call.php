<?php
/*
Plugin Name: Widget4Call
Description: Click to Call and Web Call Back solution By APIdaze
Version: 1.0.7
Author: APIdaze
Author URI: https://developers.apidaze.io
*/
class Widget4Call_Plugin{
	
	const W4C_DB_WIDGET = 'w4c_widget';
	public static $countNotif = 0;

	public function __construct(){
		include_once(plugin_dir_path(__FILE__).'/widget4callInstall.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callAssets.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callMenu.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callShortcode.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callNotices.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callHomePage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callCdrPage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callListPage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callFormPage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callDeletePage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callUserPage.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callWidget.php');
		include_once(plugin_dir_path(__FILE__).'/widget4callDevModePage.php');

		new Widget4CallInstall();
		new Widget4CallAssets();
		new Widget4CallMenu();
		new Widget4CallShortcode();
		new Widget4CallNotices();
		new Widget4CallHomePage();
		new Widget4CallCdrPage();
		new Widget4CallListPage();
		new Widget4CallFormPage();
		new Widget4CallUserPage();
		new Widget4CallDeletePage();
		new Widget4CallDevModePage();

		add_action('init', array($this, 'register_session'));
		add_action('widgets_init', function(){register_widget('Widget4CallWidget');});
		
		register_activation_hook(__FILE__, array('Widget4CallInstall', 'install'));
		register_uninstall_hook(__FILE__, array('Widget4CallInstall', 'uninstall'));
		register_deactivation_hook(__FILE__, array('Widget4CallInstall', 'uninstall'));
	}

	public function register_session(){
		if(!session_id())
			session_start();
	}
	
	public static function getUser(){
		$w4c_private_key = get_option('w4c_private_key');
		if(empty($w4c_private_key))
			add_settings_error('w4cPrivateKeySettings', 'settings_updated','Vous devez tout d\'abord renseigner votre clé Widget4Call : <a href="'.admin_url('admin.php?page=widget4call').'">cliquez ici</a>' ,'error');
		else{
			$response = wp_remote_get('https://w4c.widget4call.fr/wp/'.get_option('w4c_private_key').'/users');
			$response = json_decode(wp_remote_retrieve_body($response));
			if($response->status == 'ok'){
				if(!$response->isCompleteProfil)
					add_settings_error('w4cCompleteProfil', 'settings_updated','Vous devez tout d\'abord completer votre profil avant de pouvoir recevoir des appels' ,'error');
				if(!$response->isCallAllow)
					add_settings_error('w4cCallAllow', 'settings_updated','Vous ne pouvez plus recevoir d\'appels, Vous devez souscrire à un nouvel abonnement.',	'error');
				return $response->data;
			}
			else
				return array('company' => '', 'first-name' => '', 'last-name' => '', 'phone' => '', 'address' => '', 'zip' => '', 'town' => '', 'country' => '');
		}
		return array('company' => '', 'first-name' => '', 'last-name' => '', 'phone' => '', 'address' => '', 'zip' => '', 'town' => '', 'country' => '');
	}
}
new Widget4Call_Plugin();
