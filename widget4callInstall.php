<?php
class Widget4CallInstall
{
  public function __construct(){}

  public static function install(){
    update_option('w4c_private_key','');
    global $wpdb;
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}w4c_widget (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), _id VARCHAR(255), type VARCHAR(255), code TEXT);");
  }

  public static function uninstall(){
    global $wpdb;
    update_option('w4c_private_key','BBB');
    $wpdb->query("DROP TABLE {$wpdb->prefix}w4c_widget;");
  }
}