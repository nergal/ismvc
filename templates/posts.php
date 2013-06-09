<?php ob_start() ?>

<?php foreach ($posts as $post): ?>
	<div class="media">
		<a class="pull-left" href="/index.php?page=post/<?php echo $post['id'] ?>">
	    	<img class="media-object" src="<?php echo $post['image'] ?>">
	  	</a>
		<div class="media-body">
			<h4 class="media-heading"><a href="/index.php?page=post/<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></h4>
			<?php echo $post['lead'] ?>
		</div>
	</div>
<?php endforeach ?>

<?php
	$contents = ob_get_clean();
	include '_layout.php';
?>