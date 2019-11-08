<?php

    require_once 'includes/autoload.php';
    $auth = App::getAuth();
    $db = App::getDatabase();
    $auth->connectFromCookie($db);

?>

<?php

require_once 'includes/header.php';

require_once 'includes/footer.php';


?>