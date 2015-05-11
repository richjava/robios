<?php include 'organisation_nav.php';?>
<h2>
    <i class="fa fa-building-o"></i> Organisations
</h2>

<?php
include APPPATH.'views/partials/flashes.php';
if ($items):?>
<?php
include APPPATH.'views/partials/item_list.php';
?>
<?php else: ?> 
<p>There are no organisations</p>
<a href="organisations/add_edit" class="btn btn-lg btn-success"><i class="fa fa-plus-square"></i> ADD AN ORGANISATION</a>
<?php endif; ?> 