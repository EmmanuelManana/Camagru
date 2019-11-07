<?php
    require_once 'includes/autoload.php';
    $auth = App::getAuth();
    $db = App::getDatabase();
    $auth->connectFromCookie($db);

?>

<?php  require 'includes/header.php'; ?>

<h2></h2>


<?php  require 'includes/footer.php'; ?>