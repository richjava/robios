<h2>
    <i class="fa fa-user"></i> Users
</h2>

<?php
include APPPATH.'views/partials/flashes.php';
if ($items):?>
<?php
include APPPATH.'views/partials/item_list.php';
?>
<?php else: ?> 
<p>There are no users</p>
<?php endif; ?> 