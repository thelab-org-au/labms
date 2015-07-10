<div class="full_w" style="min-height: 500px;">
	<div class="h_title">Edit student</div>
    
    <?php $this->load->view('display'); ?>
    <?php echo validation_errors(); ?>
 <? echo form_open('admin/astudents/updateStudent/',array('id' => 'parentForm')); ?> 

 <input type="hidden"  name="sid" value="<?php echo $studentId; ?>"/>
 
 <?php if(isset($studentData['user'])) :?>
    <input type="hidden" name="uid" value="<?php echo $studentData['user']['id']; ?>"/>
 <?php endif;?>
 
 <?php if(isset($studentData['data'])) :?>
    <input type="hidden" name="did" value="<?php echo $studentData['data']['id']; ?>"/>
 <?php endif;?>
 
 <div id="parentDetails">
    <h2>Parent details</h2>
 	<span class="red">* (required)</span>
    <div class="element">

        <label for="fname">Parent first name <span class="red">*</span></label>
		<input id="fname" name="fname" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['firstName']; ?>"  required />
        <span id="fnameVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;First name is required</span>
        
        <br />
        <br />
        <label for="lname">Parent surname <span class="red">*</span></label>
		<input id="lname" name="lname" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['lastName']; ?>" required />
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
		<input id="phone" name="phone" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['phone']; else echo $studentData['info']['contact_phone'] ?>" required />
    </div>
    <div class="element">  
        <label for="address">Address <span class="red">*</span></label>
		<input id="address" name="address" class="text err"  value="<?php if(isset($studentData['user'])) echo $studentData['user']['address']; ?>" required /> 
                           
        <br />
        <br />
        <label for="suburb">Suburb <span class="red">*</span></label>
		<input id="suburb" name="suburb" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['suburb']; ?>" required />
        
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
		<input  id="postcode" name="postcode" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['postcode']; ?>" required />
        <span id="postVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode numeric only</span>
        <span id="postVallength" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Postcode entered to long</span>
        
    </div> 
       
    <div class="element">
    		<label for="email">Parent Email <span class="red">*</span></label>
            
		<input id="parentEmail" name="email" class="text err" value="<?php if(isset($studentData['user'])) echo $studentData['user']['email']; else echo $studentData['info']['contact_email']; ?>" required />
        <span id="emailVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Email is required</span>
        
        <?php if(!isset($studentData['user'])) : ?>
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
        
        <br />
        <br />
        <label for="createNew">
            <input type="checkbox" name="create" id="createNew" checked="checked" /> &nbsp; Create new user
        </label>
        <?php endif;?>        
	</div>
 
 </div>
 
 <hr />
 
 
 
 
 
 
 
 
 
