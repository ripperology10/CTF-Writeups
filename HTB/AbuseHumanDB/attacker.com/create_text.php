<?php
	if (isset($_GET['flag'])){
		#$file = $_FILES['file'];
		$content = $_GET['flag'];#"some text here";
		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/flag.txt","wb");
		fwrite($fp,$content);
		fclose($fp);
	}
?>
