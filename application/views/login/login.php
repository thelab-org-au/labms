<html >
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/login.css" media="screen" />
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
				<form action="<?php echo site_url(); ?>/user/login/login" method="post">
					<label for="login">Email:</label>
					<input id="login" name="login" class="text" />
					<label for="pass">Password:</label>
					<input id="pass" name="pass" type="password" class="text" />
                    
                    <?php $this->load->view('display'); ?>
					<div class="sep"></div>
					<button type="submit" class="ok">Login</button> 
                        <a class="button" href="<?php echo site_url(); ?>/user/reset">Forgotten password?</a>
                        <a class="button" href="<?php echo site_url(); ?>/user/signup">Create account?</a>
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>
