<?php 

class Connection extends LikeDislike {

   public function __construct() { 
   		add_action('wp_enqueue_scripts', array($this, 'render_plugin_aasets_wp_enqueue_scripts'));   //for frontend
   
   }


   function render_plugin_aasets_wp_enqueue_scripts() {

       wp_enqueue_style('likeDislike_css', AaLikeDislike_plugin_url . 'assets/css/style.css');
       wp_enqueue_script('likeDislike_js', AaLikeDislike_plugin_url . 'assets/js/custom.js', array('jquery'), 1.0, true);
      
       wp_enqueue_script('likeDislike_ajax', AaLikeDislike_plugin_url . 'assets/js/ajax.js', array('jquery'), 1.0, true);
       wp_localize_script( 'likeDislike_ajax', 'likeDislike_ajax_url' , array(
            'ajax_url' => admin_url( 'admin-ajax.php' ) 
        ));
   
   }

}

new Connection();