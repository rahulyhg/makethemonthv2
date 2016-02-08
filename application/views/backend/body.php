<section>
    <div class="container">
        <div class="side-bar">
            <?php $this->load->view($structure.'/'.$access.'/menu'); ?>
        </div>
        <div class="main-content">
        <?php 
            $this->load->view($structure.'/'.$access.'/'.$template);
        ?>
        </div>
    </div>
</section>