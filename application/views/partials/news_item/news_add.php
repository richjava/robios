<?php
include 'news_nav.php';
$action = $is_edit ? 'Add' : 'Edit';
$icon = $is_edit ? 'fa fa-plus-square' : 'fa fa-pencil';
?>
<h2><i class="<?php echo $icon; ?>"></i> <?php echo $action; ?> news story</h2>
<p class="blurb">News items keep your customers updated with what's going on at your business. To give users a sense of getting value from their app, use coupons and deals more than news items.</p>
<?php echo validation_errors(); ?>
<?php echo form_open_multipart(); ?>
<div class="form-group">
    <?php
    echo form_label('Title', 'title');
    $title_data = array(
	'name' => 'title',
	'value' => set_value('title', @$item->title),
	'maxlength' => '107', //pushbots limit is 107
	'class' => 'form-control',
	'placeholder' => 'Write the title here...'
    );
    echo form_input($title_data);
    ?>

</div>
<div class="form-group">
    <?php
    echo form_label('Content', 'content');
    $content_data = array(
	'name' => 'content',
	'value' => set_value('content', @$item->content),
	'class' => 'form-control',
	'placeholder' => 'Write breaking news about your business here...'
    );
    echo form_textarea($content_data);
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
<?php
$status_data = array(
    'status' => set_value('status', @$item->status)
);
echo form_input($status_data);
?>
<button  name="save" type="submit" class="btn btn-default">
    <i class="fa fa-floppy-o"></i> Save
</button>
<?php if (!$item->status || $item->status === "Pending"): ?>
<button  name="send_notification" type="submit" value="send_notification" class="btn btn-primary">
    <i class="fa fa-paper-plane"></i> Send notification
</button>
<?php endif; ?>
<?php echo form_close(); ?>   