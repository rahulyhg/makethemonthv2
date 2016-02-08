<div class="header-title">
    <h2><?php echo $city->name; ?> Rent</h2>
</div>
<div class="content content--form">
    <form action="" method="POST" id="update-rent">
            <?php if(isset($message_type)){ ?>            
        <ul>
            <li>
                <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
            </li>
        </ul>
                <?php }?>
        <div class="col2">
            <img class="rent-image" src="<?php echo WEBSITE_URL; ?>images/min-rent.png"/><br />
            <input type="number"  class="field-box center-rent" name="min-rent" value="<?php echo $rent->min_rent; ?>" required=""/>
        </div>
        <div class="col2">
            <img class="rent-image" src="<?php echo WEBSITE_URL; ?>images/max-rent.png"/><br />
            <input type="number" class="field-box center-rent" name="max-rent" value="<?php echo $rent->max_rent; ?>" required=""/>
        </div>
        <ul>
            <li>
                <div class="msg error no-display"></div>
            </li>
            <li>
                <input type="submit" class="button-box edit" value="Update Rent" name="update"/>
            </li>
        </ul>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#update-rent').submit(function(e){
            $('.msg.error').fadeOut(300);
            if($('[name="min-rent"]').val()>=$('[name="max-rent"]').val()){
                $('.msg.error').html("");
                $('.msg.error').append('<p>You have to set a lower rent for suburbs!</p>');
                $('.msg.error').fadeIn(300);
                e.preventDefault();
            }
        })
    })
</script>