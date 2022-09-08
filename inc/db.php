<?php


defined('ABSPATH') || die('NICE TRY');

// register_activation_hook( __FILE__ , 'test' );
// function test(){
//     global $wpdb;
//     // $prifix = $wpdb->prefix;
//     $collate = $wpdb->get_charset_collate();
    
    
//     $sql = "CREATE TABLE `{$wpdb->prefix}likesdislikes` (
//         `id` int(255) NOT NULL AUTO_INCREMENT,
//         `post_id` int(255) NOT NULL,
//         `like` int(255) NOT NULL,
//         `dislike` int(255) NOT NULL,
//         `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//         PRIMARY KEY (`id`)
//       )" . $collate . ';';

//         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//  dbDelta($sql);

// }



// register_deactivation_hook('PLUGIN_FILE', function(){
//     global $wpdb;
//     // $prifix = $wpdb->prefix;
//     $sql = "DROP TABLE IF EXIST `{$wpdb->prefix}likesdislikes`;";
//     $wpdb->query($sql);

// });