<?php

if( !empty($_POST['f_id'] ) || !empty($_POST['f_title'] ) || !empty($_POST['f_description']) ) {
    include "config.php";
    include "crud_model.php";

    $postCrud = new PostCrud( $_DB_CONFIG );

    $id = (int) $_POST['f_id'];
    $title = filter_var( $_POST['f_title'], FILTER_SANITIZE_STRING);
    $description = filter_var( $_POST['f_description'], FILTER_SANITIZE_STRING);

    if( $id > 0 ) {
        $postCrud->updateById( 
            $id,
            array(
                "title" => $title,
                "description" => $description,
            )
        );
        echo json_encode(
            array(
                "message" => "success"
            )
        );
    } else {
        echo json_encode(
            array(
                "message" => "failed",
                "reason" => "Invalid request",
            )
        );
    }
} else {
    echo json_encode(
        array(
                "message" => "failed",
                "reason" => "Invalid request",
        )
    );
}
exit;

?>