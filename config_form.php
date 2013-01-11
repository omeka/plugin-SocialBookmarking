<p><?php echo __('Choose which social bookmarking services you would like to use on your site.'); ?></p>
<?php
	$services = social_bookmarking_get_services();	
	$serviceSettings = social_bookmarking_get_service_settings();
?>
<?php foreach($services as $serviceCode => $serviceInfo): ?>
	<?php	
		if (array_key_exists($serviceCode, $serviceSettings)) {
			$value = $serviceSettings[$serviceCode];
		} else {
			$value = false;
		}
	?>
	<div class="inputs five columns omega">
	<?php echo get_view()->formCheckbox($serviceCode, true, array('checked'=>(boolean)$value)); ?>
	<img src="<?php echo $serviceInfo['icon']; ?>" /> <?php echo _($serviceInfo['name']); ?>
	</div>
<?php endforeach; ?>
