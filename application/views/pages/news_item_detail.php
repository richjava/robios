<section>
    <div class="container">
	<div id="detail-content" class="row detail-news">
	    <div class="col-sm-6 col-sm-offset-3">
		<h4><i class="fa fa-newspaper-o"></i> News</h4>
		<h3><?php echo $item->title ?></h3>
		<p><small>Published on <?php echo date( 'g:ia, d F Y', strtotime($item->date_created));  ?></small></p>
                <?php if($item->image_url): ?>
                <div>
                    <img  class="img-responsive" src="https://s3-ap-southeast-2.amazonaws.com/robios.com-dev/<?php echo $item->image_url; ?>_lrg"/>
                </div>
                <?php endif; ?>
		<div><p><?php echo $item->content ?></p></div>
	    </div>	    
	</div>
    </div>
</section>
