<section class="win-lose-scene" style="opacity:1" >
    <div>
        <h1 class="small bolder red-text"><?php echo $this->lang->line('lose-header');?></h1>
        <h3 class="white-text"><?php echo $this->lang->line('lose-text');?><br><span><?php echo $this->lang->line('win-lose-subtitle'); ?></span></h3>
        <ul>
            <?php
            if (isset($end_con) && !empty($end_con)) {
                $i=0;
                foreach ($end_con as $line) {
                    if(!$line=="" || !$line==" "){
                        if($i<5){
                    ?>
                    <li class="grey-color"><h3 class="grey-color"><span></span><?php echo $line; ?></h3></li>
                    <?php
                            $i++;
                        }
                    }
                }
            } ?>
        </ul>
        <div class="button-bottom">
            <div class="each-button red-class">
                <div>
                    <img src="<?php echo WEBSITE_URL ?>images/invest.png" alt="Invest in reducing poverty">
                    <h3 class="big white-text"><?php echo $this->lang->line('end-invest');?></h3>
                </div>
                <a href="<?php echo @$footer_url->invest?$footer_url->invest:"http://www.calgaryunitedway.org/get-involved";?>" target="_blank"></a>
            </div>
            <div class="each-button red-class">
                <div class="social-icons">
                    <div>
                        <a class="button-circle white-class" id="facebookshare" href="javascript:;"><i class="fa red-text fa-facebook-square"></i></a>
                        <a class="button-circle white-class" id="twitttershare" href="javascript:;"><i class="fa red-text fa-twitter"></i></a>
                        <a class="button-circle white-class" id="linkedinshare" href="javascript:;"><i class="fa red-text fa-linkedin-square"></i></a>
                        <a class="button-circle white-class" id="emailshare" href="javascript:;"><i class="fa red-text fa-envelope"></i></a>
                    </div>
                    <h3 class="big white-text"><?php echo $this->lang->line('end-share');?></h3>
                </div>
            </div>
            <div class="each-button red-class">
                <div>
                    <img src="<?php echo WEBSITE_URL ?>images/united-way.png" alt="DO MORE WITH UNITED WAY">
                    <h3 class="big white-text"><?php echo $this->lang->line('end-do-more');?></h3>
                </div>
                <a href="<?php echo @$footer_url->do_more ?>" target="_blank"></a>
            </div>
            <div class="each-button red-class">
                <div>
                    <img src="<?php echo WEBSITE_URL ?>images/company.png" alt="GET YOUR COMPANY INVOLVED">
                    <h3 class="big white-text"><?php echo $this->lang->line('end-company-involved');?></h3>
                </div>
                <a href="<?php echo @$footer_url->involved ?>" target="_blank"></a>
            </div>
        </div>
        <a class="reload-game" href="<?php echo WEBSITE_URL ?>"><h3 class="big white-text"><?php echo $this->lang->line('end-again');?></h3></a>
    </div>
    <script>
        $(window).load(function () {
            var boxHeight = 0.7;
            var windowHeight = $(window).height();
            if(windowHeight < 1080){
                boxHeight = 0.6;
            }
            if(windowHeight < 768){
                boxHeight = 0.5;
            }
            if(windowHeight < 641){
                boxHeight = 0.4;
            }
            $('.each-button').css('height', $('.each-button').width() * boxHeight + "px");
        })
        $(document).ready(function () {
            var boxHeight = 0.7;
            var windowHeight = $(window).height();
            if(windowHeight < 1080){
                boxHeight = 0.6;
            }
            if(windowHeight < 768){
                boxHeight = 0.5;
            }
            if(windowHeight < 641){
                boxHeight = 0.4;
            }
            $('.each-button').css('height', $('.each-button').width() * boxHeight + "px");
        })
        $(window).resize(function () {
            var boxHeight = 0.7;
            var windowHeight = $(window).height();
            if(windowHeight < 1080){
                boxHeight = 0.6;
            }
            if(windowHeight < 768){
                boxHeight = 0.5;
            }
            if(windowHeight < 641){
                boxHeight = 0.4;
            }
            $('.each-button').css('height', $('.each-button').width() * boxHeight + "px");
        })
    </script>
</section>