<?php
class Widget4CallUserPage
{
  public static $user = array();
  
  public function __construct(){}

	public static function html_w4c_widgetuserpage(){
    ?>
    <div id="w4c" class="wrap">
      <h2>Widget4Call for WordPress</h2>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title()?></h3>
          <?php
          $w4c_private_key = get_option('w4c_private_key');
          if(!empty($w4c_private_key)) {
          $user = Widget4CallUserPage::$user; ?>
          <form method="post" action="">
            <table class="form-table">
              <tr valign="top">
                <td scope="row"><label for="w4c-company">Votre société : </label></td>
                <td><input type="text" id="w4c-company" name="company" value="<?php echo $user->company?>" required class="widefat"/></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-first-name">Prénom : </label></td>
                <td><input type="text" id="w4c-first-name" name="first-name" value="<?php echo $user->{'first-name'}?>" required class="widefat"/></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-last-name">Nom : </label></td>
                <td><input type="text" id="w4c-last-name" name="last-name" value="<?php echo $user->{'last-name'}?>" required class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-phone">Numéro de téléphone : </label></td>
                <td><input type="text" id="w4c-phone" name="phone" value="<?php echo $user->{'phone'}?>" required class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-address">Adresse : </label></td>
                <td>
                  <input type="text" id="w4c-address" name="address" value="<?php echo $user->{'address'}?>" required class="widefat" />
                </td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-zip">Code postal : </label></td>
                <td>
                  <input type="text" id="w4c-zip" name="zip" value="<?php echo $user->{'zip'}?>" required class="widefat" />
                </td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-town">Ville : </label></td>
                <td><input type="text" id="w4c-town" name="town" value="<?php echo $user->{'town'}?>" required class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-town">Pays : </label></td>
                <td><input type="text" id="w4c-country" name="country" value="<?php echo $user->{'country'}?>" required class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-language">Langue : </label></td>
                <td>
                  <select name="language" id="w4c-language" class="widefat">
                    <option value="en" <?php if($user->language == 'en') echo 'selected';?>>Anglais</option>
                    <option value="fr" <?php if($user->language == 'fr') echo 'selected';?>>Français</option>
                  </select>
                </td>
              </tr>
            </table>
            <?php submit_button('Enregistrer'); ?>
          </form>
          <?php
          } else { ?>
            <p>Vous devez tout d'abord renseigner votre clé Widget4Call : <a href="<?php echo admin_url('admin.php?page=widget4call')?>">cliquez ici</a></p><?php
          } ?>
        </div>
      </div> <?php
  }

  public static function process_action(){
    Widget4CallUserPage::$user = Widget4Call_Plugin::getUser();
    if(isset($_SESSION['w4c-flash'])){
      if($_SESSION['w4c-flash'] == 'success')
        add_settings_error('w4cUserProfil', 'settings_updated', 'Profil mis à jour.' ,'updated');
      unset($_SESSION['w4c-flash']);
    }
    $w4c_private_key = get_option('w4c_private_key');
    if(!empty($w4c_private_key)){
      global $wpdb;
      if(isset($_POST['company'])) {
        $_POST['website'] = $_SERVER['HTTP_HOST'];
        $_POST['old-password'] = '';
        $_POST['password'] = '';
        $_POST['conf-password'] = '';
        
        $url ='https://w4c.widget4call.fr/fr/wp/'.get_option('w4c_private_key').'/users';
        $response = wp_remote_post($url, array('body' => $_POST));
        $response = json_decode(wp_remote_retrieve_body($response));
        if($response->status == 'ok'){
          $_SESSION['w4c-flash'] = 'success';
          wp_redirect(admin_url('admin.php?page=w4c_user_profil'));
        } else {
        }
      }
    }
  }
}