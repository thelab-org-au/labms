<div class="half_w half_left" >
	<div class="h_title">Mailing List</div>
       
    <div style="margin: auto;">
    

    <?php

        if(isset($valError))
            echo '<div style="padding:10px; color: red;">'. $valError . '</div>';
    
    ?>
    <?php echo validation_errors(); ?>
    
	<? echo form_open('signup/mailinglist/signup/',array('id' => 'parentForm')); ?> 

     
        <?php
            if(!$loggedin)
            {
                echo '<div class="element">';
                echo '<p>If you have previously created an account please <a href="'.site_url().'/user/login?page=mail" style="color:#0000FF; text-decoration: underline;">LOGIN</a> </p>';
                echo '</div>';
                $this->load->view('forms/baseform'); 
            }
                
         ?>
        
        
        <div class="element">
			<label for="lab">Preferred Lab <span class="red">(required)</span></label>
			<select name="lab" class="err" id="lab">
				<option value="-2">All labs</option>
                
                <?php 
                    foreach($labs as $lab)
                       echo '<option value="'.$lab['id'].'">'.$lab['name'].'</option>'; 
                ?>
                
			</select>
            <span id="labVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please select a lab</span>
		</div>
        
        <div class="element">
            <div id="childDetails" >
                <label for="name1">Your child's first name (only for registering parents)</label>
    			<input id="name1" name="name1" class="text err" />
                
                <br />
                <br />
                <label for="age1">Child's date of birth (only for registering parents)</label>
    			<input id="age1" name="age1" class="text err" />
            </div>
            
 
            <input type="hidden" name="childCount" id="childCount" value="1" />       
        </div>
        <br />
            <button type="submit" class="add" id="addChild" onclick=" return false;"> Add another child</button> 
            
		<div class="entry" style="height: 29px;">
			<button type="submit" style="float: right;"  >Subscribe</button>
		</div>
	</form>
    </div>
</div>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  

<script type="text/javascript">

  $(function() {
    $( "#age1" ).datepicker({ dateFormat: "dd/mm/yy", maxDate: "-1y" });
  });


    var count = 1;
    var childDetails = $('#childDetails');
    var childCount = $('#childCount');
    
    
    //add new child fields to form
    $('#addChild').click(function()
    {
        count++;
        childDetails.append('<div  style="padding-top:10px">');
        childDetails.append('<label for="name' + count + '">Child\'s first name</label><input id="name' + count + '" name="name' + count + '" class="text err" />');
        childDetails.append('<br/><br/><label for="age' + count + '">Child\'s date of birth</label><input id="age' + count + '" name="age' + count + '" class="text err" />');
        childDetails.append('</div>');
        childCount.val(count);
        $( "#age" + count ).datepicker({ dateFormat: "dd/mm/yy", maxDate: "-1y" });
    })

</script>

