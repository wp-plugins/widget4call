<?php
class Widget4CallCdrPage
{
  public function __construct(){}

	public static function html_w4c_cdrpage(){
    ?>
    <div id="w4c" class="wrap">
      <h2>Widget4Call for WordPress</h2>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title() ?></h3>
		    <?php
        $w4c_private_key = get_option('w4c_private_key');
        if(!empty($w4c_private_key)){
          $response = wp_remote_get('https://w4c.widget4call.fr/wp/'.get_option('w4c_private_key').'/cdrs');
          $response = json_decode(wp_remote_retrieve_body($response));
          if($response->status == 'ok'){
            if(count($response->data) == 0):
              ?><p>Vous n'avez pas encore d'appels</p><?php
            else:?>
              <table class='widefat fixed' cellspacing='0'>
                <thead>
                  <tr>
                    <th class="manage-column column-columnname" scope="col">Nom du Widget</th>
                    <th class="manage-column column-columnname num" scope="col">Numéro appelé</th>
                    <th class="manage-column column-columnname num" scope="col">Numéro appelant</th>
                    <th class="manage-column column-columnname" scope="col">Heure</th>
                    <th class="manage-column column-columnname" scope="col">Etat</th>
                    <th class="manage-column column-columnname" scope="col">Durée</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="manage-column column-columnname" scope="col">Nom du Widget</th>
                    <th class="manage-column column-columnname num" scope="col">Numéro appelé</th>
                    <th class="manage-column column-columnname num" scope="col">Numéro appelant</th>
                    <th class="manage-column column-columnname" scope="col">Heure</th>
                    <th class="manage-column column-columnname" scope="col">Etat</th>
                    <th class="manage-column column-columnname" scope="col">Durée</th>
                  </tr>
                </tfoot>
                <?php
                foreach ($response->data as $key => $call) { ?>
                  <tbody>
                    <tr>
                      <td><?php echo $call->nameHtml ?></td>
                      <td><?php echo $call->to ?></td>
                      <?php if($call->from == 'anonymous')
                        echo "<td>Web</td>";
                      else
                        echo "<td>$call->from</td>"; ?>
                      <td><?php echo date('d-m-Y h:i:s',$call->date->sec)?></td>
                      <td><?php echo $call->status ?></td>
                      <td><?php echo date('H\\h i\\m s\\s', $call->duration) ?></td>
                    </tr>
                  </tbody>
                  <?php
                }
              echo '</table>';
           endif;
          } else
            echo $response->status;
        } else { ?>
          <p>Vous devez tout d'abord renseigner votre clé Widget4Call : <a href="<?php echo admin_url('admin.php?page=widget4call')?>">cliquez ici</a></p><?php
        } ?>
      </div>
    </div> <?php
  }

  public static function process_action(){
    Widget4Call_Plugin::getUser();
  }
}