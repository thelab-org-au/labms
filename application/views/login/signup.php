<html >
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Signup</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/login.css" media="screen" />
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
                <?php echo validation_errors(); ?>
				<form action="<?php echo site_url(); ?>/user/signup/process" method="post">
                    
                    <?php $this->load->view('forms/baseform'); ?>
                    
                    <!--
                    
 					<label for="fname">First name:</label>
					<input id="fname" name="fname" class="text" value="<?php if(isset($userData['firstName'])) echo $userData['firstName'];?>" /> 
                    
 					<label for="lname">Last name:</label>
					<input id="lname" name="lname" class="text" value="<?php if(isset($userData['lastName'])) echo $userData['lastName'];?>"/>  
                    
					<label for="email">Username/Email:</label>
					<input id="email" name="email" class="text" value="<?php if(isset($userData['email'])) echo $userData['email'];?>" />                                 
                    
					<label for="pass">Password:</label>
					<input id="pass" name="pass" type="password"  class="text" value="<?php if(isset($userData['password'])) echo $userData['password'];?>"/>
                    
					<label for="pass2">Password confirm:</label>
					<input id="pass2" name="pass2" type="password"  class="text" value="<?php if(isset($userData['password2'])) echo $userData['password2'];?>"/>
                    <div class="sep"></div>
                    -->
                    <?php $this->load->view('display'); ?>
                    
					
                    <br />
					<button type="submit" class="ok">Create</button>
                        <a class="button" href="<?php echo site_url(); ?>/user/login/">Login?</a>
                        <a class="button" href="<?php echo site_url(); ?>/user/reset/">Forgotten password?</a>
                    
                        
				</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>