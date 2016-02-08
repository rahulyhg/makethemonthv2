<section class="home">
    <div>
        <div class="language-button"><a href="<?php $lang_url = (isset($lang) && $lang=="french")?"english":"french"; echo WEBSITE_URL.'home/'.$lang_url?>"><?php if($lang=="french"){ ?>ENGLISH<?php }else{?>FRAN&Ccedil;AIS<?php } ?></a></div>
        <h1 class="white-text bolder"><?php echo $this->lang->line('home-header');?></h1>
        <h2 class="red-text bolder"><?php echo $this->lang->line('home-subhead');?></h2>
        <img src="<?php echo WEBSITE_URL; ?>images/home-icons.png" alt="home-icons" width="440" height="103"/>

        <h2 class="white-text middle-col2 small lighter"><span><?php echo $this->lang->line('home-p-1');?><br/><?php echo $this->lang->line('home-p-2');?><br/></span><?php echo $this->lang->line('home-p-3');?></h2>
        <div class="select-custom">
            <div class="select-options-content white-class">
                <h3 class="dark-text normal" data-show=""><span><?php echo $this->lang->line('dropdown-text');?></span><i class="fa fa-angle-down"></i>
                </h3>
                <ul class="select-options">
                    <?php
                    $select = "";
                    foreach ($cities as $city) {
                        if ($city->status == 1) {
                            $select.='<option value="'.$city->m_code.'">'.$city->name.'</option>';
                            ?>
                            <li data-city="<?php echo $city->m_code ?>"><h3
                                    class="dark-text normal"><?php echo $city->name ?></h3></li>
                            <?php
                        }
                    } ?>
                </ul>
                <select class="mobile-select" id="mobile-select"><option disabled selected><?php echo $this->lang->line('dropdown-text');?></option><?php echo $select; ?></select>
            </div>
            <div class="select-option-play red-class" data-action>
                <h3 class="white-text normal"><?php echo $this->lang->line('play');?></h3>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('.select-options').niceScroll({cursoropacitymin:0.7,cursorwidth:10});
        setTimeout(function(){
            $('.nicescroll-cursors').fadeOut(500);
        },1000)
    })
</script>