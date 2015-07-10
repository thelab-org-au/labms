	<span class="red">* (required)</span>
    <div class="element">

        <label for="fname">Your first name <span class="red">*</span></label>
		<input id="fname" name="fname" class="text err"  required />
        <span id="fnameVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;First name is required</span>
        
        <br />
        <br />
        <label for="lname">Your surname <span class="red">*</span></label>
		<input id="lname" name="lname" class="text err"  required />
        <span id="lnameVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Surname is required</span>
        
        <?php
            if(isset($mentorForm))
            {
                echo'<br/><br/>';
                echo '<label for="age1">Date of birth<span class="red"> *</span></label>';
    			echo '<input id="age1" name="age1" class="text err" />';
            } 
        ?>   
    </div>
    
    <div class="element"> 

        <label for="phone">Phone <span class="red">*</span></label>
		<input id="phone" name="phone" class="text err"  required />
    </div>
    <div class="element">  
        <label for="address">Address <span class="red">*</span></label>
		<input id="address" name="address" class="text err" required /> 
                           
        <br />
        <br />
        <label for="suburb">Suburb <span class="red">*</span></label>
		<input id="suburb" name="suburb" class="text err" required />
        
        <?php
            if(isset($mentorForm))
            {
                echo'<br/><br/>';
                echo '<label for="state">State<span class="red"> *</span></label>';
    			echo '<input id="state" name="state" class="text err" />';
            } 
        ?>
        <br />
        <br />
        <label for="postcode">Postcode <span class="red">*</span></label>
		<input  id="postcode" name="postcode" class="text err" required />
        <span id="postVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode numeric only</span>
        <span id="postVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode entered to long</span>
        
    </div> 
       
    <div class="element">
    		<label for="email">Your Email <span class="red">*</span></label>
		<input id="email" name="email" class="text err" required />
        <span id="emailVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Email is required</span>
        
        <br />
        <br /> 
        <label for="pass">Password (Min length 8) <span class="red">*</span></label>
		<input type="password" id="pass" name="pass" class="text err" required />
        <span id="passVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password is required</span>
        <span id="passVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password minimum length 8</span>
        
        <br />
        <br />
        <label for="passCon">Password confirmation <span class="red">*</span></label>
		<input type="password" id="passCon" name="passCon" class="text err" required />
        <span id="passConVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password confirmation does not match password</span>   
                    
	</div>

<script type="text/javascript">



    $('#parentForm').submit(function()
    {
        return validate();
    })
    
    
    function validate()
    {
       var ids = new Array('#fname','#lname','#email','#pass');
       var mess = new Array('#fnameVal','#lnameVal','#emailVal','#passVal');
       
       //validate required fields
       for(var cnt = 0; cnt < ids.length; cnt++)
       {
           if($(ids[cnt]).val() === '')
           {
                $(mess[cnt]).show();
                $(window).scrollTop($(mess[cnt]).offset().top - 10);
                return false;        
           }
           else
                $(mess[cnt]).hide();        
       }
        
       //validate length of password 
       if($('#pass').val().length < 8)
       {
            $('#passVallength').show();
            $(window).scrollTop($('#passVallength').offset().top - 10);
            return false;        
       }
       else
        $('#passVallength').hide();        
        
       //validate password matches password confirmation 
       if($('#pass').val() !== $('#passCon').val())
       {
            $('#passConVal').show();
            $(window).scrollTop($('#passConVal').offset().top - 10);
            return false;        
       }
       else
        $('#passConVal').hide();
       
       //validate lab has been selected
        if($('#lab').val() === '-1')
        {
            $('#labVal').show();
            $(window).scrollTop($('#lab').offset().top - 10);
            return false;
        }
        else
            $('#labVal').hide();
            
        
        if(!isNumeric($('#postcode').val()))
        {
            $('#postVal').show();
            $(window).scrollTop($('#postcode').offset().top - 10);
            return false;            
        }
        else
            $('#postVal').hide();
        
        if($('#postcode').val().length > 4)
        {
            $('#postVallength').show();
            $(window).scrollTop($('#postcode').offset().top - 10);
            return false;            
        }
        else
            $('#postVallength').hide();
        
        return true;    
    }
    
    function isNumeric(n) 
    {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

</script>    
