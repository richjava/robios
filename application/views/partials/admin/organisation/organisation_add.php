<?php
include 'organisation_nav.php';
$action = $is_edit ? 'Add' : 'Edit';
$icon = $is_edit ? 'fa fa-plus-square' : 'fa fa-pencil';
?>   
<h2><i class="<?php echo $icon; ?>"></i> <?php echo $action; ?> organisation</h2>
<?php if (!$is_edit): ?>
    <p class="blurb">A token will also be created.</p>
<?php endif; ?>
<?php echo form_open(); ?>
<div class="form-group">
    <?php
    echo form_label('Organisation Name', 'organisation_name');
    $title_data = array(
        'name' => 'organisation_name',
        'value' => $item->name,
        'class' => 'form-control'
    );
    echo form_input($title_data);
    ?>
</div>
<div class="form-group">
    <?php
    echo form_label('Status', 'status');
    if ($item->status === 'Pending') {
        $title_data = array(
            'name' => 'status',
            'value' => $item->status
        );
        ?>
        <div>
            <div class="<?php echo strtolower($item->status)?>">Pending</div>
            
            <?php
            echo form_checkbox($title_data) . ' Send an email to the business with a link to register account';
            ?>
        </div>
        <?php
    } else {
        echo '<div class="'.strtolower($item->status).'">' . $item->status . '</div><input type="hidden" value="Active"/>';
    }
    ?>

</div>

<?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-primary', 'value' => $action . ' organisation')); ?>
<?php
echo form_close();
