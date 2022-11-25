jQuery( document ).ready( function (e) {

    jQuery("#add_new_btn").on("click",function(event){
        jQuery(".crud-list-container").hide();
        jQuery(".form-container").show();
    });

    jQuery("#form-cancel").on("click",function(event){
        event.preventDefault();
        jQuery("#crud_form").trigger("reset");

        jQuery(".media-field input").prop("disabled", false);
        jQuery(".media-field").show();
        jQuery(".image_preview").hide();
        jQuery("#form-submit,.form-head").html("Add New");

        jQuery(".crud-list-container").show();
        jQuery(".form-container").hide();
    });

    jQuery(".post-edit").on("click",function(event){
        let edit_id = jQuery(this).attr("data-id");
        let title = jQuery("[data-id='"+edit_id+"'].post-title").html();
        let desc = jQuery("[data-id='"+edit_id+"'].post-desc").html();
        let image = jQuery(".post-image img[data-id='"+edit_id+"']").attr('src');

        jQuery("#f_id").val( edit_id );
        jQuery("#f_title").val( title );
        jQuery("#f_description").val( desc );
        jQuery("#f_media_src").attr( "src", image );

        jQuery(".media-field input").prop("disabled", true);
        jQuery(".media-field").hide();

        jQuery("#form-submit,.form-head").html("Update");

        jQuery(".image_preview").show();
        jQuery(".crud-list-container").hide();
        jQuery(".form-container").show();
    });

    jQuery(".post-delete").on("click",function(event){
        let delete_id = jQuery(this).attr("data-id");

        if (confirm("Can I delete this post?") == true) {
            jQuery.ajax({
                url: "./deletePost.php",
                type: "POST",
                data:  {delete_id:delete_id},
                dataType: "json",
                success: function(data) {
                    if( data.message == "success" ) {
                        location.reload();
                    } else {
                        alert( data.reason );
                    }
                },
            });
        }
    });

    jQuery("#crud_form").on("submit",function(event){
        event.preventDefault();

        let error_status = false;
        jQuery(".error-fields, .error-fields-media").removeClass("error-fields").removeClass("error-fields-media");
        let title = jQuery("#f_title");
        if( title.val() == "" ) {
            title.addClass("error-fields");
            error_status = true;
        }

        let description = jQuery("#f_description");
        if( description.val() == "" ) {
            description.addClass("error-fields");
            error_status = true;
        }

        if( jQuery('#f_id').val() == 0 ) {
            let media = jQuery('#f_media');
            if( media.get(0).files.length === 0 ) {
                media.addClass("error-fields-media");
                error_status = true;
            }
        }

        if(!error_status) {
            jQuery.ajax({
                url: (jQuery('#f_id').val() == 0)?"./addNewPost.php":"./updatePost.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType: "json",
                beforeSend : function() {
                    jQuery("#form-submit").prop("disabled",true);
                    jQuery("#form-submit").html("<img src='./images/loader.png' class='loader-gif'/>");
                },
                success: function(data) {
                    if( data.message == "success" ) {
                        jQuery("#crud_form").trigger("reset");
                        location.reload();
                    } else {
                        alert( data.reason );
                    }
                    jQuery("#form-submit").html((jQuery('#f_id').val() == 0)?"Add New":"Update");
                    jQuery("#form-submit").prop("disabled",false);
                },
                error: function(e) {
                    jQuery("#form-submit").html((jQuery('#f_id').val() == 0)?"Add New":"Update");
                    jQuery("#form-submit").prop("disabled",false);
                }
            });
        }
    });
});