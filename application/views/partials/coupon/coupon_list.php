<?php include 'coupon_nav.php';?>
<h2>
    <i class="fa fa-ticket"></i> Coupons
</h2>

<?php
include APPPATH.'views/partials/flashes.php';
if ($items):?>
<?php
include APPPATH.'views/partials/item_list.php';
?>
<?php else: ?> 
<p>There are no coupons.</p>
<a href="<?php echo base_url()?>dashboard/coupons/add_edit" class="btn btn-lg btn-success"><i class="fa fa-plus-square"></i> ADD A COUPON</a>
<?php endif; ?> 