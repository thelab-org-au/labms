<html >
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>New password</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/login.css" media="screen" />
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
                <?php echo validation_errors(); ?>
				<form action="<?php echo site_url(); ?>/user/reset/apply?a=<?php echo $this->input->get('a').'&b='.$this->input->get('b'); ?> " method="post" id="passForm">
					<label for="pass">New password <span style="font-size: 11px;">(Min length 8)</span>:</label>
					<input type="password" id="pass" name="pass" class="text" style="width: 155px;" />
                    <span id="passVallength" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Password minimum length 8</span>
                    
					<label for="passCon">Password confirmation:</label>
					<input type="password" id="passCon" name="passCon" class="text" style="width: 155px;" />
                    <span id="passConVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Passwords do not match</span>  
                    
                    <?php $this->load->view('display'); ?>
                    
					<div class="sep"></div>
					<button type="submit" class="ok">Reset</button>                       
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    $('#passForm').submit(function()
    {
        return validate();
    })
    
    function validate()
    {
       //validate length of password 
       if($('#pass').val().length < 8)
       {
            $('#passVallength').show();
            return false;        
       }
       else
        $('#passVallength').hide();        
        
       //validate password matches password confirmation 
       if($('#pass').val() !== $('#passCon').val())
       {
            $('#passConVal').show();
            return false;        
       }
       else
        $('#passConVal').hide();
        
        return true;        
    }

</script>

</body>
</html>