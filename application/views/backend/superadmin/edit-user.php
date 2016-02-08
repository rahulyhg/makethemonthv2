<div class="header-title">
    <h2>Edit user <?php echo $user->username;?></h2>
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
                <label for="username">Username:</label>
                <input class="field-box" type="text" name="username" value="<?php echo $user->username; ?>" id="username" required=""/>
            </li>
            <li>
                <label for="city">City:</label>
                <select class="field-box" name="city" id="city"  required="">
                    <option disabled="">Choose City</option>
                    <option value="NULL" <?php if(isset($user->city)){ echo ' selected=""';} ?>>Master</option>
                    <?php
                        foreach($cities as $city){
                    ?>
                    <option value="<?php echo $city->id ?>" <?php if($user->city==$city->id){ echo ' selected=""';} ?>><?php echo $city->name; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </li>
            <li>
                <label for="name">Name:</label>
                <input class="field-box" type="text" name="name" value="<?php echo $user->first_name.' '.$user->last_name;?>" id="name"  required=""/>
            </li>
            <li>
                <label for="email">Email Address:</label>
                <input class="field-box" type="email" name="email" value="<?php echo $user->email; ?>" id="email"  readonly=""/>
            </li>
            <li>
                <label for="phone">Phone Number:</label>
                <input class="field-box" type="text" name="phone" value="<?php echo $user->phone_no; ?>" id="phone"  required=""/>
            </li>
            <li>
                <label for="password">Password:</label>
                <input class="field-box" type="text" name="password" value="<?php echo @$_POST['password'] ?>" id="password"/>
            </li>
            <li>
                <input type="submit" name="update_user" value="Update user" class="button-box edit"/>
            </li>
        </ul>
    </form>
</div>