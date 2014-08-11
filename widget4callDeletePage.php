<?php
class Widget4CallDeletePage
{
  public static $widget = array();

  public function __construct(){
  }

	public static function html_w4c_widgetdeletepage(){
    $w4c_private_key = get_option('w4c_private_key');
    if(!empty($w4c_private_key)){?>
      <div id="w4c" class="wrap">
        <h2>Widget4Call for WordPress</h2>
        <div id="w4c-content">
          <h3 class="w4c-admin-title"><?php echo get_admin_page_title()?></h3>
        </div>
      </div>
      <?php
    }
  }

  public static function process_action(){
    Widget4Call_Plugin::getUser();
    $w4c_private_key = get_option('w4c_private_key');
    if(!empty($w4c_private_key)){
      global $wpdb;
      if (isset($_GET['_id'])) {
        $response = wp_remote_get('https://w4c.widget4call.fr/wp/'.get_option('w4c_private_key').'/widgets/'.$_GET['_id'].'/delete');
        $response = json_decode(wp_remote_retrieve_body($response)); 
        if($response->status == 'ok'){
          $wpdb->query(
            $wpdb->prepare("DELETE from {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE _id= '%s'", $_GET['_id'])
          );
          $_SESSION['w4c-flash'] = 'deleted';
          wp_redirect(admin_url('admin.php?page=w4c_widgets'));
        }
      }
    }
  }
}