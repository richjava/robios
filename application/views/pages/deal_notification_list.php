<div class="container" style="width:100%">
    <h2 style="text-align: center;">
        <i class="fa fa-certificate"></i> Deals
    </h2>

    <?php if ($items): ?>
        <?php
        include '/../partials/item_list.php';
        ?>
    <?php else: ?> 
        <p>There are no deals.</p>
    <?php endif; ?> 
</div>
<script>
   // alert('qwer');
    $("h2").on( "click", function() {
    //alert('hi');
});
    $(function() {
$(".table > tbody > tr").on( "click", function() {
   // alert('hi');
    $(this).css('background-color', '#7ecce8');
    window.location.href = "deal_notifications/detail/1";
});
});
</script>