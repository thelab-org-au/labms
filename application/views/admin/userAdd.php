	<span class="red">* (required)</span>
    <div class="element">

        <label for="fname">First name <span class="red">*</span></label>
		<input id="fname" name="fname" class="text err"  required="true" />
        <span id="fnameVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;First name is required</span>
        
        <br />
        <br />
        <label for="lname">Surname <span class="red">*</span></label>
		<input id="lname" name="lname" class="text err"  required="true" />
        <span id="lnameVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Surname is required</span>
 
    </div>

       
    <div class="element">
    		<label for="email">Email <span class="red">*</span></label>
		<input id="email" name="email" class="text err" required="true" />
        <span id="emailVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Email is required</span>
        
        <br />
        <br /> 
        <label for="pass">Password (Min length 8) <span class="red">*</span></label>
		<input type="password" id="pass" name="pass" class="text err" required="true"/>
        <span id="passVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password is required</span>
        <span id="passVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password minimum length 8</span>
        
        <br />
        <br />
        <label for="passCon">Password confirmation <span class="red">*</span></label>
		<input type="password" id="passCon" name="passCon" class="text err" required="true"/>
        <span id="passConVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password confirmation does not match password</span> 
         
        <br />
        <br />
			<label for="lab"> User type <span class="red">*</span></label>
			<select name="lab" class="err" id="lab">
				<option value="-1">-Select type-</option>
                
                <?php 
                    foreach($userTypes as $type)
                    {
                        $u = $this->session->userdata('user');
                        if((int)$u['type'] >= (int)$type['id'])
                            echo '<option value="'.$type['id'].'">'.$type['type'].'</option>'; 
                    }
                ?>
                
			</select>
            <span id="labVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please select a user type</span>         
                    
	</div>
    
                <div id="locationSelect" style="display: none;">
                <br />
                <br />
                <label for="locationEdit"> User locations </label>
                
                <div style=" width: 225px; max-height: 300px; overflow-y: auto;">
                 <?php foreach($locations as $l) : ?>

                    <p><input type="checkbox" name="location[]"  value="<?php echo $l['id']; ?>" />&nbsp;&nbsp;<?php echo $l['name']; ?></p>
                    
                <?php endforeach;?>               
                </div>
                

            </div>
    
    
    <button id="addUserSubmit" class="add" >Add</button>
    <button id="addUserClose" >Close</button>

<script type="text/javascript">


    $('#usersForm').submit(function()
    {
        return validate();
    })

    $('#lab').change(function()
    {
       if($('#lab').val() == '5')
       {
            $('#locationSelect').hide(); 
       }
       else
       {
            $('#locationSelect').show();  
       }
    });
    
    
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

        
        return true;    
    }
    
    function isNumeric(n) 
    {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

</script>    
