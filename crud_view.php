<?php
$crudRecords = (array) $postCrud->getAll();
?>
<html>
    <head>
        <title>CRUD</title>
        <link rel="stylesheet" href="./style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="./script.js"></script>
    </head>
    <body>
        <div class="main-container">
            <div class="crud-list-container">
                <div class="list-head">
                    <div>CRUD LIST</div>
                    <div id="add_new_btn" class="add_new_btn">Add NEW</div>
                </div>
                <div class="list-container">
                    <?php
                        if( !empty( $crudRecords ) ) {
                            foreach ($crudRecords as $key => $value) {
                                ?>
                                <div class="list-items">
                                    <div class="post-image">
                                        <img width="50" data-id="<?php echo $value['id'];?>" src="./<?php echo $value['image']; ?>"/>
                                    </div>
                                    <div class="post-content">
                                        <p class="post-title" data-id="<?php echo $value['id'];?>"><?php echo $value['title']; ?></p>
                                        <p class="post-desc" data-id="<?php echo $value['id'];?>"><?php echo $value['description']; ?></p>
                                    </div>
                                    <div class="post-actions">
                                        <span class="post-edit" data-id="<?php echo $value['id'];?>">Edit</span>
                                        <span class="post-delete" data-id="<?php echo $value['id'];?>">Delete</span>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="no-records">
                                No Records!
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="form-container">
                <div class="form-head">
                    Add New
                </div>
                <form id="crud_form" class="crud_form" action="#" method="post">
                    <div class="form-field">
                        <label for="f_title">Title <span class="required">*</span></label>
                        <input type="text" id="f_title" name="f_title" required/>
                        <input type="hidden" id="f_id" name="f_id" value="0" />
                    </div>
                    <div class="form-field">
                        <label for="f_description">Description <span class="required">*</span></label>
                        <textarea id="f_description" rows="5" name="f_description" required></textarea>
                    </div>
                    <div class="form-field media-field">
                        <label for="f_media">Media <span class="required">*</span></label>
                        <input type="file" id="f_media" name="f_media" required/>
                    </div>
                    <div class="form-field image_preview">
                        <input type="image" id="f_media_src" disabled/>
                    </div>
                    <div class="form-field buttons">
                        <button id="form-cancel">Cancel</button>
                        <button id="form-submit" type="Submit">Add New</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>