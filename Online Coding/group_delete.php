    <?php
		$direc = $_POST['action'];
		$dir=$direc."/";
        $filename = isset($_POST['filename']) ? $_POST['filename'] : false;
        unlink($dir.$filename);
?>