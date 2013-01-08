<p><?php echo __('Choose which social bookmarking services you would like to use on your site.'); ?></p>

<?php $socialBookmarkingServices = social_bookmarking_get_services(); ?>

<?php foreach($socialBookmarkingServices as $service => $value): ?>
	<div class="inputs five columns omega">
	<?php echo get_view()->formCheckbox($service, true, array('checked'=>(boolean)$value)); ?>
	<?php $site = social_bookmarking_get_service_props($service); ?>
	<img src="<?php echo img($site->img); ?>" /> <?php echo _($service); ?>
	</div>
<?php endforeach; ?>
