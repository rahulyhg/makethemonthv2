<div class="header-title">
    <h2><?php echo $city->name; ?> Dashboard</h2>
    <p><?php echo @$messages->content; ?></p>
</div>
<div class="header-title">
    <h2>Latest Stats</h2>
</div>
<div class="charts-content">
    <div class="win-loose-giveup">
        <h3><strong>Win / Lose / Give Up</strong> Stats for <?php echo $city->name; ?> <em>(Total time played:<span id="total-play"></span>)</em></h3>
        <div class="chart" id="dashboard-home"></div>
    </div>
</div>