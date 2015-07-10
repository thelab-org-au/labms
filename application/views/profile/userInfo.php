<div id="userInfoDisplay" >
    <h2>User details</h2>
    <?php echo form_open('user/profile/updateUser/',array('id' => 'updateUserForm')); ?>
        <?php //var_dump($userData);?>
        <div class="element">
            <input type="hidden" name="userId" value="<?php echo $userData['id'] ?>" />
            <label for="fname">Your first name</label>
    		<input id="fname" name="fname" class="text err" value="<?php echo $userData['firstName'] ?>" />

            <br />
            <br />
            <label for="lname">Your surname</label>
    		<input id="lname" name="lname" class="text err" value="<?php echo $userData['lastName'] ?>"/>

        </div>

        <div class="element">

            <label for="phone">Phone </label>
    		<input id="phone" name="phone" class="text err"  value="<?php echo $userData['phone'] ?>" />
        </div>
        <div class="element">
            <label for="address">Address</label>
    		<input id="address" name="address" class="text err" value="<?php echo $userData['address'] ?>"/>

            <br />
            <br />
            <label for="suburb">Suburb </label>
    		<input id="suburb" name="suburb" class="text err" value="<?php echo $userData['suburb'] ?>"/>

            <br />
            <br />
            <label for="postcode">Postcode </label>
    		<input  id="postcode" name="postcode" class="text err" value="<?php echo $userData['postcode'] ?>" />

        </div>

        <div class="element">
        		<label for="email">Your Email </label>
    		<input id="email" name="email" class="text err"  value="<?php echo $userData['email'] ?>"/>

            <br />
            <br />
            <label for="pass">Password (Min length 8) </label>
    		<input type="password" id="pass" name="pass" class="text err" value="" />
            <span id="passVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password is required</span>
            <span id="passVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password minimum length 8</span>

            <br />
            <br />
            <label for="passCon">Password confirmation </label>
    		<input type="password" id="passCon" name="passCon" class="text err" />
            <span id="passConVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Password confirmation does not match password</span>

    	</div>

        <div class="element">
            <button>Update</button>
        </div>

    </form>

</div>
<script type="text/javascript">
    function userInfoClose()
    {
        $('#userInfoDisplay').hide('fast');
        return false;
    }
</script>
