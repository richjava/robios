<div class="container" style="width:100%">
    <!--    <h2 style="text-align: center;">
            <i class="fa fa-ticket"></i> Coupons
        </h2>-->

    <?php if ($items): ?>
        <?php
        include '/../partials/item_list.php';
        ?>
    <?php else: ?> 
        <p>There are no coupons</p>
    <?php endif; ?> 
</div>
<script>
    $(document).ready(function ($) {
        $(".table > tbody > tr").click(function () {
            var tr = $(this);
            tr.css("background", "blue");
            window.location = "/coupon_notifications/detail/" + tr.attr("data");
        });
    });
</script>