<?php ob_start() ?>

<h2>Contact form</h2>
<div class="span12">
  <?php if ($send): ?>
    <div class="alert alert-success">
      Success!
    </div>
  <?php endif ?>
  <form method="post">
      <div class="controls controls-row">
          <input id="name" name="name" type="text" class="span6" placeholder="Name"> 
          <input id="email" name="email" type="email" class="span6" placeholder="Email address">
      </div>
      <div class="controls">
          <textarea id="message" name="message" class="span12" placeholder="Your Message" rows="5"></textarea>
      </div>
      
      <div class="controls">
          <button id="contact-submit" type="submit" class="btn btn-primary input-medium pull-right">Send</button>
      </div>
  </form>
</div>

<?php
	$contents = ob_get_clean();
	include '_layout.php';
?>
