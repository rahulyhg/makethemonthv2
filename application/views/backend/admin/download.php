<div class="header-title">
    <h2>Stats</h2>
    <h3>Export players track</h3>
</div>
<div class="content content--form">
    <form action="<?php echo WEBSITE_URL?>admin/generate_json" method="POST" id="support">
        <div class="full-width">
            <ul>
                <li>
                    <label>Scenario:</label>
                    <select name="scenario" class="field-box">
                        <option selected></option>
                        <option value="1">A SINGLE PERSON</option>
                        <option value="2">A SINGLE PARENT</option>
                        <option value="3">A FAMILY</option>
                    </select>
                </li>
                <li>
                    <label>Status:</label>
                    <select name="status" class="field-box">
                        <option selected></option>
                        <option value="1">Win</option>
                        <option value="2">Lose</option>
                        <option value="3">Give Up</option>
                    </select>
                </li>
                <li>
                    <div class="datepicker-content">
                        <div class="col2">
                            <label for="from-date">From</label>
                            <input type="text" value="<?php echo $datepicker['start']; ?>" name="from-date" class="field-box has-datepicker" id="from-date">
                        </div>
                        <div class="col2">
                            <label for="to-date">To</label>
                            <input type="text" value="<?php echo $datepicker['end']; ?>" name="to-date" class="field-box has-datepicker" id="to-date">
                        </div>
                    </div>
                </li>
                <li>
                    <input type="submit" name="export" class="button-box edit" value="Download"/>
                </li>
            </ul>
        </div>
    </form>
</div>