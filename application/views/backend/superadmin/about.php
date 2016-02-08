<div class="header-title">

</div>
<div class="content content--form">
    <form action="" method="POST" id="support">
        <div class="full-width">
            <ul>
                <?php if(isset($message_type)){ ?>
                    <li>
                        <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
                    </li>
                <?php }?>
                <li>
                    <label>About Us:</label>
                    <div class="has-editor"  style="border:0 none; box-shadow: none;">
                        <textarea id="editor" style="min-height: 400px" name="documentation"><?php echo $documentation->document; ?></textarea>
                    </div>
                    <div class="has-editor"  style="border:0 none; box-shadow: none;">
                        <textarea id="editor2" style="min-height: 400px" name="fr_documentation"><?php echo $documentation->fr_document; ?></textarea>
                    </div>
                </li>
                <li>
                    <label>Upload Image:</label>
                    <fieldset style="width: 190px; float:left;">
                        <input type="text" name="icon" value="Upload the image first and then copy me to use in page!" class="field-box" style="margin-bottom:20px;"/>
                        <img style="display: none; width:100px;" src="" />
                        <input type="button" class="button-box upload" id="icon" value="Upload image"/>
                    </fieldset>
                </li>
                <li>
                    <input type="submit" name="update" class="button-box edit" value="Save"/>
                </li>
            </ul>
        </div>
    </form>
</div>
<div style="display: none;">
    <form id="upload-files" action="<?php echo WEBSITE_URL;?>ajax/do_upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="userfile" id="userfile"/>
        <input type="submit" value="Add"/>
    </form>
</div>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js"></script>
<script src="<?php echo WEBSITE_URL;?>js/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );
    CKEDITOR.replace( 'editor2' );
    $('#upload-files').ajaxForm({
        beforeSend: function() {
            $(".overlay-loading").show();
        },
        complete: function(xhr) {
            $('input[name="'+title+'"]').val('<?php echo WEBSITE_URL; ?>uploads/'+xhr.responseText);
            $('input[name="'+title+'"]').siblings('img').attr('src','<?php echo WEBSITE_URL; ?>uploads/'+xhr.responseText);
            $('input[name="'+title+'"]').siblings('img').fadeIn(500);
            $(".overlay-loading").hide();
        }
    });
    $('#userfile').change(function(){
        $('#upload-files').submit();
    })
$(document).ready(function(){
    $('.upload').click(function(){
        title = $(this).attr('id');
        $('#userfile').click();
    })
})
</script>