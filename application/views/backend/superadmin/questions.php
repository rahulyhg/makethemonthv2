<div class="header-title">
    <h2>Common Questions</h2>
</div>
<div class="content content--list">
    <div class="action"><a href="<?php echo WEBSITE_URL;?>superadmin/questions/new"  class="button-box view no-right">New Common Question</a></div>
    <?php if(isset($message_type)){ ?>
    <div class="msg <?php echo @$message_type; ?>"><p><?php echo @$message; ?></p></div>
    <?php }?>
    <ul>
        <li class="header">
            <div class="no">ID</div>
            <div class="long-text">Question</div>
            <div class="for-city has-filter">
                <span>Type <i class="fa fa-tasks"></i></span>
                <div class="filter">
                    <select class="field-box" id="filter-type">
                        <option value="" id="default" disabled="" selected="">Choose Scenario</option>
                        <option value="all">All</option>
                        <?php 
                            foreach($types as $type){
                        ?>
                        <option value="<?php echo $type->id; ?>"><?php echo ucfirst(strtolower($type->en_name));?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <div class="reset-filter" id="filter-type" title="Reset Filter"><i class="fa fa-times-circle"></i></div>
                </div>
            </div>
            <div class="for-city  has-filter">
                <span>City <i class="fa fa-tasks"></i></span>
                <div class="filter">
                    <select class="field-box" id="filter-city">
                        <option value="" id="default" disabled="" selected="">Choose City</option>
                        <option value="all">All Cities</option>
                        <?php
                            foreach($cities as $city){
                        ?>
                        <option value="<?php echo $city->id ?>"><?php echo $city->name; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <div class="reset-filter" id="filter-city" title="Reset Filter"><i class="fa fa-times-circle"></i></div>
                </div>
            </div>
            <div class="options">Options</div>
        </li>
    </ul>
    <ul id="question-content">
        <?php $i=($current_page-1)*15+1;
            foreach($questions as $question){
            if($i%2==0){
                $class = 'even';
            }else{
                $class = '';
            }
        ?>
        <li class="<?php echo $class;?>">
            <div class="no"><?php echo $question->id; ?></div>
            <div class="long-text"><?php echo $question->en_name; ?></div>
            <div class="for-city has-filter"><?php echo $question->scenario; ?></div>
            <div class="for-city has-filter"><?php echo $question->city; ?></div>
            <div class="options">
                <a href="<?php echo WEBSITE_URL.'superadmin/questions/edit/'.$question->id; ?>" class="button-box edit">Edit</a>
                <a href="<?php echo WEBSITE_URL.'superadmin/questions/delete/'.$question->id; ?>" class="button-box delete">Delete</a>
            </div>
        </li>
        <?php
            $i++;
            }
        ?>
    </ul>
</div>
<div class="pages"><h4>Page:</h4>
    <ul>
        <?php for($i=1;$i<$pages+1;$i++){
            if($i==$current_page){
                $current = 'select';
            }else{
                $current = '';
            }
        ?>
        <li><a href="<?php echo WEBSITE_URL.'superadmin/questions/page/current/'.$i; ?>" class="button-box page <?php echo $current; ?>"><?php echo $i ?></a></li>
        <?php
        } ?>
    </ul>
</div>