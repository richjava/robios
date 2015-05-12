
<?php
include 'coupon_nav.php';
$action = $is_edit ? 'New' : 'Edit';
$icon = $is_edit ? 'fa fa-plus-square' : 'fa fa-pencil';
?>   

<h2><i class="<?php echo $icon; ?>"></i> <?php echo $action; ?> coupon</h2>
<p class="blurb">Coupons let you create deals for your customers and are a great way to entice people to use your business.</p>
    <?php echo validation_errors('<div class="alert alert-danger">', "</div>"); ?>
    <?php echo form_open_multipart(); ?>
<div class="form-group">
    <?php
    echo form_label('Title', 'title');
    $title_data = array(
        'name' => 'title',
        'value' => set_value('title', @$item->title),
        'maxlength' => '107',//pushbots limit is 107
        'class' => 'form-control',
	'placeholder' => 'Write the coupon title here...'
    );
    echo form_input($title_data);
    ?>

</div>
<div class="form-group">
    <?php
    echo form_label('Description', 'content');
    $deal_data = array(
        'name' => 'content',
        'value' => set_value('content', @$item->content),
        'class' => 'form-control',
        'placeholder' => 'Write the body of your coupon here...'
    );
    echo form_textarea($deal_data);
    ?>         
</div>
<div class="form-group">

    <?php echo form_label('Featured image', 'featured_image'); ?>
    <?php
    $image_data = array(
        'name' => 'featured_image',
        'class' => 'form-control'
    );
    echo form_upload($image_data);
            
    ?>
</div>
<div class="form-group">

    <?php echo form_label('Expiry date', 'expiry_date'); ?>
    <?php
    $expiry_data = array(
        'name' => 'expiry_date',
        'value' => set_value('expiry_date', @$item->expiry_date),
        'class' => 'form-control datepicker',
        'placeholder' => 'Choose a date'
    );
    echo form_input($expiry_data);
            
    ?>
</div>
<?php
    $status_data = array(
        'status' => set_value('status', @$item->status)
    );
    echo form_hidden($status_data);
            
    ?>
<button  name="save" type="submit" class="btn btn-default">
    <i class="fa fa-floppy-o"></i> Save
</button>
<?php if (!$item->status || $item->status === "Pending"): ?>
<button name="send_notification" type="submit" value="send_notification" class="btn btn-primary">
    <i class="fa fa-paper-plane"></i> Send notification
</button>
<?php endif; ?>
<?php
echo form_close();
include APPPATH.'views/partials/datepicker.php';
