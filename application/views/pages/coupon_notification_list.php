<div class="container" style="width:100%">
    <!--    <h2 style="text-align: center;">
            <i class="fa fa-ticket"></i> Coupons
        </h2>-->

    <?php if ($items): ?>
    <table class="table">
<thead>
<tr>
<th class='col-sm-8'>Title</th><th class='col-sm-2'>Start Date</th><th class='col-sm-2'>End Date</th></tr>
</thead>
<tbody>
<tr>
<td>ewrwe</td><td>20/05/2015</td><td>20/05/2015</td></tr>
<tr>
<td>ewrwe</td><td>20/05/2015</td><td>20/05/2015</td></tr>
<tr data-id="4">
<td>asd</td><td>20/05/2015</td><td>20/05/2015</td></tr>
<tr>
<td>ewrwe</td><td>20/05/2015</td><td>20/05/2015</td></tr>
<tr>
<td>wer</td><td>20/05/2015</td><td>20/05/2015</td></tr>
</tbody>
</table>
        <?php
        
        //include '/../partials/item_list.php';
        ?>
    <?php else: ?> 
        <p>There are no coupons</p>
    <?php endif; ?> 
</div>
<script>
    $(document).ready(function ($) {
//        $(".table-striped").find('tr[data-target]').on('click', function(){
//        //or do your operations here instead of on show of modal to populate values to modal.
//         $('#orderModal').data('orderid',$(this).data('id'));
//    });
//        
//        
//        $(".table > tbody > tr").click(function () {
//            var tr = $(this);
//            tr.css("background", "blue");
//            window.location = "/coupon_notifications/detail/" + tr.data('id');
//        });
    });
</script>