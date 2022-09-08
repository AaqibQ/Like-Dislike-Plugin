function aaqib_like_btn_ajax(userID , postID){

    var post_id =  postID ;
    var user_id =  userID ;

    // alert(postID);
        jQuery.ajax({
            url : likeDislike_ajax_url.ajax_url,
            type : 'post',
            data : {
                action : 'like_btn_ajax_action',
                pid : post_id,
                uid : user_id
            },
            success : function ( response ) {
                alert (response);
                // jQuery ("#responsce_id span").html(response);
                
            }
        });

}

function aaqib_dislike_btn_ajax(userID , postID){

    var post_id =  postID ;
    var user_id =  userID ;

//   alert (likeDislike_ajax_url.ajax_url);
        jQuery.ajax({
            url : likeDislike_ajax_url.ajax_url,
            type : 'post',
            data : {
                action : 'dislike_btn_ajax_action',
                pid : post_id,
                uid : user_id
            },
            success : function ( response ) {
                // alert (response);
                jQuery ("#responsce_id span").html(response);
            }
        });
        // terst 

}