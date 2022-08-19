<?php

	//mkdir.php

	if(isset($_POST['foldername']))
	{
		$dirname = $_POST['foldername'];
		
		if (strpbrk($dirname, "\\/?%*:|\"<>") === FALSE) {
			if (!is_dir($dirname)) {
				mkdir($dirname);
			}
		}

		//echo 'success';
	}

?>
