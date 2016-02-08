<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta name="Description" content="Make The Month" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?php if(isset($access)){ echo ucfirst($access).' - ';} ?>Make The Month</title>
    <link rel="stylesheet" href="<?php echo WEBSITE_URL;?>css/font-awesome.css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL;?>css/jquery-ui.css' type="text/css" media="screen, projection" />
    <link rel="stylesheet" href='<?php echo WEBSITE_URL;?>css/colorpicker.css' type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php echo WEBSITE_URL;?>js/amcharts/plugins/export/export.css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL;?>css/<?php echo $structure; ?>-style.css' type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php echo WEBSITE_URL; ?>css/loader.css" type="text/css"/>
    <script>
        var site_url = '<?php echo WEBSITE_URL;?>',
            template = '<?php echo @$template; ?>',
            access = '<?php echo @$access;?>';
    </script>
    <script src="<?php echo WEBSITE_URL;?>js/jquery-2.1.3.min.js"></script>
</head>
<body>
    <div class="overlay" title="Click to close"></div>
    <div class="overlay-loading"><div class="loader">MakeTheMonth</div></div>
	<?php
        $this->load->view($structure.'/header');
        $this->load->view($structure.'/body');
        $this->load->view($structure.'/footer');
    ?>
    <script src="<?php echo WEBSITE_URL;?>js/jquery-ui.js"></script>
    <script src="<?php echo WEBSITE_URL;?>js/<?php echo $structure; ?>-main.js"></script>
    <?php  if(@$stats){  ?>
        <script src="<?php echo WEBSITE_URL;?>js/amcharts/amcharts.js"></script>
        <script src="<?php echo WEBSITE_URL;?>js/amcharts/serial.js"></script>
        <script src="<?php echo WEBSITE_URL;?>js/amcharts/pie.js"></script>
        <script src="<?php echo WEBSITE_URL;?>js/amcharts/themes/light.js"></script>
        <script src="<?php echo WEBSITE_URL;?>js/amcharts/plugins/export/export.min.js"></script>
        <script type="text/javascript" src="<?php echo WEBSITE_URL;?>js/charts.js"></script>
    <?php } ?>
</body>
</html>