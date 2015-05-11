<?php
//success message
if ($this->session->flashdata('success')):
    ?>
    <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php
//error message
if ($this->session->flashdata('error')):
    ?>
    <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?> 