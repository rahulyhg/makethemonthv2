<div class="header-title">
    <h2>New Common Question</h2>
</div>
<div class="content content--form">
    <form action="" method="POST" id="add-question">
        <div class="full-width">
            <ul>
                <li>
                    <div class="msg error no-display"></div>
                </li>
                <li>
                    <label>Question:</label>
                    <fieldset class="left">
                        <input type="text" name="en_name" value="<?php echo @$_POST['en_name'];?>" required="" class="field-box local-input" placeholder="English Name"/>
                        <input type="text" name="fr_name" value="<?php echo @$_POST['fr_name'];?>" required="" class="field-box local-input" placeholder="French Name"/>
                    </fieldset>
                </li>
                <li>
                    <label>Custom Variable:</label>
                    <fieldset class="left">
                        <input type="checkbox" value="1" class="no-display" name="is_custom" <?php if(isset($_POST['is_custom'])){echo "checked=''";} ?> id="is_custom">
                        <label class="is_custom" for="is_custom">Custom Question (use in question name this syntax {custom} <i>eg: You and your child are on your way to {custom}, you hit another car while parking.</i>)</label>
                    </fieldset>
                </li>
                <li>
                    <label class="full-width">Supporting Facts</label>
                    <fieldset class="left">
                    <textarea style="min-height: 50px; max-width: 100%; min-width: 100%; width:330px" name="en-supporting-facts" class="field-box full-width" placeholder="English Facts"><?php echo @$_POST['en_supporting_facts'];?></textarea>
                    <textarea style="min-height: 50px; max-width: 100%; min-width: 100%; width:330px" name="fr-supporting-facts" class="field-box full-width" placeholder="French Facts"><?php echo @$_POST['fr_supporting_facts'];?></textarea>
                    </fieldset>
                </li>
            </ul>
        </div>
        <div class="col2" style="width:400px; padding-right:10px;">
            <ul>
                <li>
                    <label>Question Icon:</label>
                    <img style="display: <?php if(isset($_POST['icon'])){echo 'block';}else{echo 'none';}?>;" src="<?php echo @$_POST['icon'];?>" />
                    <input type="hidden" name="icon" value="<?php echo @$_POST['icon'];?>"/>
                    <input type="button" class="button-box upload" id="icon" value="<?php if(isset($_POST['en_name'])){echo 'Change';}else{echo 'Add';}?> Icon"/>
                </li>
                <li>
                    <label>Seasonal Question:</label>
                    <fieldset class="left" style="width: 140px;">
                        <input type="radio" checked="" name="season" value="5" id="season-5" class="no-display"/><label class="radio-button" for="season-5">None</label>
                        <input type="radio" name="season" value="1" id="season-1" class="no-display"/><label class="radio-button" for="season-1">Fall</label>
                        <input type="radio" name="season" value="2" id="season-2" class="no-display"/><label class="radio-button" for="season-2">Winter</label>
                        <input type="radio" name="season" value="3" id="season-3" class="no-display"/><label class="radio-button" for="season-3">Summer</label>
                        <input type="radio" name="season" value="4" id="season-4" class="no-display"/><label class="radio-button" for="season-4">Spring</label>
                    </fieldset>
                </li>
                <li>
                    <label>Scenario Question:</label>
                    <fieldset class="left" style="width: 140px;">
                        <input type="radio" checked="" name="scenario" value="all" id="scenario-4" class="no-display"/><label class="radio-button" for="scenario-4">All</label>
                        <input type="radio" name="scenario" value="1" id="scenario-1" class="no-display"/><label class="radio-button" for="scenario-1">A Single Person</label>
                        <input type="radio" name="scenario" value="2" id="scenario-2" class="no-display"/><label class="radio-button" for="scenario-2">A Single Parent</label>
                        <input type="radio" name="scenario" value="3" id="scenario-3" class="no-display"/><label class="radio-button" for="scenario-3">A Family</label>
                    </fieldset>
                </li>
                <li>
                    <label for="city">Location:</label>
                    <select class="field-box" name="city" id="city"  required="">
                        <option value="all" <?php if(@$_POST['city']=='NULL'){ echo ' selected=""';} ?>>All Cities</option>
                        <?php
                            foreach($cities as $city){
                        ?>
                        <option value="<?php echo $city->id ?>" <?php if(@$_POST['city']==$city->id){ echo ' selected=""';} ?>><?php echo $city->name; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </li>
            </ul>
        </div>
        <div class="col2">
            <ul>
                <?php for($i=1;$i<4;$i++){ 
                    if($i==1){
                        $class = 'display';
                    }else{
                        $class = 'no-display';
                    }?>
                <li>
                    <div class="each-option">
                        <h2>Choice <?php echo $i;?></h2>
                        <div class="option-content <?php echo $class;?>">
                            <ul>
                                <li>
                                    <label class="full-width">Impact of choice</label>
                                    <input type="text" name="en_answer_desc-<?php echo $i; ?>"  value="<?php echo @$_POST['en_answer_desc-'.$i];?>" class="field-box full-width required" placeholder="English Description"/>
                                    <input type="text" name="fr_answer_desc-<?php echo $i; ?>"  value="<?php echo @$_POST['fr_answer_desc-'.$i];?>" class="field-box full-width required" placeholder="French Description"/>
                                </li>
                                <li>
                                    <label class="full-width">Impact of choice cost:</label>
                                    <input type="number" name="en_answer_cost-<?php echo $i; ?>" value="<?php echo @$_POST['en_answer_cost-'.$i];?>"  class="field-box full-width required"/>
                                </li>
                                <!--<li>
                                    <label class="full-width">Option Custom (optional)</label>
                                    <input type="text" name="en_answer_custom-<?php echo $i; ?>"  value="<?php echo @$_POST['en_answer_custom-'.$i];?>" class="field-box full-width" placeholder="English optional"/>
                                    <input type="text" name="fr_answer_custom-<?php echo $i; ?>"  value="<?php echo @$_POST['fr_answer_custom-'.$i];?>" class="field-box full-width" placeholder="French optional"/>
                                </li>-->
                                <li>
                                    <label class="full-width">Consequence Results</label>
                                    <textarea style="min-height: 50px;" name="en_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="English Results"><?php echo @$_POST['en_answer_result-'.$i];?></textarea>
                                    <textarea style="min-height: 50px;" name="fr_answer_result-<?php echo $i; ?>" class="field-box full-width required" placeholder="French Results"><?php echo @$_POST['fr_answer_result-'.$i];?></textarea>
                                </li>
                                <li>
                                    <label class="full-width">End of Game Consequence</label>
                                    <textarea style="min-height: 50px;" name="en_answer_end_game-<?php echo $i; ?>" class="field-box full-width" placeholder="English End of Game Consequence"><?php echo @$_POST['en_answer_end_game-'.$i];?></textarea>
                                    <textarea style="min-height: 50px;" name="fr_answer_end_game-<?php echo $i; ?>" class="field-box full-width" placeholder="French End of Game Consequence"><?php echo @$_POST['fr_answer_end_game-'.$i];?></textarea>
                                </li>
                                <li>
                                    <label class="full-width">Consequence Hidden Cost:</label>
                                    <input type="number"  placeholder = "use {extrafee}" name="extra_cost-<?php echo $i; ?>" value="<?php echo @$_POST['extra_cost-'.$i];?>"  class="field-box full-width"/>
                                </li>
                                <li>
                                    <label class="full-width" title="Stress level has no impact on game play just moves the stress meter to add drama">Stress Level</label>
                                    <select name="en_answer_stress-<?php echo $i; ?>" class="field-box full-width">
                                        <option value="1">Low</option>
                                        <option value="2">Middle</option>
                                        <option value="3">High</option>
                                        <option value="4">Critical</option>
                                    </select>
                                </li>
                                <li>                                    
                                    <input type="checkbox" name="en_answer_strike-<?php echo $i; ?>" style="float:left; margin:4px 5px 0 0;" value="1"/>
                                    <label class="full-width" title="3 strikes you are out!">Work Strike</label>
                                </li>
                                <li>
                                    <input type="checkbox" class="show_help" name="en_answer_show_help-<?php echo $i; ?>" style="float:left; margin:4px 5px 0 0;" value="1"/>
                                    <label class="full-width" title="">United Way is here to help </label>
                                </li>
                                <li id="en_answer_show_help-<?php echo $i; ?>" style="display: none">
                                    <label class="full-width">Supporting program or service</label>
                                    <textarea style="min-height: 50px;" name="en_answer_facts-<?php echo $i; ?>" class="field-box full-width" placeholder="English program or service"><?php echo @$_POST['en_answer_facts-'.$i];?></textarea>
                                    <textarea style="min-height: 50px;" name="fr_answer_facts-<?php echo $i; ?>" class="field-box full-width" placeholder="French program or service"><?php echo @$_POST['fr_answer_facts-'.$i];?></textarea>
                                </li>
                                <li>
                                    <label class="full-width" style="width:100%;">Deferred Needs</label>
                                    <fieldset class="left">
                                        <input type="radio" name="defered_credit-<?php echo $i; ?>" value="1" id="defered_credit-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_credit-1-<?php echo $i; ?>">Credit</label>
                                        <input type="radio" name="defered_credit-<?php echo $i; ?>" value="2" id="defered_credit-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_credit-2-<?php echo $i; ?>">Remove Credit</label>
                                    </fieldset>
                                    <fieldset class="left">
                                        <input type="radio" name="defered_bills-<?php echo $i; ?>" value="1" id="defered_bills-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_bills-1-<?php echo $i; ?>">Bills(utillity)</label>
                                        <input type="radio" name="defered_bills-<?php echo $i; ?>" value="2" id="defered_bills-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_bills-2-<?php echo $i; ?>">Remove Bills</label>
                                    </fieldset>
                                    <fieldset class="left">    
                                        <input type="radio" name="defered_car-<?php echo $i; ?>" value="1" id="defered_car-1-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_car-1-<?php echo $i; ?>">Car</label>
                                        <input type="radio" name="defered_car-<?php echo $i; ?>" value="2" id="defered_car-2-<?php echo $i; ?>" class="no-display"/><label class="radio-button" for="defered_car-2-<?php echo $i; ?>">Remove Car</label>
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
                <input type="submit" name="add" class="button-box edit" value="Add Question"/>
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
            error.push({'error':'You have to select at least two consequence for this question!'});
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