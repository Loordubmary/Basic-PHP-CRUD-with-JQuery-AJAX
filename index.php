<?php

include "config.php";
include "crud_model.php";

$postCrud = new PostCrud( $_DB_CONFIG );

if( $postCrud->getDBStatus() ) {
    include "crud_view.php";
    exit;
} else {
    echo "Database connection failed";
    exit;
}