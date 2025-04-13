<?php 
		
		if (!empty($msg)) {
			echo "<div class='alert alert-success' style='background:green;color:white;'>".$msg."</div>";
		} else {
			redirect(site_url("airlines"));
		}


?>