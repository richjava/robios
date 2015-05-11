<?php include 'news_nav.php';?>
<h2>
    <i class="fa fa-newspaper-o"></i> News stories
</h2>


<?php
include APPPATH.'views/partials/flashes.php';
if ($items):?>
<?php
include APPPATH.'views/partials/item_list.php';
?>
<?php else: ?> 
<p>There are no news stories.</p>
<a href="news_items/add_edit" class="btn btn-lg btn-success"><i class="fa fa-plus-square"></i> ADD A NEWS STORY</a>
<?php endif; ?> 