<div class="header-title">
    <h2>Scenario Edit</h2>
</div>
<div class="content content--form">
    <form action="" method="POST">
        <div class="full-width">
            <ul>
                <?php if(isset($message_type)){ ?>
                <li>
                    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
                </li>
                <?php }?>
                <li>
                    <label>Scenario Name:</label>
                    <fieldset class="left;">
                        <input type="text" readonly="" name="en_name" value="<?php echo $scenario[0]->en_name;?>" class="field-box" placeholder="English Name"/>
                        <input type="text" readonly="" name="fr_name" value="<?php echo $scenario[0]->fr_name;?>" class="field-box" placeholder="French name"/>
                    </fieldset>
                </li>
                <li>
                    <label>Scenario Paragraph:</label>
                    <fieldset class="left;">
                        <textarea name="en_paragraph" style="resize: none;" readonly="" class="field-box textarea"  placeholder="English Paragraph"><?php echo $scenario[0]->en_paragraph;?></textarea>
                        <textarea name="fr_paragraph" style="resize: none;" readonly="" class="field-box textarea"  placeholder="French Paragraph"><?php echo $scenario[0]->fr_paragraph;?></textarea>
                    </fieldset>
                </li>
                <li>
                    <label>Scenario Rent Paragraph:</label>
                    <fieldset class="left;">
                        <textarea name="en_rent_paragraph" style="resize: none;" class="field-box textarea"  placeholder="English Paragraph"><?php echo $scenario[0]->en_rent_paragraph;?></textarea>
                        <textarea name="fr_rent_paragraph" style="resize: none;" class="field-box textarea"  placeholder="French Paragraph"><?php echo $scenario[0]->fr_rent_paragraph;?></textarea>
                    </fieldset>
                </li>
            </ul>
        </div>
        <div class="col2">
            <ul class="has-2-inner">
                <li>
                    <label>Icon 1:</label>
                    <img src="<?php echo WEBSITE_URL.$scenario[0]->icon_1;?>" />
                    <input type="hidden" name="icon_1" value="<?php echo $scenario[0]->icon_1;?>"/>
                </li>
                <li>
                    <label>Icon 2:</label>
                    <img src="<?php echo WEBSITE_URL.$scenario[0]->icon_2;?>" />
                    <input type="hidden" name="icon_2" value="<?php echo $scenario[0]->icon_2;?>"/>
                </li>
            </ul>
            <div class="msg update"><p>You have to update the scenario to save the changes!</p></div>
        </div>
        <div class="col2">
            <ul>
                <li>
                    <label>Start up</label>
                    <input type="number" min="1" max="99999" name="start_up" value="<?php echo $scenario[0]->start_up;?>" required="" class="field-box" placeholder="Start up"/>
                </li>
                <li>
                    <label>Salary:</label>
                    <input type="number" min="1" max="99999" name="salary" value="<?php echo $scenario[0]->salary;?>" required="" class="field-box" placeholder="Salary"/>
                </li>
                <li>
                    <label>Suburbs Rent:</label>
                    <input type="number" min="1" max="99999" name="min-rent" value="<?php echo $scenario[0]->min_rent;?>" required="" class="field-box" placeholder="please enter positive values"/>
                </li>
                <li>
                    <label>Inner City Rent:</label>
                    <input type="number" min="1" max="99999" name="max-rent" value="<?php echo $scenario[0]->max_rent;?>" required="" class="field-box" placeholder="please enter positive values"/>
                </li>
            </ul>
        </div>
        <ul>
            <li>
                <input type="submit" name="update" value="Update Scenario" class="button-box edit"/> 
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
<script src="<?php echo WEBSITE_URL;?>js/colorpicker.js"></script>
<script>
var title;
$('#upload-files').ajaxForm({
    beforeSend: function() {
        $(".overlay-loading").show();
    },
    complete: function(xhr) {
        $('input[name="'+title+'"]').val('uploads/'+xhr.responseText);
        $('input[name="'+title+'"]').siblings('img').attr('src','<?php echo WEBSITE_URL; ?>uploads/'+xhr.responseText);
        $(".overlay-loading").hide();
    }
}); 
$('.has-color').ColorPicker({ 
    onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('.has-color').css('backgroundColor', '#' + hex);
        $('.has-color').val(hex);
	}
});
$(document).ready(function(){
    $('input,textarea').change(function(){
        $('.msg.update').fadeIn(400);
    })
    $('.upload').click(function(){
        title = $(this).attr('id');
        $('#userfile').click();
    })
})
$('#userfile').change(function(){
    $('#upload-files').submit();
})
</script>