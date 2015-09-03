<?php
class Widget4CallMenu
{
  public function __construct(){
  	add_action('admin_menu', array($this, 'add_admin_menu'));
  }
  
	public function add_admin_menu(){
    //HomePage
    $hook = add_menu_page('Widget4Call Settings', 'Widget4Call', 'manage_options', 'widget4call', array('Widget4CallHomepage', 'html_w4c_homePage'), 'dashicons-megaphone');
    add_action('load-'.$hook, array('Widget4CallHomepage', 'process_action'));
    //Widgets
    $hook = add_submenu_page('widget4call', 'Widgets List', 'Mes Widgets', 'manage_options', 'w4c_widgets', array('Widget4CallListPage', 'html_w4c_widgetspage'));
    add_action('load-'.$hook, array('Widget4CallListPage', 'process_action'));
    //Widget Form
    $hook = add_submenu_page('widget4call', 'Widget Form', 'Ajouter widget', 'manage_options', 'w4c_widget_form', array('Widget4CallFormPage', 'html_w4c_widgetformpage'));
    add_action('load-'.$hook, array('Widget4CallFormPage', 'process_action'));
    //Widget Form
    $hook = add_submenu_page('widget4call', 'Votre profil', 'Votre profil', 'manage_options', 'w4c_user_profil', array('Widget4CallUserPage', 'html_w4c_widgetuserpage'));
    add_action('load-'.$hook, array('Widget4CallUserPage', 'process_action'));
    //Cdrs Logs
    $hook = add_submenu_page('widget4call', 'Journal d\'appels', 'Journal d\'appels', 'manage_options', 'w4c_cdr_log', array('Widget4CallCdrPage', 'html_w4c_cdrpage'));
    add_action('load-'.$hook, array('Widget4CallCdrPage', 'process_action'));
    //Widget Delete
    $hook = add_submenu_page(null, 'Widget Delete', 'Delete Widget', 'manage_options', 'w4c_widget_delete', array('Widget4CallDeletePage', 'html_w4c_widgetdeletepage'));
    add_action('load-'.$hook, array('Widget4CallDeletePage', 'process_action'));
    //Generate shorcode
    $hook = add_submenu_page(null, 'Add externale Widget', 'Add externale Widget', 'manage_options', 'w4c_add_external_widget', array('Widget4CallListPage', 'add_external_widget'));
    add_action('load-'.$hook, array('Widget4CallListPage', 'process_action'));
    $hook = add_submenu_page(null, 'Dev Mode', 'Dev Mode', 'manage_options', 'w4c_devmode', array('Widget4CallDevModePage', 'html_w4c_devmodepage'));
    add_action('load-'.$hook, array('Widget4CallDevModePage', 'process_action'));
  }
}