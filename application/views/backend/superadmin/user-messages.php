<div class="header-title">
    <h2>Message for all users</h2>
</div>
<div class="content content--form">
    <form action="" method="POST">
        <ul>
            <?php if(isset($message_type)){ ?>
            <li>
                <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
            </li>
            <?php }?>
            <li>
                <label for="message">Message for users:</label>
                <textarea id="message" name="message" class="field-box big"><?php echo @$messages->content; ?></textarea>
            </li>
            <li>
                <input type="submit" name="save-message" value="Update user" class="button-box edit"/>
            </li>
        </ul>
    </form>
</div>