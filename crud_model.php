<?php
class PostCrud {
    private $dbcon;
    private $dbconStatus;

    function __construct( $dbInfo ) {
        try {
            $this->dbcon = new mysqli( $dbInfo["db_host"], $dbInfo["db_username"], $dbInfo["db_password"], $dbInfo["db_name"] );
            if( $this->dbcon->connect_error ) {
                $this->dbconStatus = false;
            } else {
                $this->dbconStatus = true;
            }
        } catch( Exception $e) {
            $this->dbconStatus = false;
        }
    }

    public function getDBStatus() {
        return $this->dbconStatus;
    }

    public function addNew( $data ) {

        $query_sql = "INSERT INTO `posts` ( `title`, `description`, `image`, `created_at`, `updated_at` ) VALUES ( '".$data['title']."', '".$data['description']."', '".$data['image']."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";

        if ( $this->dbcon->query( $query_sql ) === TRUE ) {
            return $this->dbcon->insert_id;
        } else {
            return false;
        }
    }

    public function updateById( $id, $data ) {
        $values = array();
        foreach ($data as $key => $value) {
            $values[]= " ".$key."='".$value."'";
        }
        $values[]= " `updated_at`='".date("Y-m-d H:i:s")."'";
        
        $set_data = implode( ",", $values );

        $query_sql = "UPDATE `posts` SET ".$set_data." WHERE `id`=".$id;
        if ( $this->dbcon->query( $query_sql ) === TRUE ) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll( ) {
        $query_sql = "SELECT * FROM `posts` ORDER BY `id` DESC";
        $posts = $this->dbcon->query($query_sql);
        $postsInfo = array();

        if ( $posts->num_rows > 0 ) {
            while( $post = $posts->fetch_assoc() ) {
                $postsInfo[] = $post;
            }            
            return $postsInfo;
        } else {
            return $postsInfo;
        }
    }

    public function getById( $id ) {
        $query_sql = "SELECT * FROM `posts` WHERE `id` = $id ORDER BY `id` DESC";
        $posts = $this->dbcon->query($query_sql);
        $postsInfo = array();

        if ( $posts->num_rows > 0 ) {
            while( $post = $posts->fetch_assoc() ) {
                $postsInfo[] = $post;
            }            
            return $postsInfo;
        } else {
            return $postsInfo;
        }
    }

    public function deleteById( $id ) {
        $query_sql = "DELETE FROM `posts` WHERE `id`=".$id;

        if ( $this->dbcon->query( $query_sql ) === TRUE ) {
            return true;
        } else {
            return false;
        }
    }
}