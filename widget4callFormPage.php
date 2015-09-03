<?php
class Widget4CallFormPage
{
  public static $widget = array();

  public function __construct(){
    Widget4CallFormPage::$widget = array(
      '_id' => '',
      'name' => '',
      'phone-display' => '0100000001',
      'phone-customer-display' => '0100000001',
      'immediat-recall' => true,
      'destinations' => array(),
      'timeouts' => array(),
      'strategy' => 'simultaneous',
      'pa-message' => '',
      'tod-active' => true,
      'tod' => array(
        'mondayactive' => true,
        'monday0' => 540,
        'monday1' => 720,
        'monday2' => 840,
        'manday3' => 1080,
        'tuesdayactive' => true,
        'tuesday0' => 540,
        'tuesday1' => 720,
        'tuesday2' => 840,
        'tuesday3' => 1080,
        'wednesdayactive' => true,
        'wednesday0' => 540,
        'wednesday1' => 720,
        'wednesday2' => 840,
        'wednesday3' => 1080,
        'thursdayactive' => true,
        'thursday0' => 540,
        'thursday1' => 720,
        'thursday2' => 840,
        'thursday3' => 1080,
        'fridayactive' => true,
        'friday0' => 540,
        'friday1' => 720,
        'friday2' => 840,
        'friday3' => 1080,
        'saturdayactive' => false,
        'saturday0' => 540,
        'saturday1' => 720,
        'saturday2' => 840,
        'saturday3' => 1080,
        'sundayactive' => false,
        'sunday0' => 540,
        'sunday1' => 720,
        'sunday2' => 840,
        'sunday3' => 1080,
      ),
      'tod-message' => '',
      'callback-email' => '',
      'button-type' => 'notif',
      'button-header-bg-color' => '#305394',
      'button-header-color' => '#ffffff',
      'button-header-text' => 'Echangez avec un conseiller',
      'button-header-icon-active' => false,
      'button-content-bg-color' => '#ffffff',
      'button-content-color' => '#000000',
      'button-content-text' => "Appel gratuit\nmise en relation immediate",
      'button-content-img' => 'agent1.png',
      'button-content-img-dir' => 'img/',
      'button-size' => 'lg',
      'button-color' => '#305394',
      'button-text-color' => '#ffffff',
      'button-icon-active' => true,
      'button-text' => "J'appelle un conseiller",
    );
  }

