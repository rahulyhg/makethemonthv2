<?php $question = $question_set['question']; $answer = $question_set['answers'];?>
<div class="header-title">
    <h2>Edit Common Question<a href="<?php echo WEBSITE_URL.'demo/question/'.$question->id; ?>" target="_blank" style="float:right" class="button-box edit">Preview Question</a></h2>
    <h3><?php if($question->scenario == 1){
            echo 'A Single Person';
        }elseif($question->scenario == 2){
            echo 'A Single Parent';
        }elseif($question->scenario == 3){
            echo 'A Family';
        }else{
            echo 'All';
        } ?></h3>
</div>
<div class="content content--form local-question">
    <form action="" method="POST" id="add-question">
        <div class="full-width">
            <ul>
                <?php if(isset($message_type)){ ?>
                <li>
                    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
                </li>
                <?php }?>
                <li>
                    <div class="msg error no-display"></div>
                </li>
                <li>
                    <fieldset style="width: 100%; float:left; text-align: center;">
                        <img style="display: <?php if(isset($question->icon)){echo 'inline-block';}else{echo 'none';}?>;" src="<?php echo WEBSITE_URL.$question->icon;?>" />
                    </fieldset>
                </li>
                <li>
                    <label>Question:</label>
                    <fieldset class="left">
                        <input type="text" readonly="" name="en_name" value="<?php echo $question->en_name;?>" required="" class="field-box local-input" placeholder="English Name"/>
                        <input type="text" readonly="" name="fr_name" value="<?php echo $question->fr_name;?>" required="" class="field-box local-input" placeholder="French name"/>
                    </fieldset>
                </li>
                <?php if(isset($question->is_custom) && $question->is_custom == 1){?>
                <li>
                    <label>Custom Variable:</label>
                    <fieldset class="left">
                        <input type="checkbox"  value="1" class="no-display" name="is_custom" checked=""   id="is_custom">
                        <input type="text" name="en_custom" value="<?php echo @$question->en_custom;?>" class="field-box" placeholder="English custom" <?php if(isset($question->is_custom) && $question->is_custom == 1){echo "required=''";} ?>/>
                        <input type="text" name="fr_custom" value="<?php echo @$question->fr_custom;?>" class="field-box" placeholder="French custom" <?php if(isset($question->is_custom) && $question->is_custom == 1){echo "required=''";} ?>/>
                    </fieldset>
                </li>
                <?php } ?>
                <li>
                    <label class="full-width">Supporting Facts</label>
                    <textarea style="min-height: 50px; max-width: 100%; min-width: 100%; width:330px" name="en-supporting-facts" class="field-box full-width  local-input" placeholder="English Facts"><?php echo @$question->en_supporting_facts;?></textarea>
                    <textarea style="min-height: 50px; max-width: 100%; min-width: 100%; width:330px" name="fr-supporting-facts" class="field-box full-width  local-input" placeholder="French Facts"><?php echo @$question->fr_supporting_facts;?></textarea>
                </li>
            </ul>
        </div>
        <div class="full-width">
            <ul>
                <?php for($i=1;$i<4;$i++){ 
                    if($i==1){
                        $class = 'display';
                    }else{
                        $class = 'no-display';
                    }?>
                <li>
                    <input type="hidden" name="answer_id-<?php echo $i;?>" value="<?php echo @$answer['id-'.$i];?>" />
                    <div class="each-option">
                        <h2>Choice <?php echo $i; if(@$answer['id-'.$i]){?><a href="<?php echo WEBSITE_URL.'demo/answer/'.@$answer['id-'.$i]; ?>" target="_blank" style="float:right">Preview Answer</a><?php }?></h2>
                        <div class="option-content <?php echo $class;?>">
                            <ul>
                                <li>
                                    <label class="full-width">Impact of choice</label>
                                    <input type="text" readonly name="en_answer_desc-<?php echo $i; ?>"  value="<?php echo @$answer['en_answer_desc-'.$i];?>" class="field-box full-width required" placeholder="English Description"/>
                                    <input type="text" readonly name="fr_answer_desc-<?php echo $i; ?>"  value="<?php echo @$answer['fr_answer_desc-'.$i];?>" class="field-box full-width required" placeholder="French Description"/>
                                </li>
                                <li>
                                    <label class="full-width">Impact of choice cost:</label>
                                    <input type="number" name="en_answer_cost-<?php echo $i; ?>" value="<?php echo @$answer['en_answer_cost-'.$i];?>"  class="field-box full-width required"/>
                                </li>
                                <li>
                                    <label class="full-width">Consequence Results</label>
                                    <textarea readonly style="min-height: 50px;" name="en_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="English Results"><?php echo @$answer['en_answer_result-'.$i];?></textarea>
                                    <textarea readonly style="min-height: 50px;" name="fr_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="French Results"><?php echo @$answer['fr_answer_result-'.$i];?></textarea>
                                </li>
                                <li>
                                    <label class="full-width">End of Game Consequence</label>
                                    <textarea readonly style="min-height: 50px;" name="en_answer_end_game-<?php echo $i; ?>" class="field-box full-width" placeholder="English End of Game Consequence"><?php echo @$answer['en_answer_end_game-'.$i];?></textarea>
                                    <textarea readonly style="min-height: 50px;" name="fr_answer_end_game-<?php echo $i; ?>" class="field-box full-width" placeholder="French End of Game Consequence"><?php echo @$answer['fr_answer_end_game-'.$i];?></textarea>
                                </li>
                                <li style="display: none">
                                    <label class="full-width" title="Stress level has no impact on game play just moves the stress meter to add drama">Stress Level</label>
                                    <select name="en_answer_stress-<?php echo $i; ?>" class="field-box full-width">
                                        <option <?php if(@$answer['en_answer_stress-'.$i] == 1){echo 'selected=""';} ?> value="1">Low</option>
                                        <option <?php if(@$answer['en_answer_stress-'.$i] == 2){echo 'selected=""';} ?> value="2">Middle</option>
                                        <option <?php if(@$answer['en_answer_stress-'.$i] == 3){echo 'selected=""';} ?> value="3">High</option>
                                        <option <?php if(@$answer['en_answer_stress-'.$i] == 4){echo 'selected=""';} ?> value="4">Critic</option>
                                    </select>
                                </li>
                                <li>
                                    <label class="full-width">Consequence Hidden Cost:</label>
                                    <input type="number" name="extra_cost-<?php echo $i; ?>" value="<?php echo @$answer['extra_cost-'.$i];?>" placeholder = "use {extrafee}"  class="field-box full-width"/>
                                </li>
                                <li style="display: none">
                                    <input type="checkbox" <?php if(@$answer['en_answer_strike-'.$i]==1){echo 'checked=""';} ?> name="en_answer_strike-<?php echo $i; ?>" style="float:left; margin:4px 5px 0 0;" value="1"/>
                                    <label class="full-width"  title="3 strikes you are out!">Work Strike</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?php if(@$answer['en_answer_show_help-'.$i]==1){echo 'checked=""';} ?> class="show_help" name="en_answer_show_help-<?php echo $i; ?>" style="float:left; margin:4px 5px 0 0;" value="1"/>
                                    <label class="full-width"  title="">United Way is here to help </label>
                                </li>
                                <li id="en_answer_show_help-<?php echo $i; ?>" style="<?php if(@$answer['en_answer_show_help-'.$i]!=1){echo 'display: none';} ?>">
                                    <label class="full-width">Supporting program or service</label>
                                    <textarea style="min-height: 50px;" name="en_answer_facts-<?php echo $i; ?>" class="field-box full-width" placeholder="English program or service"><?php echo @$answer['en_answer_facts-'.$i];?></textarea>
                                    <textarea style="min-height: 50px;" name="fr_answer_facts-<?php echo $i; ?>" class="field-box full-width" placeholder="French program or service"><?php echo @$answer['fr_answer_facts-'.$i];?></textarea>
                                </li>
                                <li style="display: none">
                                    <label class="full-width" style="width:100%;">Deferred Needs</label>
                                    <fieldset class="left">
                                        <input type="radio" <?php if(@$answer['defered_credit-'.$i] == 1){echo 'checked=""';} ?> name="defered_credit-<?php echo $i; ?>" value="1" id="defered_credit-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_credit-1-<?php echo $i; ?>">Credit</label>
                                        <input type="radio" <?php if(@$answer['defered_credit-'.$i] == 2){echo 'checked=""';} ?>name="defered_credit-<?php echo $i; ?>" value="2" id="defered_credit-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_credit-2-<?php echo $i; ?>">Remove Credit</label>
                                    </fieldset>
                                    <fieldset class="left">
                                        <input type="radio" <?php if(@$answer['defered_bills-'.$i] == 1){echo 'checked=""';} ?>name="defered_bills-<?php echo $i; ?>" value="1" id="defered_bills-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_bills-1-<?php echo $i; ?>">Bills(utillity)</label>
                                        <input type="radio" <?php if(@$answer['defered_bills-'.$i] == 2){echo 'checked=""';} ?>name="defered_bills-<?php echo $i; ?>" value="2" id="defered_bills-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_bills-2-<?php echo $i; ?>">Remove Bills</label>
                                    </fieldset>
                                    <fieldset class="left">
                                        <input type="radio" <?php if(@$answer['defered_car-'.$i] == 1){echo 'checked=""';} ?>name="defered_car-<?php echo $i; ?>" value="1" id="defered_car-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_car-1-<?php echo $i; ?>">Car</label>
                                        <input type="radio" <?php if(@$answer['defered_car-'.$i] == 2){echo 'checked=""';} ?>name="defered_car-<?php echo $i; ?>" value="2" id="defered_car-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_car-2-<?php echo $i; ?>">Remove Car</label>
                                    </fieldset>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <?php }?>
            </ul>
        </div>
        <ul>
            <li>
                <input type="submit" name="edit" class="button-box edit" value="Update Question"/>
            </li>
        </ul>
    </form>
</div>
<?php if(isset($histories)){?>
<div class="header-title sub-header">
    <h2>History</h2>
</div>
<div class="content content--list">
    <ul>
        <li class="header">
            <div class="no">No.</div>
            <div class="long-text">Question</div>
            <div class="for-city has-filter"></div>
            <div class="for-city has-filter"></div>
            <div class="options">Options</div>
        </li>
    </ul>
</div>
<?php }?>
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
    $('#add-question').submit(function(e){
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
        if(i<2){
            cond = false;
            error.push({'error':'You have to select at least two option for this question!'});
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