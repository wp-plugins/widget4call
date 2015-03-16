<?php
class Widget4CallShortcode
{
	public function __construct(){
		add_shortcode('w4c', array($this,'w4c_shortcode'));
	}

	public function w4c_shortcode($atts, $content) {
		global $wpdb;
		$atts = shortcode_atts(array('id' => ''), $atts);
		if(!empty($atts['id'])){
			//Add Script
			wp_enqueue_script('w4c_script', 'https://w4c.widget4call.fr/js/w4c.js', '', '1.0',true);
			$row = $wpdb->get_row($wpdb->prepare("SELECT type, code FROM {$wpdb->prefix}".Widget4Call_Plugin::W4C_DB_WIDGET." WHERE id = '%s'", $atts['id']), OBJECT);
			if(!is_null($row) && ($row->type == "btn" || ($row->type == "notif" && Widget4Call_Plugin::$countNotif == 0 ))){
				if($row->type == "notif")
					Widget4Call_Plugin::$countNotif++;
				return $row->code;
			}
		}
	}
}