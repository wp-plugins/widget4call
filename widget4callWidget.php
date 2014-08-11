<?php
class Widget4CallWidget extends WP_Widget {
  
  public function __construct(){
    parent::__construct('w4c_widget', 'Widget4Call', array('description' => 'Bouton d\'appels'));
  }

	public function widget($args, $instance){
    global $wpdb;
    echo $args['before_widget'];
    echo $args['before_title'];
    echo apply_filters('widget_title', $instance['title']);
    echo $args['after_title'];
    wp_enqueue_script('w4c_script', 'https://w4c.widget4call.fr/js/w4c.js', '', '1.0',true);
    $row = $wpdb->get_row($wpdb->prepare("SELECT id, type, code FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE id = '%s'", $instance['id']), OBJECT);
   if(!is_null($row) && ($row->type == "btn" || ($row->type == "notif" && Widget4Call_Plugin::$countNotif == 0 ))){
      if($row->type == "notif")
        Widget4Call_Plugin::$countNotif++;
      echo $row->code;
    }
    echo $args['after_widget'];
  }

  public function form($instance){
    global $wpdb;
    $id = isset($instance['id'])? $instance['id']: '';
    $title = isset($instance['title'])? $instance['title']: '';
    $row = $wpdb->get_results($wpdb->prepare("SELECT id, name FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE type = '%s'", 'btn'), OBJECT);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title')?>">Title</label>
      <input type="text" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" value="<?php echo $title;?>" class="widefat"><br/>
      <label for="<?php echo $this->get_field_id('id')?>">Widget</label>
      <select name="<?php echo $this->get_field_name('id')?>" id="<?php echo $this->get_field_id('id')?>" class="widefat">
      <?php
        foreach ($row as $widget) {
          if($id == $widget->id)
            echo "<option value='".$widget->id."' selected>".$widget->name."</option>";
          else
            echo "<option value='".$widget->id."'>".$widget->name."</option>"; 
        }
      ?>
      </select>
    </p> <?php
  }
}