  public static function html_w4c_widgetformpage(){
    ?>
    <div id="w4c" class="wrap">
      <h2>Widget4Call for WordPress</h2>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title()?></h3>
        <?php
        $w4c_private_key = get_option('w4c_private_key');
        if(!empty($w4c_private_key)){
        $widget = Widget4CallFormPage::$widget; ?>
          <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="_id" value="<?php echo $widget['_id']?>"/>
            <input type="hidden" name="id" value="<?php echo $widget['_id']?>"/>
            <table class="form-table">
              <tr valign="top">
                <td scope="row"><label for="w4c-name">Nom du Widget : </label></td>
                <td><input type="text" id="w4c-name" name="w4c-name" value="<?php echo $widget['name']?>" required class="widefat"/></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-phone-display">Numéro a afficher (entreprise) : </label></td>
                <td><input type="text" id="w4c-phone-display" name="w4c-phone-display" value="<?php echo $widget['phone-display']?>" required class="widefat"/></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-phone-customer-display">Numéro à afficher (prospect) : </label></td>
                <td><input type="text" id="w4c-phone-customer-display" name="w4c-phone-customer-display" value="<?php echo $widget['phone-customer-display']?>" required class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-destinations">Numéro à appeler : </label></td>
                <td>
                  <div id="w4c-destinations-wrap">
                    <?php foreach ($widget['destinations'] as $key => $destinations) {
                       ?>
                       <input type="text" id="w4c-destinations" name="w4c-destinations[]" value="<?php echo $destinations?>" class="" /> 
                       <input type="text" id="w4c-timeouts" name="w4c-timeouts[]" value="<?php echo $widget['timeouts'][$key]?>"/> 
                       <a href="" class="button remove-input-destination"><i class="dashicons dashicons-no"></i> </a>
                       <?php
                    }?>
                  </div>
                  <p><a href="" id="add-input-destination" class="button button-small"><i class="dashicons dashicons-plus-alt"></i> Add phone</a></p>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-strategy">Strategie d'appel : </label></td>
                <td>
                  <select name="w4c-strategy" id="w4c-strategy">
                    <option value="simultaneous" <?php if($widget['strategy'] == 'simultaneous') echo 'selected';?>>Simultanément</option>
                    <option value="sequence" <?php if($widget['strategy'] == 'sequence') echo 'selected';?>>Cascade</option>
                  </select>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-pa-message">Message vocal en début d'appel : </label></td>
                <td><input type="text" id="w4c-pa-message" name="w4c-pa-message" value="<?php echo $widget['pa-message']?>" class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row" colspan="2" class="table-title">Horaire : 
                <input type="checkbox" id="w4c-tod-active" name="w4c-tod-active" 
                value="<?php echo $widget['tod-active']; ?>"<?php if($widget['tod-active']) echo 'checked'?>/></td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Lundi </label> <input type="checkbox" name="w4c-tod[mondayactive]" class="w4c-day-active" <?php if($widget['tod']['mondayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-monday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span><br/>
                  <input type="hidden" name="w4c-tod[monday0]" class="w4c-tod0" value="<?php echo $widget['tod']['monday0']?>">
                  <input type="hidden" name="w4c-tod[monday1]" class="w4c-tod1" value="<?php echo $widget['tod']['monday1']?>">
                  <input type="hidden" name="w4c-tod[monday2]" class="w4c-tod2" value="<?php echo $widget['tod']['monday2']?>">
                  <input type="hidden" name="w4c-tod[monday3]" class="w4c-tod3" value="<?php echo $widget['tod']['monday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Mardi </label> <input type="checkbox" name="w4c-tod[tuesdayactive]" class="w4c-day-active" <?php if($widget['tod']['tuesdayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-tuesday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[tuesday0]" class="w4c-tod0" value="<?php echo $widget['tod']['tuesday0']?>">
                  <input type="hidden" name="w4c-tod[tuesday1]" class="w4c-tod1" value="<?php echo $widget['tod']['tuesday1']?>">
                  <input type="hidden" name="w4c-tod[tuesday2]" class="w4c-tod2" value="<?php echo $widget['tod']['tuesday2']?>">
                  <input type="hidden" name="w4c-tod[tuesday3]" class="w4c-tod3" value="<?php echo $widget['tod']['tuesday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Mercredi </label> <input type="checkbox" name="w4c-tod[wednesdayactive]" class="w4c-day-active" <?php if($widget['tod']['wednesdayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-wednesday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[wednesday0]" class="w4c-tod0" value="<?php echo $widget['tod']['wednesday0']?>">
                  <input type="hidden" name="w4c-tod[wednesday1]" class="w4c-tod1" value="<?php echo $widget['tod']['wednesday1']?>">
                  <input type="hidden" name="w4c-tod[wednesday2]" class="w4c-tod2" value="<?php echo $widget['tod']['wednesday2']?>">
                  <input type="hidden" name="w4c-tod[wednesday3]" class="w4c-tod3" value="<?php echo $widget['tod']['wednesday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Jeudi </label> <input type="checkbox" name="w4c-tod[thursdayactive]" class="w4c-day-active" <?php if($widget['tod']['thursdayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-thursday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[thursday0]" class="w4c-tod0" value="<?php echo $widget['tod']['thursday0']?>">
                  <input type="hidden" name="w4c-tod[thursday1]" class="w4c-tod1" value="<?php echo $widget['tod']['thursday1']?>">
                  <input type="hidden" name="w4c-tod[thursday2]" class="w4c-tod2" value="<?php echo $widget['tod']['thursday2']?>">
                  <input type="hidden" name="w4c-tod[thursday3]" class="w4c-tod3" value="<?php echo $widget['tod']['thursday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Vendredi </label> <input type="checkbox" name="w4c-tod[fridayactive]" class="w4c-day-active" <?php if($widget['tod']['fridayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-friday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[friday0]" class="w4c-tod0" value="<?php echo $widget['tod']['friday0']?>">
                  <input type="hidden" name="w4c-tod[friday1]" class="w4c-tod1" value="<?php echo $widget['tod']['friday1']?>">
                  <input type="hidden" name="w4c-tod[friday2]" class="w4c-tod2" value="<?php echo $widget['tod']['friday2']?>">
                  <input type="hidden" name="w4c-tod[friday3]" class="w4c-tod3" value="<?php echo $widget['tod']['friday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Samedi </label> <input type="checkbox" name="w4c-tod[saturdayactive]" class="w4c-day-active" <?php if($widget['tod']['saturdayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-saturday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[saturday0]" class="w4c-tod0" value="<?php echo $widget['tod']['saturday0']?>">
                  <input type="hidden" name="w4c-tod[saturday1]" class="w4c-tod1" value="<?php echo $widget['tod']['saturday1']?>">
                  <input type="hidden" name="w4c-tod[saturday2]" class="w4c-tod2" value="<?php echo $widget['tod']['saturday2']?>">
                  <input type="hidden" name="w4c-tod[saturday3]" class="w4c-tod3" value="<?php echo $widget['tod']['saturday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top" class="w4c-tod-wrap">
                <td scope="row"><label>Dimanche </label> <input type="checkbox" name="w4c-tod[sundayactive]" class="w4c-day-active" <?php if($widget['tod']['sundayactive']) echo 'checked';?>/></td>
                <td id="w4c-tod-sunday">
                  <span class="w4c-slider-label"></span>
                  <span class="w4c-slider2-label"></span>
                  <input type="hidden" name="w4c-tod[sunday0]" class="w4c-tod0" value="<?php echo $widget['tod']['sunday0']?>">
                  <input type="hidden" name="w4c-tod[sunday1]" class="w4c-tod1" value="<?php echo $widget['tod']['sunday1']?>">
                  <input type="hidden" name="w4c-tod[sunday2]" class="w4c-tod2" value="<?php echo $widget['tod']['sunday2']?>">
                  <input type="hidden" name="w4c-tod[sunday3]" class="w4c-tod3" value="<?php echo $widget['tod']['sunday3']?>">
                  <div class="slider"></div>
                  <div class="slider2"></div>
                </td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-tod-message">Message hors horaire: </label></td>
                <td><textarea id="w4c-tod-message" name="w4c-tod-message" cols="30" rows="5" class="widefat"><?php echo $widget['tod-message']?></textarea></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-callback-email">Email de callback : </label></td>
                <td><input type="text" id="w4c-callback-email" name="w4c-callback-email" value="<?php echo $widget['callback-email']?>" class="widefat" /></td>
              </tr>
              <tr valign="top">
                <td scope="row"><label for="w4c-type">Type : </label></td>
                <td>
                  <input type="radio" id="w4c-type" name="w4c-type" value="notif" class="widefat" <?php if($widget['button-type'] == 'notif') echo "checked"?> /> Fenetre de notification
                  <input type="radio" id="w4c-type" name="w4c-type" value="btn" class="widefat" <?php if($widget['button-type'] == 'btn') echo "checked"?>/> Bouton
                  <input type="radio" id="w4c-type" name="w4c-type" value="dev-mode" class="widefat" <?php if($widget['button-type'] == 'dev-mode') echo "checked"?>/> Mode développeur 
                </td>
              </tr>
              <tr valign="top" class="w4c-display-header-wrap">
                <td scope="row" colspan="2" class="table-title">Header</td>
              </tr>
              <tr valign="top" class="w4c-display-header-wrap">
                <td scope="row"><label for="w4c-header-bg-color">Couleur du fond : </label></td>
                <td><input type="text" id="w4c-header-bg-color" name="w4c-header-bg-color" value="<?php echo $widget['button-header-bg-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-header-wrap">
                <td scope="row"><label for="w4c-header-color">Couleur du texte: </label></td>
                <td><input type="text" id="w4c-header-color" name="w4c-header-color" value="<?php echo $widget['button-header-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-header-wrap">
                <td scope="row"><label for="w4c-header-text">Texte : </label></td>
                <td><input type="text" id="w4c-header-text" name="w4c-header-text" value="<?php echo $widget['button-header-text']?>" class="widefat" /></td>
              </tr>
              <tr valign="top" class="w4c-display-content-wrap">
                <td scope="row"><label for="w4c-header-icon-active">Icone téléphone : </label></td>
                <td><input type="checkbox" id="w4c-header-icon-active" name="w4c-header-icon-active" value="1" class="widefat" <?php if($widget['button-header-icon-active']) echo 'checked'; ?>/></td>
              </tr>
              <tr valign="top" class="w4c-display-content-wrap">
                <td scope="row" colspan="2" class="table-title">Contenu de la fenetre</td>
              </tr>
              <tr valign="top" class="w4c-display-content-wrap">
                <td scope="row"><label for="w4c-content-bg-color">Couleur du fond : </label></td>
                <td><input type="text" id="w4c-content-bg-color" name="w4c-content-bg-color" value="<?php echo $widget['button-content-bg-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-content-wrap">
                <td scope="row"><label for="w4c-content-color">Couleur du texte : </label></td>
                <td><input type="text" id="w4c-content-color" name="w4c-content-color" value="<?php echo $widget['button-content-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-content-wrap">
                <td scope="row"><label for="w4c-content-text">Texte : </label></td>
                <td><textarea name="w4c-content-text" id="w4c-content-text" class="widefat"><?php echo $widget['button-content-text']?></textarea></td>
              </tr>
              <tr valign="top" class="w4c-display-header-wrap">
                 <td scope="row"><label for="w4c-content-img">Image :</label><br />
                    <small>Pour insérer une image personnalisée,<br/>
                    veuillez vous rendre sur le backoffice<br/> 
                    de Widget4Call https://w4c.widget4call.fr</small>
                  </td>
                 <td>
                    <ul>
                      <li>
                        <img class="default-agent" alt="icon1" src="<?php echo plugins_url( 'assets/img/agent1.png', __FILE__ ); ?>">
                        <input type="radio" value="agent1.png" class="agent-logo widefat" name="w4c-content-img"
                        <?php if($widget['button-content-img'] == 'agent1.png') echo "checked"; ?> > 
                      </li>
                      <li>
                        <img class="default-agent" alt="icon2" src="<?php echo plugins_url( 'assets/img/agent2.png', __FILE__ ); ?>">
                        <input type="radio" value="agent2.png" class="agent-logo widefat" name="w4c-content-img"
                        <?php if($widget['button-content-img'] == 'agent2.png') echo "checked"; ?> >
                      </li>
                      <li>
                        <img class="default-agent" alt="icon2" src="<?php echo plugins_url( 'assets/img/agent3.png', __FILE__ ); ?>">
                        <input type="radio" value="agent3.png" class="agent-logo widefat" name="w4c-content-img"
                        <?php if($widget['button-content-img'] == 'agent3.png') echo "checked"; ?> >
                      </li>
                      <li>
                        <img class="default-agent" alt="icon2" src="<?php echo plugins_url( 'assets/img/agent4.png', __FILE__ ); ?>">
                        <input type="radio" value="agent4.png" class="agent-logo widefat" name="w4c-content-img"
                        <?php if($widget['button-content-img'] == 'agent4.png') echo "checked"; ?> >
                      </li>
                    </ul>
                    <input type="hidden" name="w4c-content-img-dir" value="<?php echo  $widget['button-content-img-dir']; ?>" />
                    <input type="hidden" name="w4c-content-img-default" value="<?php echo  $widget['button-content-img']; ?>" >
                  </td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row" colspan="2" class="table-title">Widget</td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row"><label for="w4c-size">Taille : </label></td>
                <td>
                  <input type="radio" id="w4c-size" name="w4c-size" value="xs" class="widefat" <?php if($widget['button-size'] == 'xs') echo 'checked'?>/> Mini
                  <input type="radio" id="w4c-size" name="w4c-size" value="sm" class="widefat" <?php if($widget['button-size'] == 'sm') echo 'checked'?>/> Petit
                  <input type="radio" id="w4c-size" name="w4c-size" value="normal" class="widefat" <?php if($widget['button-size'] == 'normal') echo 'checked'?>/> Moyen
                  <input type="radio" id="w4c-size" name="w4c-size" value="lg" class="widefat" <?php if($widget['button-size'] == 'lg') echo 'checked'?>/> Large
                </td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row"><label for="w4c-color">Couleur de fond : </label></td>
                <td><input type="text" id="w4c-color" name="w4c-color" value="<?php echo $widget['button-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row"><label for="w4c-text-color">Couleur du Text : </label></td>
                <td><input type="text" id="w4c-text-color" name="w4c-text-color" value="<?php echo $widget['button-text-color']?>" class="widefat input-color" /></td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row"><label for="w4c-icon-active">Icone téléphone : </label></td>
                <td><input type="checkbox" id="w4c-icon-active" name="w4c-icon-active" value="1" class="widefat" <?php if($widget['button-icon-active']) echo "checked"?> /></td>
              </tr>
              <tr valign="top" class="w4c-display-btn-wrap">
                <td scope="row"><label for="w4c-text">Texte : </label></td>
                <td><textarea name="w4c-text" id="w4c-text" class="widefat"><?php echo $widget['button-text']?></textarea></td>
              </tr>
              <tr valign="top" class="w4c-btn-result">
                <td scope="row"><label for="w4c-text">Résultat : </label></td>
                <td><span id="button-display"></span></td>
              </tr>
              <tr valign="top" class="w4c-dev-mode">
              <?php $dev_mode_link = 'admin.php?page=w4c_devmode&_id='.$widget['_id']; ?>
                <td scope="row"><label for="w4c-text">Lien HTTP pour la page de Mode développeur : </label></td>
                <td><a href="<?php echo admin_url($dev_mode_link);  ?>">Mode développeur</a></td>
              </tr>
            </table>
            <?php submit_button('Enregistrer'); ?>
          </form>
          <div class="hide trad" style="display:none">
            <!-- <span id="notif2Call">Depuis votre ordinateur</span> -->
            <span id="notif2Recall">On vous rappelle</span>
            <span id="notif2CallHover">Activez votre micro et vos hauts parleurs</span>
            <span id="notif2RecallHover">Renseignez votre numéro pour être rappelé</span>
          </div>
          <?php 
        } else{ ?>
          <p>Vous devez tout d'abord renseigner votre clé Widget4Call : <a href="<?php echo admin_url('admin.php?page=widget4call')?>">cliquez ici</a></p><?php
        } ?>
      </div>
    </div> <?php
  }

  public static function process_action(){
    wp_enqueue_style('jquery-style', plugins_url( '/assets/css/jquery-ui-smoothness.css', __FILE__));
    
    Widget4Call_Plugin::getUser();
    $w4c_private_key = get_option('w4c_private_key');
    if(!empty($w4c_private_key)){
      global $wpdb;
      
      if(isset($_SESSION['w4c-flash'])){
        if($_SESSION['w4c-flash'] == 'success')
          add_settings_error('w4cAddWidget', 'settings_updated', 'Widget sauvegardé.' ,'updated');
        unset($_SESSION['w4c-flash']);
      }
      
      if (isset($_POST['w4c-name'])) {

        $params = array(
          'name'                      => stripslashes($_POST['w4c-name']),
          'phone-display'             => $_POST['w4c-phone-display'],
          'phone-customer-display'    => $_POST['w4c-phone-customer-display'],
          'pa-message'                => stripslashes($_POST['w4c-pa-message']),
          'strategy'                  => $_POST['w4c-strategy'],
          'destinations'              => $_POST['w4c-destinations'],
          'timeouts'                  => $_POST['w4c-timeouts'],
          'immediat-recall'           => true,
          'tod-active'                => $_POST['w4c-tod-active'],
          'tod'                       => $_POST['w4c-tod'],
          'tod-message'               => stripslashes($_POST['w4c-tod-message']),
          'callback-email'            => $_POST['w4c-callback-email'],
          'button-type'               => $_POST['w4c-type'],
          'button-header-bg-color'    => $_POST['w4c-header-bg-color'],
          'button-header-color'       => $_POST['w4c-header-color'],
          'button-header-text'        => stripslashes($_POST['w4c-header-text']),
          'button-content-text'       => stripslashes($_POST['w4c-content-text']),
          'button-content-color'      => $_POST['w4c-content-color'],
          'button-content-bg-color'   => $_POST['w4c-content-bg-color'],
          'button-size'               => $_POST['w4c-size'],
          'button-text'               => stripslashes($_POST['w4c-text']),
          'button-text-color'         => $_POST['w4c-text-color'],
          'button-color'              => $_POST['w4c-color'],
          'button-header-icon-active' => $_POST['w4c-header-icon-active'],
          'button-icon-active'        => $_POST['w4c-icon-active'],
          'button-content-img'        => $_POST['w4c-content-img']?$_POST['w4c-content-img']:$_POST['w4c-content-img-default'],
          'button-content-img-dir'    => $_POST['w4c-content-img']?'img/': $_POST['w4c-content-img-dir']
        );
        $url ='https://w4c.widget4call.fr/fr/wp/'.get_option('w4c_private_key').'/widgets';
        if(!empty($_POST['_id'])){
          $url = 'https://w4c.widget4call.fr/fr/wp/'.get_option('w4c_private_key').'/widgets/'.$_POST['_id'];
          $params['id'] = $_POST['_id'];
        }
        $response = wp_remote_post($url, array('body' => $params));
        $response = json_decode(wp_remote_retrieve_body($response));
        if($response->status == 'ok'){
          if(empty($_POST['_id'])){
            $row = $wpdb->query(
              $wpdb->prepare("INSERT INTO {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." (name, _id, type, code) Values (%s, %s, %s, %s)",$_POST['w4c-name'],$response->id,$_POST['w4c-type'],$response->code)
            );
          } else {

            $row = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." SET name='%s',type='%s', code='%s' where _id ='%s';",$_POST['w4c-name'],$_POST['w4c-type'],$response->code
              , $response->id));
          }
          if($row || !empty($_POST['_id'])){
            $id = ($wpdb->insert_id == 0)? $_GET['id'] : $wpdb->insert_id;
            $_SESSION['w4c-flash'] = 'success';
            wp_redirect(admin_url('admin.php?page=w4c_widget_form&id='.$id));
          }else
            add_settings_error('w4cAddWidget', 'settings_updated', 'Une erreur est survenue.' ,'error');
        } else {
          $errorMsg = '';
          foreach ($response->errors as $error) {
            $errorMsg .= $error.'<br/>';
          }
          add_settings_error('w4cAddWidget', 'settings_updated', 'Une erreur est survenue : <br/>'.$errorMsg ,'error');
        }
      } if(isset($_GET['id']) && !empty($_GET['id'])){
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE id = '%d';", $_GET['id']),ARRAY_A);
        if($row){
          $response = wp_remote_get('https://w4c.widget4call.fr/fr/wp/'.get_option('w4c_private_key').'/widgets/'.$row['_id']);
          $response = json_decode(wp_remote_retrieve_body($response));
          if($response->status == 'ok'){
            $array = get_object_vars($response->data);
            $array['tod'] = get_object_vars($array['tod']);
            $array['_id'] = $array['_id']->{'$id'};
            Widget4CallFormPage::$widget = $array;
          }
        }
      }
    }
  }
}
