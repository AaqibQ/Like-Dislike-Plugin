<?php 



class DisplayButton{


    
	public function __construct() {
        
        add_filter('the_content' , array($this,'display_button_like_dislike' ));
        add_action( 'admin_menu', array($this, 'addMyAdminMenu' ));
        

        }




    function display_button_like_dislike($content){

        $get_like_label = get_option('like_option_group');
        $get_dislike_label = get_option('dislike_option_group');

        $user_id = get_current_user_id();
        $post_id = get_the_ID();


    


        $like_button_wrap = '<div class="wpac-button-container">';
        $like_button = '<a href="javacript:;" onclick="aaqib_like_btn_ajax('.$user_id.','.$post_id.')" class="butoon like_button"> '.$get_like_label.' </a>';
        $dislike_button = '<a href="javacript:;" onclick="aaqib_dislike_btn_ajax('.$user_id.','.$post_id.')" class="butoon dislike_button"> '.$get_dislike_label.' </a>';   
        $like_button_wrap_end = '</div>';

        $resposive_div_like = '<div id="responsce_id" class="mange_responsive_div"><span> </span></div>';
        $resposive_div_dislike = '<div id="responsce_id2" class="mange_responsive_div"><span> </span></div>';

        $content .= $like_button_wrap;
        $content .= $like_button;
        $content .= $dislike_button;
        $content .= $like_button_wrap_end;
        $content .= $resposive_div_like;
        $content .= $resposive_div_dislike;

        return $content;

    }

    function inside_html(){ 

        if(!is_admin()) {
            return;
        }
        if(isset($_POST['save_value'])) {
            
            $likes= $_POST['like']; 
            update_option('like_option_group', $likes);
    
             
            $dislikes= $_POST['dislike']; 
            update_option('dislike_option_group', $dislikes);
        }
    
    ?>
    <div class="wrap">
    <h1 class="wp-heading-inline"> <?= esc_html(get_admin_page_title()); ?> </h1>
    <?php settings_errors();?>
    <form action="" method="POST">   
               <?php 
    
                 $get_like_label = get_option('like_option_group');
                 $get_dislike_label = get_option('dislike_option_group');
               ?>
                <div class="col mb-3">
                <label>Like Label</label>
                <input type = "text" name="like" value="<?php echo   $get_like_label; ?>"></label>
                </div>
              
                <div class="col mb-3">
                <label>Dislike Label</label>
                <input type = "text" name="dislike" value="<?php echo  $get_dislike_label; ?>"></label>
                </div>
              
                <input type ="submit" name="save_value" > 
        
    </form>
    </div>
    
    <?php
    
       
    
    }
    
    function addMyAdminMenu(){
           
            add_menu_page(
                'Like Dislike',
                'Like Dislike',
                'manage_options',
                'like-dislike-slug',
                array($this, 'inside_html'),
                'dashicons-welcome-widgets-menus',
                1
            );
           
    
    
    }

}

new DisplayButton;

?>