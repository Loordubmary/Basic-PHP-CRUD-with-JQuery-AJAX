<?php

if( $_POST['delete_id'] != "" ) {
    include "config.php";
    include "crud_model.php";

    $postCrud = new PostCrud( $_DB_CONFIG );
    $delete_id = $_POST['delete_id'];
    
    $get_image_info = $postCrud->getById( $delete_id );
    $unlink_image = $get_image_info[0]['image'];
    unlink( $unlink_image );
    
    $postCrud->deleteById( $delete_id );


    echo json_encode( array(
        "message" => "success",
    ) );
} else {
    echo json_encode( array(
        "message" => "invalid request",
    ) );
}
exit();