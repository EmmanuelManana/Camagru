<html>
    <head>
        <title>camagru</title>
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
        <body>

            <div class="container">
                <header>
                    <div id="header">
                        <div id="logo">
                            <a href="index.php"> <img id="logo-image" src="includes/images/logo.jpg" title="camagru" alt="camagru"></a>
                        </div>
                        <a href="index.php"><h1 id="big-title">CAMAGRU</h1></a>

                        <div class="navbar">
                            <li><a href="index.php">Gallery</a></li>
                            <?php   if(isset($_SESSION['auth'])):?>
                                <li><a href="upload.php?tab=webcam">Studio</a></li>
                                <li><a href="account.php">acount</a></li>
                                <li><a href="logout.php">logout</a></li>
                            <?php   else:   ?>
                                <li><a href="register.php">Register</a></li>
                                <li><a href="login.php">Login</a></li>
                            <?php   endif;   ?>
                        </div>
                    </div>
                </header>

