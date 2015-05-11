<?php include 'deal_nav.php';?>
<h2>
    <i class="fa fa-certificate"></i> Deals
</h2>


<?php
include APPPATH.'views/partials/flashes.php';
if ($items):?>
<?php
include APPPATH.'views/partials/item_list.php';
?>
<?php else: ?> 
<p>There are no deals.</p>
<a href="deals/add_edit" class="btn btn-lg btn-success"><i class="fa fa-plus-square"></i> ADD A DEAL</a>
<?php endif; ?> 