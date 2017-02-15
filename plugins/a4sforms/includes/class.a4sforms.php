<?php

class A4s_Forms_Activation {
	public static function activate() {
		setup_post_types();
		
	}
	
	public function setup_post_types() {
		register_post_type('a4sform', ['public' => 'true']);
	}
}