<section class="scenario" style="opacity:1">
    <div>
        <h1 class="small bolder white-text"><?php echo $this->lang->line('header_scenarion'); ?></h1>

        <div class="boxie boxie--no-3">
            <?php
            foreach ($scenarios as $scenario) {
                if ($lng == 'english') {
                    $name = $scenario->en_name;
                } else {
                    $name = $scenario->fr_name;
                }
                $name = explode(' ', $name);
                unset($name[0]);
                $name = implode(' ', $name);
                ?>
                <div class="each-box" data-id="<?php echo $scenario->id; ?>">
                    <div class="inner-box">
                        <div class="icon-box">
                            <img src="<?php echo WEBSITE_URL . $scenario->icon_1; ?>">
                        </div>
                        <h3 class="small"><?php echo $name ?></h3>

                        <div class="button-border no-display"><?php echo $this->lang->line('choose'); ?></div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>