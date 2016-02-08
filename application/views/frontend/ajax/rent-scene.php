<section class="scenario--rent" style="opacity:1" >
    <div>
        <h2 class="white-text big"><?php echo $lng == 'english' ? $rent->en_rent_paragraph : $rent->fr_rent_paragraph;?></h2>
        <div class="rent-scene rent-scene--up">
            <div class="col3 <?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){echo 'buttons" data-value="'.($rent->min_rent > $rent->max_rent?$rent->max_rent:$rent->min_rent).'"';}elseif($this->agent->is_mobile()){echo 'animate-me" data-range="-1"';} ?>">
                <?php if($rent->max_rent < $rent->min_rent){
                ?>
                    <img src="<?php echo WEBSITE_URL;?>images/max-rent.png">
                <?php
                }else{
                ?>
                    <img src="<?php echo WEBSITE_URL;?>images/min-rent.png">
                <?php
                } ?>
            </div>
            <div class="col3 has-border">
               <p class="white-text"><?php echo $this->lang->line('rent-description');?></p>
               <h3 id="rent_value" class="output bolder red-text">$<?php echo number_format(($rent->max_rent + $rent->min_rent)/2); ?></h3>
            </div>
            <div class="col3 <?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){echo 'buttons" data-value="'.($rent->max_rent > $rent->min_rent?$rent->max_rent:$rent->min_rent).'"';}elseif($this->agent->is_mobile()){echo 'animate-me" data-range="1"';} ?>">
                <?php if($rent->max_rent < $rent->min_rent){
                    ?>
                    <img src="<?php echo WEBSITE_URL;?>images/min-rent.png">
                <?php
                }else{
                    ?>
                    <img src="<?php echo WEBSITE_URL;?>images/max-rent.png">
                <?php
                } ?>
            </div>
        </div>
        <div class="rent-scene rent-scene--down">
            <div class="col3">
                <h4 style="line-height:100%;" class="<?php if($rent->max_rent > $rent->min_rent){ echo 'red';}else{echo 'white';}?>-text bolder" <?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){ ?> data-value="<?php echo ($rent->min_rent > $rent->max_rent?$rent->max_rent:$rent->min_rent);?>"<?php } ?>><?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){echo ' $'; echo $rent->min_rent > $rent->max_rent?$rent->max_rent:$rent->min_rent;}else{if($rent->max_rent > $rent->min_rent){ echo  $this->lang->line('suburbs');}else{echo $this->lang->line('inner-city');}}?></h4>
            </div>
            <div class="col3 has-slider <?php if($rent->max_rent > $rent->min_rent){ echo 'reverse-slider';}?>">
                <?php if(!$this->agent->is_mobile()){?><input type="text" value="<?php echo ($rent->max_rent + $rent->min_rent)/2 ?>" data-slider-range="<?php echo $rent->min_rent > $rent->max_rent?$rent->max_rent:$rent->min_rent ?>,<?php echo $rent->max_rent > $rent->min_rent?$rent->max_rent:$rent->min_rent?>" data-slider="true"><?php }  ?>
            </div>
            <div class="col3">
                <h4 style="line-height:100%;" class="<?php if($rent->max_rent < $rent->min_rent){ echo 'red';}else{echo 'white';}?>-text bolder" <?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){ ?> data-value="<?php echo ($rent->max_rent > $rent->min_rent?$rent->max_rent:$rent->min_rent);?>"<?php } ?>><?php if($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')){echo ' $'; echo $rent->max_rent > $rent->min_rent?$rent->max_rent:$rent->min_rent;}else{if($rent->max_rent < $rent->min_rent){ echo  $this->lang->line('suburbs');}else{echo $this->lang->line('inner-city');}}?></h4>
            </div>
        </div>
        <div class="button-box dark-text white-class bolder" id="go-questions"><?php echo $this->lang->line('choose');?></div>
    </div>
</section>
<script src="<?php echo WEBSITE_URL;?>js/simple-slider.js"></script>
<script>
    var rent = <?php echo($rent->max_rent + $rent->min_rent)/2 ?>;
    var max =<?php echo $rent->max_rent > $rent->min_rent?$rent->max_rent:$rent->min_rent?>;
    var min =<?php echo $rent->min_rent > $rent->max_rent?$rent->max_rent:$rent->min_rent ?>;
    var step = (max-min)/10;
    $(document).ready(function(){
        $("[data-slider]").bind("slider:ready slider:changed", function (event, data) {
            $('#rent_value').html('$'+numberWithCommas(data.value.toFixed(0)));
            rent = data.value.toFixed(0);
        });
    });
    $(document).on('click','.animate-me',function(){
        rent+=(step*parseInt($(this).attr('data-range')));
        if(rent>max){
            rent = max;
        }
        if(rent<min){
            rent = min;
        }
        $('#rent_value').html('$'+numberWithCommas(rent.toFixed(0)));
    });
    $(window).resize(function(){
        $("[data-slider]").bind("slider:ready slider:changed", function (event, data) {
            $('#rent_value').html('$'+numberWithCommas(data.value.toFixed(0)));
            rent = data.value.toFixed(0);
        });
    })
    $(document).on('click','[data-value]',function(){
        rent = parseInt($(this).attr('data-value'));
        $('#go-questions').click();
    })
</script>