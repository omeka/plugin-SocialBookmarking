
<div id="socialServices">

<p>Choose which social bookmarking services you would like to use on your site</p>

<?php $socialBookmarkingServices = social_bookmarking_get_services();

foreach($socialBookmarkingServices as $service => $value): ?>

<label class="<?php echo $service; ?>">
	
	<?php  echo get_view()->formCheckbox( array('name'=> $service, 'id'=> $service),$value,null,array('0','1')); ?>
	<?php $site = social_bookmarking_get_service_props($service); ?>
	<img src="<?php echo img($site->img); ?>" /> <?php echo $service; ?></label>

<?php endforeach; ?>

</div>

