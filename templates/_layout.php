<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Is this is an MVC?</title>
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style>body {padding-top: 50px}</style>
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      
          <a class="brand" href="/">Is this is an MVC?</a>
      
          <div class="nav-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="/index.php?page=posts">Posts</a></li>
              <li><a href="/index.php?page=static">About</a></li>
              <li><a href="/index.php?page=contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">

    <?php echo $contents ?>

    </div>
  </body>
</html>
