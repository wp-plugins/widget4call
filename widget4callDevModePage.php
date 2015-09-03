<?php
class Widget4CallDevModePage
{
  public static $widget = array();

  public function __construct(){
        wp_enqueue_script('devmode-script', plugins_url( '/assets/js/devmode.js' , __FILE__ ),'', '1.0',true); 
          wp_enqueue_style('font-awesome', "http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
  }

	public static function html_w4c_devmodepage(){
    ?>
     <div id="w4c" class="wrap">
     <h2>Page de test de Widget4Call</h2>
     <div class="validation-error main-error"></div>
      <div id="w4c-content">
        <h3 class="w4c-admin-title"><?php echo get_admin_page_title()?></h3>
        Cette page vous permet de tester votre Widget.
        <form id="myForm" role="form">
          <div>
            <p>Vous pouvez composer votre propre formulaire de contact enrichi par un rappel immédiat, tous les paramètres ajoutés ici seront transmis à votre Widget et affichés dans la console du backoffice (<a href='https://w4c.widget4call.fr/fr/activecalls' id="active_call">https://w4c.widget4call.fr/fr/activecalls</a>).</p>
            <p>En fonction de la configuration choisie, vous pouvez notifier les appels dans Slack et mesurer l'activité de vos Widget dans votre compte Google Analytics.</p>
            <p>Le code source de cette page est disponible pour être intégré dans votre propre site web, n'hésitez pas à vous en inspirer !</p>
            <div class="param form-group">
              <label class="paramName" value="lastname">Nom (optionnel) :</label><input id="lastname" type="text" class="paramValue form-control" />
              <div class="validation-error"></div>
            </div>
            <div class="param form-group">
              <label class="paramName" value="firstname">Prénom (optionnel) :</label><input id="firstname" type="text" class="paramValue form-control" />
              <div class="validation-error"></div>
            </div>
            <div class="param">
              <label for="inputPhoneNumber">Numéro :</label>
              <input type="text" id="inputPhoneNumber" class="form-control" placeholder="ex: 06123456789">
              <div class="validation-error"></div>
              <button type="submit" class="btn btn-success">Etre rappelé maintenant</button>
            </div>
            <div>
              <p></p>
              <p>Vous pouvez ajouter des paramètres supplémentaires à votre formulaire afin d'enrichir les informations transmises à votre Widget d'appel.</p>
            </div>
            <div class="additional_parameters">
              <div>
                <button type="button" class="btn btn-default" id="add_param">Ajouter un paramètre</button>
              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text" class="paramValue" />
                <i class="fa fa-minus-circle"></i>
                <div class="validation-error"></div>

              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text"  class="paramValue" />
                <i class="fa fa-minus-circle"></i>
                <div class="validation-error"></div>
              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text" class="paramValue" />
                <i class="fa fa-minus-circle"></i> 
                <div class="validation-error"></div>
              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text" class="paramValue" />
                <i class="fa fa-minus-circle"></i>
                <div class="validation-error"></div>
              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text" class="paramValue" />
                <i class="fa fa-minus-circle"></i>
                <div class="validation-error"></div>
              </div>
              <div class="hidden_element param">
                <label>Name</label><input type="text" class="paramName" />
                <label>Value</label><input type="text" class="paramValue" />
                <i class="fa fa-minus-circle"></i>
                <div class="validation-error"></div>
              </div>
            </div>
          </p></div>

          <input type="hidden" id="widget-id" name="widget-id" value="<?php echo $_GET['_id']; ?>"></form>
          <input type="hidden" name="as_fid" value="JSCv50+C03evk1qlxXWc"></form>

          </div>
     </div>
    <?php

  }

  public static function process_action(){
    Widget4Call_Plugin::getUser();
    global $wpdb;
    // wp_redirect(admin_url('admin.php?page=w4c_devmode'));
  }
}