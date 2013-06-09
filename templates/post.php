<?php ob_start() ?>

	<div class="media">
		<h1><?php echo $post['title'] ?></h4>

		<div class="media-body">
			<?php echo $post['body'] ?>
		</div>
	</div>

<?php
	$contents = ob_get_clean();
	include '_layout.php';
?>