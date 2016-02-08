<section class="scenario--single" style="opacity:1">
    <div>
        <div class="title-content">
            <img src='<?php echo WEBSITE_URL . $scenario[0]->icon_2; ?>'/>

            <h3 class="red-text bolder"><?php
                echo $lng == 'english' ? $scenario[0]->en_name : $scenario[0]->fr_name;
                ?></h3>
        </div>
        <p class="white-text"><?php
            $result = $lng == 'english' ? $scenario[0]->en_paragraph : $scenario[0]->fr_paragraph;
            if (strpos($result, '{location}')) {
                $result = str_replace('{location}', $city->name, $result);
            }
            echo $result;
            ?></p>

        <div class="button-box red white-text" id="rent-scene"><?php echo $this->lang->line('play'); ?></div><br>
        <div class="reload-button" onclick="window.location.reload();"><?php echo $this->lang->line('back'); ?></div>
    </div>
</section>