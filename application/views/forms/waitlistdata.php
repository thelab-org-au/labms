<div id="childDetails" >
    <div class="element">
        <label for="name<?php echo $count;?>">Your child's first name<span class="red"> *</span><span id="nameval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
		<input id="name<?php echo $count;?>" name="name<?php echo $count;?>" class="text err" />
        
        <br />
        <br />
        <label for="age<?php echo $count;?>">Child's date of birth<span class="red"> *</span><span id="ageval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
		<input id="age<?php echo $count;?>" name="age<?php echo $count;?>" class="text err" />
    </div>
    
    <div class="element">
        <h3>What type of school does your child attend?<span class="red"> *</span> <span id="typeval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
        <br />
        <ul style="list-style: none;">
        
            <?php
                foreach($schools as $school)
                {
                    echo '<li>';
                    echo '<label for="'.$school['name'].$count.'" >';
                    echo '<input type="checkbox" name="'.$school['name']. $count.'" value="1"  />&nbsp;'.$school['desc'];
                    echo '</label>';
                    echo '</li>';
                }
            ?>
            
            <li>
                <label for="otherText<?php echo $count;?>" >
                    Other: <input style="width: 150px;"  id="otherText" name="otherText<?php echo $count;?>"/> 
                </label>
            </li>        
        </ul>      
    </div>
    
    <div class="element">
        <h3>How many days a week does your child attend school?<span class="red"> *</span><span id="daysval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <table style="width: 50%; text-align: center;">
            <tr>
                <?php for($cnt = 1; $cnt <= 5; $cnt++) echo '<td>'.$cnt.'</td>'; ?>
            </tr>
            <tr>
                <?php for($cnt = 1; $cnt <= 5; $cnt++) echo '<td><input type="radio" name="days'.$count.'" value="'.$cnt.'" /></td>'; ?>
            </tr>
        </table>    
    </div>
    
    <div class="element">
        <h3>Has your child been diagnosed with any of the following conditions?<span class="red"> *</span><span id="conval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <br />
        <ul style="list-style: none;">
            <?php
                foreach($conditions as $condition)
                {
                    echo '<li>';
                    echo '<label for="'.$condition['name'].$count.'" >';
                    echo '<input type="checkbox" name="'.$condition['name'].$count.'" value="1"  />&nbsp;'.$condition['desc'];
                    echo '</label>';
                    echo '</li>';
                }
            ?> 
            <li>
                <label for="otherConditionText<?php echo $count;?>" >
                    Other: <input style="width: 150px;"  id="otherConditionText" name="otherConditionText<?php echo $count;?>"/> 
                </label>
            </li>        
        </ul>
    </div>
    
    <div class="element">
        <h3>What is you child's level of experience with the following technologies?<span class="red"> *</span><span id="expval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span>  </h3>
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
                        echo '<td><input type="radio" name="exp'.$tech['name'].$count.'" value="'. ($cnt2 + 1) .'" /></td>';
                    
                    echo '</tr>';                    
                }            
            ?>
        </table>
    </div>
    
    <div class="element">
        <h3>What is you child's level of interest in the following technologies?<span class="red"> *</span><span id="intrestval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
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
                        echo '<td><input type="radio" name="intrest'.$tech['name'].$count.'" value="'. ($cnt2 + 1) .'" /></td>';
                    
                    echo '</tr>';                    
                }             
            ?>
        </table>
    </div>
    
    <div class="element">
        <h3>Is your child more interested in learning programming and design,<br /> or making friends and undertaking social activities (such as multi-user games)?<span class="red"> *</span><span id="inval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <p><i>We will be holding separate sessions for those wanting to be social, and those wanting to learn skills - answers should reflect how a young person spends their own spare time on the computer</i></p>
        <br />
        <ul style="list-style: none;">
            <?php
                //$names = array('autisim1','hfa1','as1','adhd','anxiety','no');
                $text = array('Social activities','Learning programming and design skills','Both');
                
                for($cnt = 0; $cnt < sizeof($text); $cnt++)
                {
                    echo '<li>';
                    echo '<label for="interested',$count.'" >';
                    echo '<input type="radio" name="interested'.$count.'" value="'.($cnt + 1).'"  />&nbsp;'.$text[$cnt];
                    echo '</label>';
                    echo '</li>';
                }
            ?>
            <li>
                <label for="interested<?php echo $count;?>" >
                    <input type="radio" name="interested<?php echo $count;?>" value="4"  />&nbsp;Other: <input style="width: 150px;"  id="otherintrestText<?php echo $count;?>" name="otherintrestText<?php echo $count;?>"/> 
                </label>
            </li>  
        </ul>        
    </div>
    
    <div class="element">
        <h3>Does your child have a laptop less than three years old? <span class="red"> *</span><span id="pcval<?php echo $count;?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
        <p><i>A lot of the software used at the lab requires a reasonably powerful computer</i></p>
        <br />
        <ul style="list-style: none; ">
            <li>
                <label for="pc" >
                    <input type="radio" name="pc<?php echo $count;?>" value="1"  />&nbsp;Yes
                </label>
            </li>
            <li>
                <label for="pc" >
                    <input type="radio" name="pc<?php echo $count;?>" value="2"  />&nbsp;No 
                </label>
            </li>  
        </ul> 
    </div>

    <div class="element">
        <h3>Do you have anything else you think we should know? </h3>
        <p><i>Please let us know if you couldn't put what you wanted to into the form or have any information which you think might help us understand your situation better</i></p>
        <br />
        <textarea name="text<?php echo $count;?>" rows="8" style="width: 95%;"></textarea>
    </div>
    
</div>
     


    <!--<button type="submit" class="add" id="addChild" onclick=" return false;"> Add another child</button> -->
    
