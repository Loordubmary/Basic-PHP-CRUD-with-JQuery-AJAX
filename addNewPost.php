<?php
if( !empty($_POST['f_title'] ) || !empty($_POST['f_description']) || $_FILES['f_media']) {
    include "config.php";
    include "crud_model.php";

    $postCrud = new PostCrud( $_DB_CONFIG );

    $title = filter_var( $_POST['f_title'], FILTER_SANITIZE_STRING);
    $description = filter_var( $_POST['f_description'], FILTER_SANITIZE_STRING);

    $media_name = $_FILES['f_media']['name'];
    $media_tmp = $_FILES['f_media']['tmp_name'];
    $media_ext = strtolower(pathinfo($media_name, PATHINFO_EXTENSION));

    $media_new_name = date("YmdHis").'_'.$media_name;

    if( in_array( $media_ext, $_ACCEPTED_MEDIA_EXT ) ) { 
        $media_upload_path = $_MEDIA_UPLOAD_PATH.strtolower($media_new_name);
        if( move_uploaded_file( $media_tmp, $media_upload_path ) ) {
            $insert_id = $postCrud->addNew( array(
                "title" => $title,
                "description" => $description,
                "image" => $media_upload_path
            ));

            echo json_encode(
                array(
                    "message" => "success",
                    "new_id" => $insert_id
                )
            );
        } else {
            echo json_encode(
                array(
                    "message" => "failed",
                    "reason" => "Failed on image upload"
                )
            );
        }
    } else {
        echo json_encode(
            array(
                "message" => "failed",
                "reason" => "Please upload only jpeg, jpg, png"
            )
        );
    }

} else {
    echo json_encode(
        array(
            "message" => "Invalid request",
        )
    );
}
exit;
?>