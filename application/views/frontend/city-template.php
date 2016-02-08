<section class="city">
    <div class="box-city white-class">
        <div class="upper-icon">
            <img src="<?php echo WEBSITE_URL.$city_info->icon;?>"/>
        </div>
        <h1 class="small dark-text bolder"><?php echo $city_info->name; ?></h1>
        <h4><?php echo $city_info->en_facts ?></h4>
        <?php
        if($city_info->id == 16){
        ?>
        <hr>
        <h4><?php echo $city_info->fr_facts ?></h4>
        <?php } ?>
        <div class="buttons-content">
            <h3 data-lang="en" data-step="scenario" class="white-text btn red-class">Play <?php if($city_info->id == 16){echo '(english)';} ?></h3>
            <?php
            if($city_info->id == 16){
            ?>
            <h3 data-lang="fr" data-step="scenario" class="white-text btn red-class">Jouer (French)</h3>
            <?php }?>
        </div>
    </div>
    <script>
        $(window).load(function(){
            $('.box-city').css('width',$('.box-city').height()*1.7);
        })
        $(window).resize(function(){
            $('.box-city').css('width',$('.box-city').height()*1.7);
        })
    </script>
</section>