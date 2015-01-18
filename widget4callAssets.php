<?php
class Widget4CallAssets {
  public function __construct(){
    wp_enqueue_style('w4c_admin_style', plugins_url( '/assets/css/admin.css' , __FILE__ ),array(), '1.0', false);
    wp_enqueue_style('w4c_widget_style',plugins_url( '/assets/css/w4c.css', __FILE__));
    wp_enqueue_style('wp-color-picker');
 	wp_enqueue_script('my-script', plugins_url( '/assets/js/script.js' , __FILE__ ),array('wp-color-picker', 'jquery-ui-slider'), false, true); 
  }
}
