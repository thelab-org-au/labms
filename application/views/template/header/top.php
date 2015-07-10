<div id="top">
	<div class="left">
		<p>Welcome, <strong><?php echo $userName; ?> </strong>[ <a href="<?php echo site_url(); ?>/user/profile">Profile</a> ] [ <a href="<?php echo site_url(); ?><?php echo ($loggedin ? '/user/login/logout ">logout' : '/user/login ">login') ;?></a> ]</p>
	</div>
	<div class="right">
		<div class="align-right">
			<!--<p>Todays date: <strong><?php echo date("d-m-Y"); ?></strong></p>-->
		</div>
	</div>
</div>