<div class="header-title">
    <h2>View users</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="content content--list">
    <div class="action"><a href="<?php echo WEBSITE_URL;?>superadmin/users/new"  class="button-box view no-right">Add New User</a></div>
    <?php if(isset($message_type)){ ?>
    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
    <?php }?>
    <ul>
        <li class="header">
            <div class="no">No.</div>
            <div class="name">Userame</div>
            <div class="email">Email</div>
            <div class="for-city">User Type</div>
            <div class="status">Status</div>
            <div class="last_login">Last Login</div>
            <div class="options">Options</div>
        </li>
        <?php 
         $i=1;
         foreach($users as $user){
            if($i%2==0){
                $class = 'even';
            }else{
                $class = '';
            }
         ?>
         <li class="<?php echo $class; ?>">
            <div class="no"><?php echo $i; ?></div>
            <div class="name"><?php echo $user->username; ?></div>
            <div class="email"><?php echo $user->email; ?></div>
            <div class="for-city"><?php echo $user->function; ?></div>
            <div class="status"><?php echo $user->account_status; ?></div>
            <div class="last_login"><?php if($user->last_login){echo $user->last_login;}else{echo 'Never';} ?></div>
            <div class="options">
                <a href="<?php echo WEBSITE_URL;?>superadmin/users/edit/<?php echo $user->id;?>" class="button-box edit">Edit</a>
                <a href="<?php echo WEBSITE_URL;?>superadmin/users/delete/<?php echo $user->id;?>" class="button-box delete">Delete</a>
            </div>
        </li>
         <?php
         $i++;
         }
        ?>
    </ul>
</div>