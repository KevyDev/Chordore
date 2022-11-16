<?php 
    
    if(isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $temporal = $image['tmp_name'];
	    $original = imagecreatefrompng($temporal);
		$file_width = imagesx($original);
        $file_height = imagesy($original);
        $resolution = 600;
        $new_width = $file_width / 1;
        $new_height = $file_height / 1;
		$copy = imagecreatetruecolor($new_width, $new_height);
		imagecolortransparent($copy, imagecolorallocatealpha($copy, 0, 0, 0, 127));
        imagealphablending($copy, true);
        $position_x =  0;
        $position_y = 0;
	    // imagecopyresampled($copy, $original, 0, 0, 0, 0, $new_width, $new_height, $file_width, $file_height);
        imagecopyresampled($copy, $original, $position_x, $position_y, 0, 0, $new_width, $new_height, $file_width, $file_height);
		// $token = md5(uniqid(mt_rand(), false));
        // header("Content-type: image/jpeg");
        imagejpeg($copy, 'marloncalbo.jpeg', 80);
        // $conn_id = ftp_connect('files.chordore.com');
        // $login_result = ftp_login($conn_id, "chordore", "kevinsito") or die("No se pudo conectar a".$conn_id);
        // ftp_pasv($conn_id, true);
        // ftp_put($conn_id, $token.'.jpeg', 'tmp/'.$token.'.jpeg', FTP_BINARY);
        // ftp_close($conn_id);
        // unlink('tmp/'.$token.'.jpeg');
        //$result = file_get_contents('https://files.chordore.com/save.php?filename=foto.jpeg');
        // echo $result;
    } else {

?>
<form method="post" action="" enctype="multipart/form-data">
    <input type="file" name="image" />
    <input type="submit" value="Enviar">
</form>
<?php } ?>