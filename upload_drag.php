<?php
	//upload_drag.php

	if(isset($_FILES['images']))
	{
		for($count = 0; $count < count($_FILES['images']['name']); $count++)
		{
			$new_name = pathinfo($_FILES['images']['name'][$count], PATHINFO_BASENAME);

			move_uploaded_file($_FILES['images']['tmp_name'][$count], 'ToSort/' . $new_name);
		}

		//echo 'success';
	}
?>
