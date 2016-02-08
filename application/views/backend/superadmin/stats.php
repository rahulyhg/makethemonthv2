<div class="header-title">
    <h2>Stats Dashboard</h2>
    <h3>Total time played</h3>
</div>
<div class="stats-content full-width">
    <div class="full-width">
        <div class="filter-stats full-width">
            <select id="stats-city" data-type="general" class="select-filter-stats">
                <option value="" disabled selected>Select city</option>
                <?php foreach($cities as $city){
                    if($city->status == 1){?>
                    <option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option>
                <?php }} ?>
            </select>
            <select id="stats-scenario" data-type="general" class="select-filter-stats">
                <option value="" disabled selected>Select scenario</option>
                <option value="1">A SINGLE PERSON</option>
                <option value="2">A SINGLE PARENT</option>
                <option value="3">A FAMILY</option>
            </select>
            <select id="stats-status" data-type="general" class="select-filter-stats">
                <option value="" disabled selected>Select Status</option>
                <option value="1">Win</option>
                <option value="2">Lose</option>
                <option value="3">Give Up</option>
            </select>
            <button id="stats-reset" class="reset-filter-stats"><i class="fa fa-times"></i> Reset filter</button>
        </div>
        <div class="chart full-width" id="dashboard-home-lose-win"></div>
    </div>

</div>