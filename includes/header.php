<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8" />
		<link rel="icon" href="includes/img/logo.png" type="image/png"/>
        <title>Camagru</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
		<?php if(Session::getInstance()->hasFlashes()): ?>
				<?php 
				foreach(Session::getInstance()->getFlashes() as $type => $message): ?>
					<div id='alert' class="alert alert-<?= $type; ?>">
							<?= $message; ?>
						</div>
						<?php endforeach; ?>
						<?php endif; ?>
						<div class="container">
							<header>
								<div id="header">			
									<div id="logo">
										<a href="index.php"><img id="logo-img" src="includes/img/logo.png" title="Camagru" alt="Camagru"></a>
									</div>
									<a href="index.php"><h1 id="big-title">CAMAGRU</h1></a>
									<div class="navbar">
										<li><a href="index.php">Gallery</a></li>
										<?php if (isset($_SESSION['auth'])):?>
										<li><a href="upload.php?tab=webcam">Studio</a></li>
										<li><a href="account.php">account</a></li>
										<li><a href="logout.php">logout</a></li>
										<?php else: ?>
										<li><a href="register.php">register</a></li>
										<li><a href="login.php">login</a></li>
										<?php endif; ?>
									</div>
								</div>
							</header>
							
							<div class="body">
								
<?php if(Session::getInstance()->hasFlashes()){ ?>
<script>
	window.onload = function()
	{
	setTimeout(function()
	{
		document.getElementById("alert").style.display = "none";
	}, 3000);
	}
</script>
<?php } ?>
