<?php
require_once 'includes/autoload.php';
$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);
App::getAuth()->restrict();
$img = new Img();

if(!empty($_POST['submit'])) {
	$_SESSION['file_name'] = "";
	// Error check on files
	if ($_FILES['userfile']['error'] == UPLOAD_ERR_FORM_SIZE || $_FILES['userfile']['error'] == UPLOAD_ERR_INI_SIZE) {
		Session::getInstance()->setFlash('danger', "the image/photo exceeds file size limits");
	}else if ($_FILES['userfile']['error'] == UPLOAD_ERR_NO_FILE) {
		Session::getInstance()->setFlash('danger', "No files have been selected");
	}else if ($_FILES['userfile']['error'] > 0) {
		Session::getInstance()->setFlash('danger', "There was an error loading your photo");
	}else if (mime_content_type($_FILES['userfile']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['userfile']['tmp_name']) != "image/png"){
		Session::getInstance()->setFlash('danger', "Please select a png or jpg file.");
	}else {
		// Create the pic
		$file = $_FILES['userfile']['tmp_name'];
		$frame = $_POST['radio-frame'];
		$_SESSION['file_name'] = $img->applyFrame($file, $frame, $_FILES['userfile']['type'], 1, $db, $_SESSION['auth']->id);
	}
}
if (isset($_POST['upload']) && !empty($_POST['upload'])){
	// Upload pic
	if (!($img->is_dir_empty('db/tmp'))){
		$img->saveFile($_SESSION['file_name'], $db, $_SESSION['auth']->id);
		Session::getInstance()->setFlash('success', "Your photo has been uploaded.");
		App::redirect('upload.php?tab=file');
	}else{
		Session::getInstance()->setFlash('danger', "An error occurred while loading your photo");
		App::redirect('upload.php?tab=file');
	}
} else if (isset($_POST['delete']) && !empty($_POST['delete'])){
	// Delete pic
	$img->delFile($_SESSION['file_name']);
	$_SESSION['file_name'] = "";
	Session::getInstance()->setFlash('success', "Your photo has been deleted");
	App::redirect('upload.php?tab=file');
}
?>

<?php require 'includes/header.php';?>

<h2>Studio</h2>

<menu id=menu_upload>
<a href="upload.php?tab=webcam">upload from webcam</a>
<a href="upload.php?tab=file">upload from files</a></menu>

<div id=workspace>

<?php
	if(!empty($_POST['submit']) && !empty($_FILES)){
		if($_SESSION['file_name'] != ""){
		?>

	<form action="upload_file.php" method="POST" enctype="multipart/form-data" id="fileFormprev">
	<div>
		<img src="db/tmp/<?php echo $_SESSION['file_name']?>" id="img-prev2"/>
		<div>
			<input type="submit" id="submit-file" name="upload" value="upload"/>
			<input type="submit" id="delete-file" name="delete" value="delete"/><br/>
			<a href="upload.php?tab=file" id="reload2">Restart</a>
		</div>
	</div>
	</form>

<?php }
	}
?>

<div id=pics><?php require 'includes/gallery.php';?></div>
</div>
<?php require 'includes/footer.php';?>