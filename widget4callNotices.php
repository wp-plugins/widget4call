<?php
class Widget4CallNotices {
	public function __construct(){
		add_action('admin_notices', array($this,'notices_action'));
	}

	public function notices_action(){
		settings_errors();
	}
}