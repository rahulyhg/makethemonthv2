<div class="header-title">
    <h2>Scenario Administration</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="content content--list">
    <ul>
        <li class="header">
            <div class="no">No.</div>
            <div class="name">Scenario Name</div>
            <div class="status">Start up</div>
            <div class="status">Salary</div>
            <div class="status"></div>
            <div class="status-city"></div>
        </li>
        <?php
            $i=1;
            foreach($scenarios as $scenario){
                if($i%2==0){
                    $class = 'even';
                }else{
                    $class = '';
                }
        ?>
        <li class="<?php echo $class; ?>">
            <div class="no"><?php echo $i; ?></div>
            <div class="name"><?php echo $scenario->en_name; ?></div>
            <div class="status" style="text-align: right;"><?php echo '$ '.$scenario->start_up; ?></div>
            <div class="status" style="text-align: right;"><?php echo '$ '.$scenario->salary; ?></div>
            <div class="status"></div>
            <div class="status-city right"><a href="<?php echo WEBSITE_URL;?>superadmin/scenario/edit/<?php echo $scenario->id?>" class="button-box edit">Edit Scenario</a></div>
        </li>
        <?php
        $i++;
            }
        ?>
    </ul>
</div>