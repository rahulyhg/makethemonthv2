<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Description" content="Make The Month"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Lang" content="en">
    <meta name="author" content="Imperial, United Way, Park Digital">
    <meta name="generator" content="PhpED 6.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Challenge your perspective on poverty. Can you MAKE THE MONTH? #makethemonth">
    <meta name="keywords" content="United Way Calagry">
    <meta name="creation-date" content="15/10/2014">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo WEBSITE_URL; ?>apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo WEBSITE_URL; ?>apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo WEBSITE_URL; ?>apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo WEBSITE_URL; ?>apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo WEBSITE_URL; ?>apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo WEBSITE_URL; ?>apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo WEBSITE_URL; ?>apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo WEBSITE_URL; ?>apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo WEBSITE_URL; ?>apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo WEBSITE_URL; ?>android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo WEBSITE_URL; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo WEBSITE_URL; ?>favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo WEBSITE_URL; ?>favicon-16x16.png">
    <link rel="manifest" href="<?php echo WEBSITE_URL; ?>manifest.json">
    <meta name="msapplication-TileImage" content="<?php echo WEBSITE_URL; ?>ms-icon-144x144.png">
    <!-- Open Graph data -->
    <meta property="og:title" content="Can You Make The Month"/>
    <meta property="og:type" content="game"/>
    <meta property="og:url" content="http://www.makethemonth.ca/"/>
    <meta property="og:image" content="http://makethemonth.ca/images/Make-The-Month.gif"/>
    <meta property="og:description" content="Challenge your perspective on poverty. Can you MAKE THE MONTH? #makethemonth"/>
    <meta name="twitter:card" content="game">
    <meta name="twitter:site" content="@UnitedWayCgy">
    <meta name="twitter:title" content="Make The Month">
    <meta name="twitter:description" content="Challenge your perspective on poverty. Can you MAKE THE MONTH? #makethemonth">
    <meta name="twitter:creator" content="@UnitedWayCgy">
    <meta name="twitter:image" content="http://makethemonth.ca/images/Make-The-Month.gif">
    <title><?php if (isset($city_info)) { echo ucfirst($city_info->name) . ' - '; } ?>Make The Month</title>
    <link rel="stylesheet" href="<?php echo WEBSITE_URL; ?>css/font-awesome.css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL; ?>css/flipclock.css' type="text/css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL; ?>css/simple-slider.css' type="text/css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL; ?>css/frontend-style.css' type="text/css"/>
    <link rel="stylesheet" href='<?php echo WEBSITE_URL; ?>css/frontend-queries.css' type="text/css"/>
    <link rel="stylesheet" href="<?php echo WEBSITE_URL; ?>css/loader.css" type="text/css"/>
    <script>
        var site_url = '<?php echo WEBSITE_URL;?>';
        var city_id = '<?php echo @$city_info->id;?>';
        var q_id = '<?php echo @$city_info->q_id;?>';
        var lang = '<?php echo  @$lang;?>';
        var playerId = '<?php echo @$playerId; ?>';
    </script>
    <script type="text/javascript" src="<?php echo WEBSITE_URL; ?>js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBSITE_URL; ?>js/countUp.js"></script>
    <script type="text/javascript" src="<?php echo WEBSITE_URL; ?>js/flipclock.js"></script>
    <script type="text/javascript" src="<?php echo WEBSITE_URL; ?>js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBSITE_URL; ?>js/frontend-main.js"></script>
    <script src="https://use.typekit.net/tby8yqx.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body class="<?php echo $body_class . ' ' . @$has_sidebar; ?>" style="<?php if(isset($url)){}else{ ?>display: none; <?php }  ?>">
<nav>
    <ul>
        <?php if(@$load_menu){
            $this->load->view('frontend/menu');
            ?>
            <script>
                clock = $('.days-status').FlipClock(1, {
                    clockFace: 'Counter'
                });
            </script>
        <?php
        } ?>
    </ul>
</nav>
<div class="content">
<?php
$this->load->view('frontend/' . $template);
?>
</div>
<footer>
    <?php
    $this->load->view('frontend/footer'); ?>
</footer>
<div class="overlay">
    <div class="pop-up">
        <div class="pop-up-container">
            <h2></h2>
            <div class="pop-up-content">
            </div>
        </div>
        <div class="close-pop-up"><i class="fa fa-times"></i></div>
        <script>
            $(document).ready(function () {
                $('.pop-up-content').niceScroll({styler:"fb",cursorcolor:"#282828"});
            })
        </script>
    </div>
</div>
<div class="overlay-loading"><div class="loader"></div></div>
<div class="payday-loader">
        <div class="buget-animate">
            <div class="light-buget">$</div>
            <div class="red-buget">$</div>
        </div>
</div>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-66911601-1', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>