<header>
    <div class="container">
        <div class="logo">
            <a href="<?php echo WEBSITE_URL.$access; ?>">
                <img src="<?php echo WEBSITE_URL ?>images/logo.png" alt="logo"/>
            </a>
        </div>
        <div class="has-hover user-details">
            <h2><i class="fa fa-user"></i> <?php echo $info->first_name;?></h2>
            <ul>
                <!-- <li><a href="<?php echo WEBSITE_URL.$access; ?>/details">Account details</a></li>
                <li><a href="<?php echo WEBSITE_URL.$access; ?>/password">Change Password</a></li>-->
                <li><a href="<?php echo WEBSITE_URL; ?>login/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</header>