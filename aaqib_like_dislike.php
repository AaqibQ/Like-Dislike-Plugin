<?php 

/**
 * Plugin Name:       Post Like Dislike
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Aaqib Ali
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

// if ( ! defined( 'ABSPATH' ) ) { 
// 	exit; // Exit if accessed directly
// }

function my_plugin_activate() {

    $fields = get_option('my_fields');
    if (empty($lbl) || 1 == 1) { 
        $fields = array(
            'label' => 'Like',
            'name' => 'Ali',
            'id' => '1'
        );
        update_option('my_fields', $fields);
    }
    
         create_table_like();
         create_table_dislike();
    /* activation code here */
  }

register_activation_hook( __FILE__, 'my_plugin_activate' );

function create_table_like(){
    global $wpdb;
    $table_name = $wpdb->prefix . "like_table"; 
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      user_id mediumint(9) NOT NULL,
      post_id mediumint(9) NOT NULL,
      like_count mediumint(9) NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}
function create_table_dislike(){
    global $wpdb;
    $table_name = $wpdb->prefix . "dislike_table"; 
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      user_id mediumint(9) NOT NULL,
      post_id mediumint(9) NOT NULL,
      dislike_count mediumint(9) NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

}


class LikeDislike{

    public function __construct()
    {
        $this->display_custom_posts_constants();
        add_action( 'init', array($this, 'display_blog_posts_text_domain')); // for text domain
        include( AaLikeDislike_plugin_DIR . 'connection/connection.php');
        include( AaLikeDislike_plugin_DIR . 'inc/btn.php');  

                                    //    ajax code 

        add_action('wp_ajax_like_btn_ajax_action' , array($this, 'like_btn_ajax_action'));
        do_action( 'wp_ajax_nopriv_like_btn_ajax_action' , array($this, 'like_btn_ajax_action'));

        add_action('wp_ajax_dislike_btn_ajax_action' , array($this, 'dislike_btn_ajax_action'));
        do_action( 'wp_ajax_nopriv_dislike_btn_ajax_action' , array($this, 'dislike_btn_ajax_action'));
     
        
        
    }
    public function display_blog_posts_text_domain() {
            load_plugin_textdomain('display-custom-posts', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        
    }
    function display_custom_posts_constants(){

        if ( !defined( 'WPINC' ) ) { 
            die; // Exit if accessed directly
        }
        
        
        if ( !defined( 'AaLikeDislike_plugin_version' ) ) { 
            define('AaLikeDislike_plugin_version' , '1.0.0');
        }
        
        
        if ( !defined( 'AaLikeDislike_plugin_DIR' ) ) { 
            define('AaLikeDislike_plugin_DIR' , plugin_dir_path(__FILE__));
        }

        if ( !defined( 'AaLikeDislike_plugin_url' ) ) {
            define( 'AaLikeDislike_plugin_url', plugin_dir_url( __FILE__ ) );
        }

        
        if ( ! defined( 'PLUGIN_FILE' ) ) {
            define( 'PLUGIN_FILE',  __FILE__  );
        }

        if ( !function_exists('my_plugin_function')) {
            function my_plugin_function(){
        
            }
        }


    }



    function like_btn_ajax_action(){

        global $wpdb;
        $table_name = $wpdb->prefix . "like_table"; 
        $disliketable_name = $wpdb->prefix . "dislike_table"; 

        // if(isset($_POST['pid']) && isset($_POST['uid'])){

        //     $userId = $_POST['uid'] ;
        //     $postId = $_POST['pid'] ;
            
        //     $wpdb->query($wpdb->prepare("DELETE FROM $disliketable_name WHERE user_id=$userId AND post_id=$postId"));
        //     $check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_id=$userId AND post_id='$postId' AND like_count=1");
            

        //     // echo $count_like ;          
        //     if ($check_like > 0 ) {        
        //         echo 'Sorry But You already Liked it' ;
        //     }
        //     else {


        //         $data = array( 'post_id' => $_POST['pid'] , 'user_id' => $_POST['uid'] , 'like_count' => 1);
        //         $format = array('%d', '%d', '%d');
                
        //         $wpdb->insert($table_name,$data,$format);
        
        //         if($wpdb->insert_id) {
        //             echo 'Thnkyou For Loving This Post';
        //         }

        //     }
        $count_like = $wpdb->get_results( "SELECT COUNT(like_count) FROM like_table"); 
        $count_dislike = $wpdb->get_results( "SELECT COUNT(like_count) FROM dislike_table"); 

        $final = $count_like.'_'.$count_dislike;
        echo $count_like;


        wp_die();

    }

    function dislike_btn_ajax_action(){

        // echo 'hello';
        global $wpdb;
        $table_name = $wpdb->prefix . "dislike_table"; 
        $liketable_name = $wpdb->prefix . "like_table"; 
        if(isset($_POST['pid']) && isset($_POST['uid'])){

            $userId = $_POST['uid'] ;
            $postId = $_POST['pid'] ;

            $wpdb->query($wpdb->prepare("DELETE FROM $liketable_name WHERE user_id=$userId AND post_id=$postId"));
            $check_dislike = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_id=$userId AND post_id='$postId' AND dislike_count=1");
            
            if ($check_dislike > 0) {
                echo 'Sorry But You already disiked it' ;
            }
            else {
                $data = array( 'post_id' => $_POST['pid'] , 'user_id' => $_POST['uid'] , 'dislike_count' => 1);
                $format = array('%d', '%d', '%d');
                $wpdb->insert($table_name,$data,$format);
    
                if($wpdb->insert_id) {
                    echo 'Thnkyou , well improved Soon';
                }
            }
        }

        $count_like = $wpdb->get_var( "SELECT COUNT(like_count) FROM like_table"); 
        $count_dislike = $wpdb->get_var( "SELECT COUNT(like_count) FROM dislike_table"); 

        $final = $count_like.'_'.$count_dislike;
        echo $final;
   
        wp_die();

    }
   




}

new LikeDislike();

