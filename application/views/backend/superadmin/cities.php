<div class="header-title">
    <h2>City Administration</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="content content--list">
    <ul>
        <li class="header">
            <div class="no">No.</div>
            <div class="name">City Name</div>
            <div class="last_login">Last Login</div>
            <div class="complete-city">% of Complete</div>
            <div class="status-city" style="width: 110px;">Turn On/Off</div>
            <div class="demo-button" style="width: 110px;">Demo version</div>
        </li>
        <?php
            $i=1;
            foreach($cities as $city){
            if($i%2==0){
                $class = 'even';
            }else{
                $class = '';
            }
        ?>
        <li class="<?php echo $class; ?>">
            <div class="no"><?php echo $i; ?></div>
            <div class="name"><?php echo $city->name; ?></div>
            <div class="last_login"><?php echo $city->last_login;?></div>
            <div class="complete-city">Still working here</div>
            <div class="status-city" style="width: 110px;"><input type="checkbox" value="<?php echo $city->id; ?>" <?php if($city->status){ echo 'checked=""';} ?> id="status-<?php echo $city->id; ?>" style="display: none;"/><label class="check-box" for="status-<?php echo $city->id; ?>"></label></div>
            <div class="demo-button" style="width: 110px;"><a href="<?php echo WEBSITE_URL.$city->m_code.'/demo'; ?>" target="_blank" class="button-box edit">Preview City</a></div>
        </li>
        <?php
            $i++;
            }
        ?>
    </ul>
</div>
<script>
$(document).ready(function(){
    $('.check-box').click(function(){
        loading_bg();
        var input = $(this).parent('div').find('input');
        var id = $(input).val();
        setTimeout(function(){
            var check = $(input).is(':checked');
            if(check){
                check = 1;
            }else{
                check = 0;
            }
            $.ajax({
                url:"<?php echo WEBSITE_URL; ?>superadmin/cities/change-status",
                type:"POST",
                data:{'id':id,'status':check},
                success:function(responde){
                    done_loading();
                }
            })
        },100);
    })
})
</script>