<div id="childDetails" >
    <h2>Student details</h2>
    <div class="element">
        <label for="name">Child's name <span class="red"> *</span><span id="nameval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
		<input id="name" name="name" class="text err" value="<?php echo $studentData['info']['name']; ?>" />
        
        <br />
        <br />
        <label for="age">Child's date of birth<span class="red"> *</span><span id="ageval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
		<input id="age" name="age" class="text err" value="<?php echo $studentData['info']['dob']; ?>"/>
    </div>
    
    <div class="element">
        <h3>What type of school does the child attend?<span class="red"> *</span> <span id="typeval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
        <br />
        <ul style="list-style: none;">
        
            <?php
                foreach($schools as $school)
                {
                    echo '<li>';
                    echo '<label for="'.$school['name'].'" >';
                    
                    if(isset($studentData['schoolLevel']) &&
                        $school['id'] == $studentData['schoolLevel']['schoolLevel'])
                    {
                            echo '<input type="checkbox" name="school[]" value="'.$school['id'].'" checked="checked"  />&nbsp;'.$school['desc'];
                    }    
                    else
                        echo '<input type="checkbox" name="school[]" value="'.$school['id'].'"  />&nbsp;'.$school['desc'];
                    echo '</label>';
                    echo '</li>';
                }
            ?>
            
            <li>
                <label for="otherText" >
                    Other: <input style="width: 150px;"  id="otherText" name="otherText" value="<?php if(isset($studentData['data']['schoolOther'])) echo $studentData['data']['schoolOther']; ?>"/> 
                </label>
            </li>        
        </ul>      
    </div>
    
    <div class="element">
        <h3>How many days a week does the child attend school?<span class="red"> *</span><span id="daysval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <table style="width: 50%; text-align: center;">
            <tr>
                <?php for($cnt = 1; $cnt <= 5; $cnt++) echo '<td>'.$cnt.'</td>'; ?>
            </tr>
            <tr>
                <?php 
                    for($cnt = 1; $cnt <= 5; $cnt++) 
                    {
                        if(isset($studentData['data']) && $studentData['data']['daysAtSchool'] == $cnt)
                            echo '<td><input type="radio" name="days'.'" value="'.$cnt.'" checked="checked" /></td>';
                        else
                            echo '<td><input type="radio" name="days'.'" value="'.$cnt.'" /></td>';
                    } 
                    ?>
            </tr>
        </table>    
    </div>
    
    <div class="element">
        <h3>Has the child been diagnosed with any of the following conditions?<span class="red"> *</span><span id="conval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <br />
        <ul style="list-style: none;">
            <?php
                foreach($conditions as $condition)
                {
                    echo '<li>';
                    echo '<label for="'.$condition['name'].'" >';
                    
                    if(isset($studentData['conditions']) && in_array($condition['id'],$studentData['conditions']))
                        echo '<input type="checkbox" name="condition[]" value="'.$condition['id'].'" checked="checked"  />&nbsp;'.$condition['desc'];
                    else
                        echo '<input type="checkbox" name="condition[]" value="'.$condition['id'].'"  />&nbsp;'.$condition['desc'];
                    echo '</label>';
                    echo '</li>';
                }
            ?> 
            <li>
                <label for="otherConditionText" >
                    Other: <input style="width: 150px;"  id="otherConditionText" name="otherConditionText"value="<?php if(isset($studentData['data']['conditionOther'])) echo $studentData['data']['conditionOther']; ?>"/> 
                </label>
            </li>        
        </ul>
    </div>
    
    <div class="element">
        <h3>What is you child's level of experience with the following technologies?<span class="red"> *</span><span id="expval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span>  </h3>
        <table style="text-align: center; width: 75%;">
            <tr>
                <td></td>
                <td>Low</td>
                <td>Medium</td>
                <td>High</td>
            </tr>
            
            <?php           
                foreach($techs as $tech)
                {
                    echo '<tr>';
                    echo '<td>'.$tech['desc'].'</td>';
                    
                    for($cnt2 = 0; $cnt2 < 3; $cnt2++)
                    {
                        if(isset($studentData['experience']) && $studentData['experience'][$tech['id']] == ($cnt2 + 1))
                            echo '<td><input type="radio" name="exp'.$tech['id'].'" value="'. ($cnt2 + 1) .'" checked="checked" /></td>';                        
                        else
                            echo '<td><input type="radio" name="exp'.$tech['id'].'" value="'. ($cnt2 + 1) .'" /></td>';
                    }
                        
                    
                    echo '</tr>';                    
                }            
            ?>
        </table>
    </div>
    
    <div class="element">
        <h3>What is the child's level of interest in the following technologies?<span class="red"> *</span><span id="intrestval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
        <table style="text-align: center; width: 75%;">
            <tr>
                <td></td>
                <td>Low</td>
                <td>Medium</td>
                <td>High</td>
            </tr>
            
            <?php

                foreach($techs as $tech)
                {
                    echo '<tr>';
                    echo '<td>'.$tech['desc'].'</td>';
                    
                    for($cnt2 = 0; $cnt2 < 3; $cnt2++)
                    {
                        if(isset($studentData['intrests']) && $studentData['intrests'][$tech['id']] == ($cnt2 + 1))
                            echo '<td><input type="radio" name="intrest'.$tech['id'].'" value="'. ($cnt2 + 1) .'" checked="checked" /></td>';                       
                        else
                            echo '<td><input type="radio" name="intrest'.$tech['id'].'" value="'. ($cnt2 + 1) .'" /></td>';
                    }
                    
                    echo '</tr>';                    
                }             
            ?>
        </table>
    </div>
    
    <div class="element">
        <h3>Is the child more interested in learning programming and design,<br /> or making friends and undertaking social activities (such as multi-user games)?<span class="red"> *</span><span id="inval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <p><i>We will be holding separate sessions for those wanting to be social, and those wanting to learn skills - answers should reflect how a young person spends their own spare time on the computer</i></p>
        <br />
        <ul style="list-style: none;">
            <?php
                //$names = array('autisim1','hfa1','as1','adhd','anxiety','no');
                $text = array('Social activities','Learning programming and design skills','Both');
                
                for($cnt = 0; $cnt < sizeof($text); $cnt++)
                {
                    echo '<li>';
                    echo '<label for="interested" >';
                    
                    if(isset($studentData['data']['sessionType']) && ($cnt + 1) == $studentData['data']['sessionType'])
                        echo '<input type="radio" name="interested" value="'.($cnt + 1).'" checked="checked"  />&nbsp;'.$text[$cnt];
                    else
                        echo '<input type="radio" name="interested" value="'.($cnt + 1).'"  />&nbsp;'.$text[$cnt];
                    echo '</label>';
                    echo '</li>';
                }
            ?>
            <li>
                <label for="interested" >
                    <input type="radio" name="interested" value="4"  />&nbsp;Other: 
                    <input style="width: 150px;"  id="otherintrestText" name="otherintrestText" value="<?php if(isset($studentData['data']['sessionOther'])) echo $studentData['data']['sessionOther']; ?>"/> 
                </label>
            </li>  
        </ul>        
    </div>
    
    <div class="element">
        <h3>Does the child have a laptop less than three years old? <span class="red"> *</span><span id="pcval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <p><i>A lot of the software used at the lab requires a reasonably powerful computer</i></p>
        <br />
        <ul style="list-style: none; ">
            <li>
                <label for="pc" >
                    <input type="radio" name="pc" value="1" <?php if(isset($studentData['data']['lapTop']) && $studentData['data']['lapTop'] == '1') echo 'checked="checked"' ?>  />&nbsp;Yes
                </label>
            </li>
            <li>
                <label for="pc" >
                    <input type="radio" name="pc" value="2" <?php if(isset($studentData['data']['lapTop']) && $studentData['data']['lapTop'] == '2') echo 'checked="checked"' ?>/>&nbsp;No 
                </label>
            </li>  
        </ul> 
    </div>

    <div class="element">
        <h3>Do you have anything else you think we should know? </h3>
        <p><i>Please let us know if you couldn't put what you wanted to into the form or have any information which you think might help us understand your situation better</i></p>
        <br />
        <textarea name="text" rows="8" style="width: 95%;"><?php if(isset($studentData['data']['otherInfo'])) echo $studentData['data']['otherInfo'] ?></textarea>
    </div>
    
</div>
    <button>Update</button>
 </form>      


    <!--<button type="submit" class="add" id="addChild" onclick=" return false;"> Add another child</button> -->
    


</div>