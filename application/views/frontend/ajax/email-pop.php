<div class="email-template">
    <form action="" method="post" id="share-emails"  autocomplete="off">
        <h5>Your Details</h5>
        <ul class="user-details">
            <li>
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Your email" required>
            </li>
        </ul>
        <h5>Friends Details</h5>
        <ul class="invite-friends">
            <li class="current">
                <input type="text" name="names[]" placeholder="Friend name" required>
                <input type="email" name="emails[]" placeholder="Friend email" required>
            </li>
        </ul>
        <ul>
            <li>
                <input type="submit" value="<?php echo $this->lang->line('end-share')?>">
            </li>
        </ul>
    </form>
</div>