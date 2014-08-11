<?php
class Widget4CallHomePage
{
  public function __construct(){
  }

	public static function html_w4c_homepage(){
    $boxStatus = "<span class='box-status connected'>Connecté</span>";
    $w4c_private_key = get_option('w4c_private_key');
    if(empty($w4c_private_key))
      $boxStatus = "<span class='box-status disconnected'>Déconnecté</span>";
    ?>
    <div id="w4c" class="wrap">
      <h2>Widget4Call for WordPress</h2>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title()." : $boxStatus"?></h3>
    	  Vous devez génerer votre clé
        <form method="post" action="">
          <table class="form-table">
            <tr valign="top">
              <td scope="row"><label for="w4c_private_key">Clé Widget4Call : </label><td>
              <td>
                <input type="text" id="w4c_private_key" class="widefat" name="w4c_private_key" value="<?php echo get_option('w4c_private_key'); ?>"/><br/>
                <a href="https://w4c.widget4call.fr/fr/profil" target="_blank">Obtenir votre clé Widget4Call</a>
              </td>
            </tr>
          </table>
          <?php submit_button('Valider clé'); ?>
        </form>
      </div>
    </div>
    <?php
  }

  public static function process_action(){
    Widget4Call_Plugin::getUser();
    if (isset($_POST['w4c_private_key'])) {
      $response = wp_remote_get('https://w4c.widget4call.fr/fr/wp/checkprivatekey?private_key='.$_POST['w4c_private_key']);
      $response = json_decode(wp_remote_retrieve_body($response));
      if($response->status == 'ok'){
        update_option('w4c_private_key', $_POST['w4c_private_key']);
        add_settings_error('w4c_private_key_settings', 'settings_updated', 'Clé Widget4Call validée vous pouvez créer vos widgets.','updated');
      } else {
        update_option('w4c_private_key', '');
        add_settings_error('w4c_private_key_settings', 'settings_updated', 'Clé Widget4Call n\'est pas validée.','error');
      }
    }
  }
}