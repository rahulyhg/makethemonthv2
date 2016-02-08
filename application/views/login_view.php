<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta name="Description" content="Make The Month" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Make The Month</title>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL;?>css/login-style.css' type="text/css" media="screen, projection" />
    <link rel="stylesheet" href='<?php echo WEBSITE_URL;?>css/login-queries.css' type="text/css" media="screen, projection" />
</head>
<body style="background-color: #e1e1e1;">   
        <div class="login-container">
            <div class="top-box-login">
                <div class="login-logo"></div>
                <div class="top-login-right">
                    <div class="login-title">Sign in</div>
                    <div class="login-subtitle">Hello, sign in to get started !</div>
                </div>
            </div>
            <div class="login-content">
                <?php if(validation_errors()){?><div class="msg error"><?php echo validation_errors(); ?></div><?php }?>
                <?php echo form_open('verifylogin'); ?>
                    <div class="login-row">
                        <div class="admin-login-icon"></div>
                        <input type="text" size="40" name="username" id="txtbox" class="login-input" placeholder="admin" value=""/>
                    </div>
                    <div class="login-row" style="margin-top:20px;">
                        <div class="passwd-login-icon"></div>
                        <input type="password" size="40" name="password" id="txtbox" class="login-input" placeholder="●●●●●●●●" value=""/>
                    </div>
                    <input type="submit" name="doLogin" class="login-btn" id="doLogin3" value="Login"/>
                </form> 
            </div>
        </div> 
</body>
</html>