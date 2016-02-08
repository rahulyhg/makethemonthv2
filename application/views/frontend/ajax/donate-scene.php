<section class="donate-scene" style="opacity:1" >
    <div>
        <img src="<?php echo WEBSITE_URL ?>images/united-way-logo.png" alt="united way logo">
        <h1 class="small dark-text bolder"><?php echo $this->lang->line('donate-header');?></h1>
        <h2 class="small dark-text">
            <?php echo $lng == 'english'?@$answer->en_facts:@$answer->fr_facts; ?>
            <br/>
            <?php echo $this->lang->line('donate-text');?>
        </h2>
        <div class="buttons-bottom">
            <a href="javascript:;" data-answer-go class="red-class white-text"><?php echo $this->lang->line('donate-continue');?></a>
            <a href="<?php  echo $footer_url->url_donate?>" target="_blank" class="dark-class white-text"><?php echo $this->lang->line('footer-donate');?></a>
        </div>
    </div>
</section>