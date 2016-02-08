<div class="header-title">
    <h2>Master Dashboard</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="header-title">
    <h2>Latest Stats</h2>
</div>
<div class="charts-content">
    <div class="col2">
        <h3><strong>Win / Lose / Give Up</strong> Stats <em>(Total time played:<span id="total-play"></span>)</em></h3>
        <div class="chart" id="dashboard-home-lose-win"></div>
    </div>
    <div class="col2">
        <h3><strong>Cities</strong> Stats</h3>
        <div class="chart" id="dashboard-home-cities"></div>
    </div>
</div>