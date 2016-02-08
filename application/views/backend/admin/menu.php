<nav>
    <ul class="primary-menu">
        <li class="level level--0">
            <a href="<?php echo WEBSITE_URL.$access; ?>/setup">City Setup</a>
            <ul class="sub-menu">
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$city->m_code.'/demo'; ?>" target="_blank">Preview City</a></li>
            </ul>
        </li>
        <li class="level level--0">
            <a href="<?php echo WEBSITE_URL.$access; ?>/scenario">Scenario Setup</a>
        </li>
        <li class="level level--0">
            <a href="<?php echo WEBSITE_URL.$access; ?>/questions">Questions Setup</a>
            <ul class="sub-menu">
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/custom-questions">Custom Questions</a></li>
                <!--<li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/grocery">Grocery Scene</a></li>
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/rent">Rent Set Up</a></li>-->
            </ul>
        </li>        
        <li class="level level--0">
            <a href="<?php echo WEBSITE_URL.$access; ?>/stats">View Stats</a>
            <ul class="sub-menu">
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/stats/paths">Paths</a></li>
            </ul>
        </li>
        <li class="level level--0">
            <a href="<?php echo WEBSITE_URL.$access; ?>/help">Help</a>
            <ul class="sub-menu">
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/help/support">Contact Support</a></li>
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/help">Documentation</a></li>
                <li class="level level--1"><a href="<?php echo WEBSITE_URL.$access; ?>/help/tutorial">Tutorial</a></li>
            </ul>
        </li>
    </ul>
</nav>