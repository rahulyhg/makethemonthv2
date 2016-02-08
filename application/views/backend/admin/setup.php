<div class="header-title">
    <h2><?php echo $city->name; ?> Administration</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="content content--form">
    <form action="" method="POST">
        <ul>
            <?php if(isset($message_type)){ ?>
                <li>
                    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
                </li>
            <?php }?>
            <li>
                <label>Do more with United Way:</label>
                <fieldset class="left">
                    <input type="url" name="do-more" value="<?php echo $city->do_more; ?>" required="" class="field-box" placeholder="Do more with United Way"/>
                </fieldset>
            </li>
            <li>
                <label>Get your Company Involved:</label>
                <fieldset class="left">
                    <input type="url" name="involved" value="<?php echo $city->involved; ?>" required="" class="field-box" placeholder="Get your Company Involved"/>
                </fieldset>
            </li>
            <li>
                <label>Invest in Poverty:</label>
                <fieldset class="left">
                    <input type="url" name="invest" value="<?php echo $city->invest; ?>" required="" class="field-box" placeholder="Invest in Poverty"/>
                </fieldset>
            </li>
            <li>
                <label>Donate URL:</label>
                <fieldset class="left">
                    <input type="url" name="url-donate" value="<?php echo $city->url_donate; ?>" required="" class="field-box" placeholder="Donate URL"/>
                </fieldset>
            </li>
            <li>
                <label>City Facts:</label>
                <fieldset class="left">
                    <textarea style="min-height: 100px;" required="" class="field-box" name='en_city-facts' maxlength="145" placeholder="English City Facts (max 144 characters)"><?php echo $city->en_facts; ?></textarea>
                    <textarea style="min-height: 100px;" required="" class="field-box" name='fr_city-facts' maxlength="145" placeholder="French City Facts (max 144 characters)"><?php echo $city->fr_facts; ?></textarea>
                    <p class="required-field">(144 Characters max)</p>
                </fieldset>
            </li>
            <li>
                <input type="submit" name="update" class="button-box edit" value="Save"/>
            </li>
        </ul>
    </form>
</div>