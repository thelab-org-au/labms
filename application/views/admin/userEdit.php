
<?php echo form_open('admin/ausers/editUser',array('id' => 'editUserForm')); ?>
    <div class="element">

        <input type="hidden" name="editId" value="<?php echo $user[0]['id']; ?>" />
        <label for="fnameEdit">Your first name</label>
		<input id="fnameEdit" name="fnameEdit" class="text err" value="<?php echo $user[0]['firstName']; ?>"  required="true" />
        <span id="fnameValEdit" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;First name is required</span>

        <br />
        <br />
        <label for="lnameEdit">Your surname</label>
		<input id="lnameEdit" name="lnameEdit" class="text err" value="<?php echo $user[0]['lastName']; ?>"  required="true" />
        <span id="lnameValEdit" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Surname is required</span>

    </div>

    <div class="element">

        <label for="phoneEdit">Phone</label>
		<input id="phoneEdit" name="phoneEdit" class="text err" value="<?php echo $user[0]['phone']; ?>"   />
    </div>
    <div class="element">
        <label for="addressEdit">Address</label>
		<input id="addressEdit" name="addressEdit" class="text err" value="<?php echo $user[0]['address']; ?>" />

        <br />
        <br />
        <label for="suburbEdit">Suburb</label>
		<input id="suburbEdit" name="suburbEdit" class="text err" value="<?php echo $user[0]['suburb']; ?>" />

        <br />
        <br />
        <label for="postcodeEdit">Postcode</label>
		<input  id="postcodeEdit" name="postcodeEdit" class="text err" value="<?php echo $user[0]['postcode']; ?>"  />
        <span id="postValEdit" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode numeric only</span>
        <span id="postVallengthEdit" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode entered to long</span>

    </div>

    <div class="element">
    		<label for="emailEdit">Your Email</label>
		<input id="emailEdit" name="emailEdit" class="text err" value="<?php echo $user[0]['email']; ?>" required="true" />
        <span id="emailValEdit" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Email is required</span>
        <br />
        <br />
			<label for="labEdit"> User type </label>
			<select name="labEdit" class="err" id="labEdit">
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
            <span id="labEditVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please select a user type</span>


            <div id="locationSelect2" style="display:none; width: 225px; max-height: 300px; overflow-y: auto;">
                <br />
                <br />
                <label for="locationEdit"> User locations </label>

                <div style=" width: 225px; max-height: 300px; overflow-y: auto;">
                 <?php foreach($locations as $l) : ?>
                    <?php
                        $selected = '';
                        if(array_key_exists('locations',$user))
                        {

                            if(in_array($l['id'],$user['locations']))
                                $selected = 'checked="checked"';
                        }
                    ?>
                    <p><input type="checkbox" name="location[]"  value="<?php echo $l['id']; ?>" <?php echo $selected; ?>/>&nbsp;&nbsp;<?php echo $l['name']; ?></p>

                <?php endforeach;?>
                </div>


            </div>

        <!--
        <br />
        <br />
        <label for="pass">Password (Min length 8)</label>
		<input type="password" id="pass" name="pass" class="text err" required="true"/>
        <span id="passVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password is required</span>
        <span id="passVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password minimum length 8</span>

        <br />
        <br />
        <label for="passCon">Password confirmation</label>
		<input type="password" id="passCon" name="passCon" class="text err" required="true"/>
        <span id="passConVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password confirmation does not match password</span>
          -->
    </div>
         <button>Submit</button>
         <button id="closeUserEdit">Close</button>

</form>

<script type="text/javascript">
    $('#labEdit').ready(function()
    {

        $('#labEdit').val('<?php echo $user[0]['type']; ?>');

		if($('#labEdit').val() == '5')
       {
            $('#locationSelect2').hide();
       }
       else
       {
            $('#locationSelect2').show();
       }
    });

    $('#labEdit').change(function()
    {

       if($('#labEdit').val() == '5')
       {
            $('#locationSelect2').hide();
       }
       else
       {
            $('#locationSelect2').show();
       }
    });



    $('#closeUserEdit').click(function(e)
    {
       e.preventDefault();
        $('#editUser').hide('fast');
        $('#editUserForm')[0].reset();
        $('#userTableDisplay').show('fast');
        return false;
    });


    $('#editUserForm').submit(function()
    {
        return validate();
    })


    function validate()
    {
       var ids = new Array('#fnameEdit','#lnameEdit','#emailEdit');
       var mess = new Array('#fnameValEdit','#lnameValEdit','#emailValEdit');

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


       //validate lab has been selected
        if($('#labEdit').val() === '-1')
        {
            $('#labEditVal').show();
            $(window).scrollTop($('#labEdit').offset().top - 10);
            return false;
        }
        else
            $('#labEditVal').hide();


        if(!isNumeric($('#postcodeEdit').val()) && $('#postcodeEdit').val() != '' )
        {
            $('#postValEdit').show();
            $(window).scrollTop($('#postcodeEdit').offset().top - 10);
            return false;
        }
        else
            $('#postValEdit').hide();

        if($('#postcodeEdit').val().length > 4)
        {
            $('#postVallengthEdit').show();
            $(window).scrollTop($('#postcodeEdit').offset().top - 10);
            return false;
        }
        else
            $('#postVallengthEdit').hide();

        return true;
    }

    function isNumeric(n)
    {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

</script>
