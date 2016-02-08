    <ul>
        <?php if(@$noAction == 'hide'){
            $noAction = false;
        }else{
            $noAction = true;
        } ?>
        <?php
        if($noAction): ?>
        <li>
            <a href="<?php echo  WEBSITE_URL; ?>"><?php echo $this->lang->line('footer-home');?></a>
        </li>
        <li>
            <a id="take-action" href="javascript:;"><?php echo $this->lang->line('footer-take-action');?></a>
        </li>
        <?php endif;
        if(@$city_info || @$footer_url): ?>
        <li>
            <a target="_blank" href="<?php if(@$city_info){echo $city_info->url_donate;}else{echo @$footer_url->url_donate?$footer_url->url_donate:"https://www.gifttool.com/donations/Donate?ID=1833&AID=888";}?>"><?php echo $this->lang->line('footer-donate');?></a>
        </li>
        <?php endif ?>
        <li>
            <a href="javascript:;" id="about-us"><?php echo $this->lang->line('footer-about');?></a>
        </li>
        <li>
            <a href="javascript:;" id="privacy"><?php echo $this->lang->line('footer-privacy');?></a>
        </li>
    </ul>
    <div class="mobile-footer">
        <img src="<?php echo WEBSITE_URL; ?>images/united-way.png" alt="footer-menu">
        <ul>
            <?php if($noAction): ?>
            <li>
                <a href="<?php echo  WEBSITE_URL; ?>"><?php echo $this->lang->line('footer-home');?></a>
            </li>
            <li>
                <a id="take-action" href="javascript:;"><?php echo $this->lang->line('footer-take-action');?></a>
            </li>

             <?php endif ?>
            <?php if(@$city_info || @$footer_url): ?>
            <li>
                <a target="_blank" href="<?php if(@$city_info){echo $city_info->url_donate;}else{echo @$footer_url->url_donate?$footer_url->url_donate:"https://www.gifttool.com/donations/Donate?ID=1833&AID=888";}?>"><?php echo $this->lang->line('footer-donate');?></a>
            </li>
            <?php endif ?>
            <li>
                <a href="javascript:;" id="about-us"><?php echo $this->lang->line('footer-about');?></a>
            </li>
            <li>
                <a href="javascript:;" id="privacy"><?php echo $this->lang->line('footer-privacy');?></a>
            </li>
        </ul>
    </div>