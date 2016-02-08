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
                    <label>Documentation:</label>
                    <div class="has-editor"  style="border:0 none; box-shadow: none;">
                        <textarea id="editor" style="min-height: 400px" name="documentation"><?php echo $documentation->document; ?></textarea>
                    </div>
                </li>
                <li>
                    <input type="submit" name="update" class="button-box edit" value="Save"/>
                </li>
            </ul>
        </div>
    </form>
</div>
<script src="<?php echo WEBSITE_URL;?>js/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );

</script>