<?php 

	require_once '../php/app.php'; 
    $app->setPage('explore');
	$app->userLogued();
	require_once '../libs/header.php';
		
?>
<div class="apps"></div>
<?php 
	
	require_once '../libs/footer.php';

?>