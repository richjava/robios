<div class="container" style="width:100%">
    <h2 style="text-align: center;">
        <i class="fa fa-newspaper-o"></i> News
    </h2>

    <?php if ($items): ?>
        <?php
        include '/../partials/item_list.php';
        ?>
    <?php else: ?> 
        <p>There are no news stories.</p>
    <?php endif; ?> 
</div>
<script>
    
$(".table > tbody > tr").click(function(){
    var tr = $this;
    $this.css("background","blue");
    window.location = "news_item_notifications/detail/"+tr.attr("data");
});
</script>