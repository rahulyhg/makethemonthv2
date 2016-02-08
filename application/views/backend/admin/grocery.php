<div class="header-title">
    <h2>Grocery Scene</h2>
</div>
<?php 
$grocery = $grocery_info['grocery'];
$options = $grocery_info['options'];
?>
<div class="content content--form">
    <form action="" method="POST" id="update-scene">
        <div class="full-width">
            <ul>
                <li>
                    <div class="msg error no-display"></div>
                </li>
                <?php if(isset($message_type)){ ?>
                <li>
                    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
                </li>
                <?php }?>
                <li>
                    <label>Scene Name:</label>
                    <fieldset class="left">
                        <input type="text" readonly="" name="en_name" value="<?php echo @$grocery->en_name;?>" required="" class="field-box" placeholder="English Name"/>
                        <input type="text" readonly="" name="fr_name" value="<?php echo @$grocery->fr_name;?>" required="" class="field-box" placeholder="French name"/>
                    </fieldset>
                </li>
                <li>
                    <label>Additional Info:</label>
                    <fieldset class="left">
                        <input type="text" name="en_adition" value="<?php echo @$grocery->en_adition;?>" required="" class="field-box" placeholder="English Additional Info"/>
                        <input type="text" name="fr_adition" value="<?php echo @$grocery->fr_adition;?>" required="" class="field-box" placeholder="French Additional Info"/>
                    </fieldset>
                </li>
            </ul>
        </div>
        <div class="col2" style="width:400px; padding-right:10px;">
            <ul>
                <li>
                    <label>Scene Icon:</label>
                    <img style="display: <?php if(isset($grocery->general_icon)){echo 'block';}else{echo 'none';}?>;" src="<?php echo WEBSITE_URL.@$grocery->general_icon;?>" />
                    <input type="hidden" name="icon" value="<?php echo @$grocery->general_icon;?>"/>
                </li>                
            </ul>
        </div>
        <div class="col2">
            <ul>
                <?php 
                    $i=1;
                foreach($options as $option){ 
                    if($i==1){
                        $class = 'display';
                    }else{
                        $class = 'no-display';
                    }?>
                <li>
                    <div class="each-option">
                        <input type="hidden" name="option_id-<?php echo $i;?>" value="<?php echo @$option->id;?>" />
                        <h2>Option <?php echo $i;?></h2>
                        <div class="option-content <?php echo $class;?>">
                            <ul>
                                <li>
                                    <label>Option Icon:</label>
                                    <img style="display: <?php if(isset($option->icon)){echo 'block';}else{echo 'none';}?>;" src="<?php echo WEBSITE_URL.@$option->icon;?>" />
                                    <input type="hidden" name="icon-<?php echo $i; ?>" value="<?php echo @$option->icon;?>"/>
                                </li>
                                <li>
                                    <label class="full-width">Option Description</label>
                                    <input type="text" readonly="" name="en_answer_desc-<?php echo $i; ?>"  value="<?php echo @$option->en_name;?>" class="field-box full-width required" placeholder="English Description"/>
                                    <input type="text" readonly="" name="fr_answer_desc-<?php echo $i; ?>"  value="<?php echo @$option->fr_name;?>" class="field-box full-width required" placeholder="French Description"/>
                                </li>
                                <li>
                                    <label class="full-width">Option Results</label>
                                    <textarea style="min-height: 50px;" readonly="" name="en_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="English Results"><?php echo @$option->en_content;?></textarea>
                                    <textarea style="min-height: 50px;" readonly="" name="fr_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="French Results"><?php echo @$option->fr_content;?></textarea>
                                </li>
                                <li>
                                    <label class="full-width">Option Cost:</label>
                                    <input type="number" name="answer_cost-<?php echo $i; ?>" value="<?php echo @$option->cost;?>"  class="field-box full-width required"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <?php $i++;}?>
            </ul>
        </div>
        <ul>
            <li>
                <input type="submit" name="update" class="button-box edit" value="Update Scene"/>
            </li>
        </ul>
    </form>
</div>
<div style="display: none;">
    <form id="upload-files" action="<?php echo WEBSITE_URL;?>ajax/do_upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="userfile" id="userfile"/>
        <input type="submit" value="Add"/>
    </form>
</div>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js"></script>
<script>
var title;
$('#upload-files').ajaxForm({
    beforeSend: function() {
        $(".overlay-loading").show();
    },
    complete: function(xhr) {
        $('input[name="'+title+'"]').val('uploads/'+xhr.responseText);
        $('input[name="'+title+'"]').siblings('img').attr('src','<?php echo WEBSITE_URL; ?>uploads/'+xhr.responseText);
        $('input[name="'+title+'"]').siblings('img').fadeIn(500);
        $('.upload').val('Change Icon');
        $(".overlay-loading").hide();
    }
}); 
$(document).ready(function(){
    $('.upload').click(function(){
        title = $(this).attr('id');
        $('#userfile').click();
    })
    $('.each-option h2').click(function(){
        var el = $(this).parent('div').find('div');
        $('.each-option >div').fadeOut(500);
        setTimeout(function(){$(el).fadeIn(500);},501);
    })
    $('.option-content input[type="radio"]').click(function(){
        if($(this).is(':checked')){
            if($(this).hasClass('checked')){
                $(this).removeClass('checked');
                $(this).prop('checked',false);
            }else{
                $(this).siblings('input').removeClass('checked');
                $(this).addClass('checked');
            }
        }else{
            console.log('not');
        }
    })
    $('#update-scene').submit(function(e){
        $('.msg.error').fadeOut(300);
        var cond = true;
        var error = [];
        if($('input[name="icon"]').val() == ""){
            cond=false;
            error.push({'error':'You have to add an icon for this question!'}); 
        }
        var i = 0;
        $('.each-option').each(function(){
            var check = true;
            $(this).find('.required').each(function(){
                if(this.value == ""){
                    check = false;
                }
            })
            if(check){
                i++;
            }
        })
        if(i<3){
            cond = false;
            error.push({'error':'You have to set up all the options!'});
        }
        if(!cond){
            e.preventDefault();
            $('.msg.error').html("");
            $.each(error,function(){
                $('.msg.error').append('<p>'+this.error+'</p>');
            })
            $('.msg.error').fadeIn(300);
            $('html, body').animate({scrollTop: 0}, 500);
        }
    })
})
$('#userfile').change(function(){
    $('#upload-files').submit();
})
</script>