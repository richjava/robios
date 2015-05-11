<div id="main-wrapper" class="container">
    <?php if($this->session->userdata('is_logged_in') && $this->session->userdata('user_role')==="Super Admin"):?>
    <section id="dashboard"> 
        <h1><i class="fa fa-user-secret"></i> Admin</h1>
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?= $users_main_nav_class ?>"><a class="page-scroll" href="<?php echo base_url(); ?>admin/users"><i class="icon-user"></i> Users</a></li>
            <li role="presentation" class="<?= $organisations_main_nav_class ?>"><a class="page-scroll" href="<?php echo base_url(); ?>admin/organisations"><i class="fa fa-building-o"></i> ORGANISATIONS</a></li>
        </ul>

        <div style="padding:20px">
            <?php $this->load->view($content); ?>
        </div>

    </section>
    <?php     else: ?>
    <div style="margin:200px 0;text-align: center;">
    <p>You are not authorised to enter this area.</p>
    </div>
    <?php     endif; ?>
</div>