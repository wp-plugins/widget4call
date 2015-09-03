<?php
class Widget4CallListPage {
  public function __construct(){}

	public static function html_w4c_widgetspage(){
    global $wpdb; ?>
    <div id="w4c" class="wrap">
      <h2>Widget4Call for WordPress</h2>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title() ?> <a href="<?php echo admin_url('admin.php?page=w4c_widget_form')?>" class="add-new-h2">Ajouter un widget</a></h3>
		    <?php
        $w4c_private_key = get_option('w4c_private_key');
        if(!empty($w4c_private_key)) {
          $response = wp_remote_get('https://w4c.widget4call.fr/wp/'.get_option('w4c_private_key').'/widgets');
          $response = json_decode(wp_remote_retrieve_body($response));

          if($response->status == 'ok'){
            if(empty($response->data)){
              ?><p>Vous n'avez pas crée de widgets.</p><?php
            } else{ ?>
              <table class='widefat fixed' cellspacing='0'>
                <thead>
                  <tr>
                    <th class="manage-column column-columnname" scope="col">Nom du Widget</th>
                    <th class="manage-column column-columnname" scope="col">Shortcode</th>
                    <th class="manage-column column-columnname" scope="col">Page de Test</th>
                    <th class="manage-column column-columnname" scope="col">Destinations</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="manage-column column-columnname" scope="col">Nom du Widget</th>
                    <th class="manage-column column-columnname" scope="col">Shortcode</th>
                    <th class="manage-column column-columnname" scope="col">Page de Test</th>
                    <th class="manage-column column-columnname" scope="col">Destinations</th>
                  </tr>
                </tfoot>
                <tbody><?php
                  foreach($response->data as $widget){ ?>
                    <tr><?php
                      $row = $wpdb->get_row($wpdb->prepare("SELECT id, _id, name FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE _id = '%s'", $widget->_id), OBJECT);
                      if($widget->type == 'dev-mode') { ?>
                          <td>
                          <strong><a href="<?php echo admin_url('admin.php?page=w4c_widget_form&id='.$row->id)?>" class="row-title"><?php echo $widget->name; ?></a></strong>
                          <div class="row-actions">
                            <span class="edit"><a href="<?php echo admin_url('admin.php?page=w4c_widget_form&id='.$row->id)?>">Modifier</a></span> |
                            <span class="delete"><a href="<?php echo admin_url('admin.php?page=w4c_widget_delete&_id='.$widget->_id)?>">Supprimer</a></span>
                          </div>
                        </td>
                        <td></td>
                        <td><a href="<?php echo admin_url('admin.php?page=w4c_devmode&_id='.$widget->_id)?>">Test widget</a></td>
                      <?php } elseif(is_null($row)){?>
                        <td>
                          <strong><?php echo $widget->name; ?></strong>
                          <div class="row-actions">
                            <span class="edit"><a href="<?php echo admin_url('admin.php?page=w4c_add_external_widget&_id='.$widget->_id)?>">Générer shortcode</a></span> |
                          </div>
                        </td>
                        <td><a href="<?php echo admin_url('admin.php?page=w4c_add_external_widget&_id='.$widget->_id)?>">Générer shortcode</a></td>
                        <td></td>
                        <?php
                      } else{ ?>
                        <td>
                          <strong><a href="<?php echo admin_url('admin.php?page=w4c_widget_form&id='.$row->id)?>" class="row-title"><?php echo $widget->name; ?></a></strong>
                          <div class="row-actions">
                            <span class="edit"><a href="<?php echo admin_url('admin.php?page=w4c_widget_form&id='.$row->id)?>">Modifier</a></span> |
                            <span class="delete"><a href="<?php echo admin_url('admin.php?page=w4c_widget_delete&_id='.$widget->_id)?>">Supprimer</a></span>
                          </div>
                        </td>

                        <td><input type="text" readonly="readonly" value="[w4c id='<?php echo $row->id ?>']" class="input-shortcode"/></td>
                        <td></td>
                      <?php } ?>

                      <td><?php echo implode(' - ',$widget->destinations) ?></td>
                    </tr><?php
                  } ?>
                </tbody>
              </table> <?php
            }
          } else{}
        } else{ ?>
          <p>Vous devez tout d'abord renseigner votre clé Widget4Call : <a href="<?php echo admin_url('admin.php?page=widget4call')?>">cliquez ici</a></p><?php
        } ?>
      </div>
    </div> <?php
  }

  public static function process_action(){
    Widget4Call_Plugin::getUser();
    global $wpdb;
    $w4c_private_key = get_option('w4c_private_key');
    if(!empty($w4c_private_key)) {
      if(isset($_SESSION['w4c-flash'])){
        if($_SESSION['w4c-flash'] == 'deleted')
          add_settings_error('w4cDeleteWidget', 'settings_updated', 'Widget supprimé.','updated');
        if($_SESSION['w4c-flash'] == 'add')
          add_settings_error('w4cAddWidget', 'settings_updated', 'Widget ajouté.','updated');
        if($_SESSION['w4c-flash'] == 'error')
          add_settings_error('w4cAddWidget', 'settings_updated', 'Une erreur est survenue.','error');
        if($_SESSION['w4c-flash'] == 'already_exist')
          add_settings_error('w4cAddWidget', 'settings_updated', 'Widget existe déjà.','error');
        unset($_SESSION['w4c-flash']);
      }
      if(isset($_GET['page']) && $_GET['page'] == 'w4c_add_external_widget' && isset($_GET['_id']) && !empty($_GET['_id'])){
        $response = wp_remote_get('https://w4c.widget4call.fr/fr/wp/'.get_option('w4c_private_key').'/widgets/'.$_GET['_id']);          
        $response = json_decode(wp_remote_retrieve_body($response));
        if($response->status == 'ok'){
          $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE _id = '%s';", $_GET['_id']),ARRAY_A);
          if(!$row){
            $row = $wpdb->query(
              $wpdb->prepare("INSERT INTO {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." (name, _id, type, code) Values (%s, %s, %s, %s)",$response->data->name,$response->data->_id->{'$id'},$response->data->{'button-type'},$response->data->code)
            );
            if($row){
              $_SESSION['w4c-flash'] = 'add';
            }else
              $_SESSION['w4c-flash'] = 'error';
          } else
            $_SESSION['w4c-flash'] = 'already_exist';
        }else
          $_SESSION['w4c-flash'] = 'error';
        wp_redirect(admin_url('admin.php?page=w4c_widgets'));
      }
    }
  }

  public static function add_external_widget(){

  }
}