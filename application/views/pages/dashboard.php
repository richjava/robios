<div id="main-wrapper" class="container">
    <section id="dashboard"> 
        <h1><i class="fa fa-tachometer"></i> Notifications Dashboard</h1>
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?= $coupons_main_nav_class ?>"><a class="page-scroll" href="<?php echo base_url(); ?>dashboard/coupons"><i class="fa fa-ticket"></i> COUPONS</a></li>
            <li role="presentation" class="<?= $deals_main_nav_class ?>"><a class="page-scroll" href="<?php echo base_url(); ?>dashboard/deals"><i class="fa fa-certificate"></i> DEALS</a></li>
            <li role="presentation" class="<?= $news_main_nav_class ?>"><a class="page-scroll" href="<?php echo base_url(); ?>dashboard/news_items"><i class="fa fa-newspaper-o"></i> NEWS</a></li>
        </ul>

        <div style="padding:20px">
            <?php $this->load->view($content); ?>
        </div>

    </section>
</div>
