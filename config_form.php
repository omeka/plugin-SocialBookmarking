<h3>Social Bookmarking Services</h3>
<p>Choose which social bookmarking services you would like to use on your site</p>

<?php $socialBookmarkingServices = unserialize(get_option('social_bookmarking_services')); 
foreach($socialBookmarkingServices as $service => $value): ?>

<label class="<?php echo $service; ?>">
	
	<?php echo checkbox(array('name'=> $service, 'id'=> $service), $value); ?>
	   
	<?php echo $service; ?></label>

<?php endforeach; ?>