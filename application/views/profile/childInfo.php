<div id="childInfoDisplay" > 
    <h2>Child details</h2>
    
<?php //var_dump($studentData); ?>
    
    <?php if($parent) : ?>
    <?php foreach($studentData as $student): ?>
        <?php //var_dump($student); ?>
        <? echo form_open('user/profile/studentUpdate/',array('id' => 'parentForm')); ?> 
            <div class="h_title" id="student<?php echo $student['id']; ?>"><?php echo $student['name']; ?> <span id="expand<?php echo $student['id']; ?>">[+]</span></div>
            <div class="element data" id="ele<?php echo $student['id']; ?>" style="display: none;">
                <input type="hidden" name="studentId" value="<?php echo $student['id']; ?>" />
                <input type="hidden" name="studentData" value="<?php echo $student['studentData']; ?>" />
                <div class="element">
                    <label for="name<?php echo $student['id']; ?>">First name<span class="red"> *</span><span id="nameval<?php echo $student['id']; ?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
                    <input id="name<?php echo $student['id']; ?>" name="name" class="text err" value="<?php echo $student['name']; ?>" />
                
                    <br />
                    <br />
                    <label for="age<?php echo $student['id']; ?>">Date of birth<span class="red"> *</span><span id="ageval<?php echo $student['id']; ?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></label>
                    <input id="age<?php echo $student['id']; ?>" name="age" class="text err" value="<?php echo $student['dob']; ?>" />
                </div>  
                
                         
            <div class="element">
                <h3>School<span class="red"> *</span> <span id="typeval<?php echo $student['id']; ?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
                <br />
                <ul style="list-style: none;">
                
                    <?php
                        foreach($schools as $school)
                        {
                            if(isset($student['schoolData']))
                                $check = in_array($school['id'],$student['schoolData']) ? 'checked="checked"': '';
                            echo '<li>';
                            echo '<label for="'.$school['name'].$student['id'].'" >';
                            echo '<input type="checkbox" name="school[]" value="'.$school['id'].'" '.$check.' />&nbsp;'.$school['desc'];
                            echo '</label>';
                            echo '</li>';
                        }
                    ?>
                    
                    <li>
                        <label for="otherText<?php echo $student['id']; ?>" >
                            Other: <input style="width: 150px;"  id="otherText" name="otherText" value="<?php echo $student['schoolOther']; ?>"/> 
                        </label>
                    </li>        
                </ul>      
            </div> 
            
            <div class="element">
                <h3>Days at school?<span class="red"> *</span><span id="daysval<?php echo $student['id']; ?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
                <table style="width: 50%; text-align: center;">
                    <tr>
                        <?php for($cnt = 1; $cnt <= 5; $cnt++) echo '<td>'.$cnt.'</td>'; ?>
                    </tr>
                    <tr>
                        <?php 
                            for($cnt = 1; $cnt <= 5; $cnt++) 
                            {
                               $check = ($cnt == $student['daysAtSchool']) ? 'checked="checked"': ''; 
                               echo '<td><input type="radio" name="days" value="'.$cnt.'" '.$check.'/></td>';
                            }
                        ?> 
                    </tr>
                </table>    
            </div>  
            
            
            <div class="element">
                <h3>Child conditions?<span class="red"> *</span><span id="conval<?php echo $student['id']; ?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
                <br />
                <ul style="list-style: none;">
                    <?php
                        foreach($conditions as $condition)
                        {
                            if(isset($student['conditionData']))
                                $check = in_array($condition['id'],$student['conditionData']) ? 'checked="checked"': '';
                            echo '<li>';
                            echo '<label for="'.$condition['name'].$student['id'].'" >';
                            echo '<input type="checkbox" name="conditions[]" value="'.$condition['id'].'" '.$check.' />&nbsp;'.$condition['desc'];
                            echo '</label>';
                            echo '</li>';
                        }
                    ?> 
                    <li>
                        <label for="otherConditionText<?php echo $student['id']; ?>" >
                            Other: <input style="width: 150px;"  id="otherConditionText" name="otherConditionText" value="<?php echo $student['conditionOther']; ?>"/> 
                        </label>
                    </li>        
                </ul>
            </div>         
            
            <div class="element">
                <h3>What is you child's level of experience with the following technologies?<span class="red"> *</span><span id="expval<?php echo $student['id'];?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span>  </h3>
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
                                if(isset($student['studentExp'][$tech['id']]))
                                    $check = ($student['studentExp'][$tech['id']] == ($cnt2 + 1)) ? 'checked="checked"': ''; 
                                echo '<td><input type="radio" name="exp'.$tech['id'].'" value="'. ($cnt2 + 1) .'" '.$check.' /></td>';
                            }
                            
                            echo '</tr>';                    
                        }            
                    ?>
                </table>
            </div>  
              
            <div class="element">
                <h3>What is you child's level of interest in the following technologies?<span class="red"> *</span><span id="intrestval<?php echo $student['id'];?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
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
                                if(isset($student['studentInterest'][$tech['id']]))
                                    $check = ($student['studentInterest'][$tech['id']] == ($cnt2 + 1)) ? 'checked="checked"': ''; 
                                echo '<td><input type="radio" name="intrest'.$tech['id'].'" value="'. ($cnt2 + 1) .'" '.$check.' /></td>';
                            }
                                
                            
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
                            $check = ($student['sessionType'] == ($cnt + 1)) ? 'checked="checked"': ''; 
                            echo '<li>';
                            echo '<label for="interested',$student['id'].'" >';
                            echo '<input type="radio" name="socialInterest" value="'.($cnt + 1).'" '.$check.' />&nbsp;'.$text[$cnt];
                            echo '</label>';
                            echo '</li>';
                        }
                    ?>
                    <li>
                        <label for="interested<?php echo $student['id'];?>" >
                            <input type="radio" name="interested<?php echo $student['id'];?>" value="4"  />&nbsp;Other: <input style="width: 150px;"  id="otherintrestText<?php echo $student['id'];?>" name="otherintrestText"/> 
                        </label>
                    </li>  
                </ul>        
            </div>

            <div class="element">
                <h3>Does your child have a laptop less than three years old? <span class="red"> *</span><span id="pcval<?php echo $student['id'];?>" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
                <p><i>A lot of the software used at the lab requires a reasonably powerful computer</i></p>
                <br />
                <ul style="list-style: none; ">
                    <li>
                        <label for="pc" >
                            <input type="radio" name="pc" value="1" <?php echo ($student['lapTop'] == '1') ? 'checked="checked"': ''; ?> />&nbsp;Yes
                        </label>
                    </li>
                    <li>
                        <label for="pc" >
                            <input type="radio" name="pc" value="2" <?php echo ($student['lapTop'] == '0') ? 'checked="checked"': ''; ?>  />&nbsp;No 
                        </label>
                    </li>  
                </ul> 
            </div>

            <div class="element">
                <h3>Do you have anything else you think we should know? </h3>
                <p><i>Please let us know if you couldn't put what you wanted to into the form or have any information which you think might help us understand your situation better</i></p>
                <br />
                <textarea name="text" rows="8" style="width: 95%;"><?php echo $student['otherInfo'];?></textarea>
            </div>

    		<div class="entry" style="height: 29px;">
    			<button   type="submit" style="float: right;" id="submit<?php echo $student['id'];?>" >Update</button>
    		</div>
           
           
            </div>
            
            
        </form>
        

        
        <script>
        
            $('#student<?php echo $student['id']; ?>').click(function()
            {
                studentInfoShow('<?php echo $student['id']; ?>');
            });
            
            $( "#age" + <?php echo $student['id']; ?> ).datepicker({ dateFormat: "dd/mm/yy", maxDate: "-1y" });
            
            $('#submit<?php echo $student['id'];?>').click(function(e)
            {
                 return true;
            });
            
        </script>
        
    <?php endforeach; ?>
    
    <?php endif; ?>
    
    <?php if(!$parent): ?>
        <h3>No child information found</h3>
    
    <?php endif; ?>

</div>
<script type="text/javascript">
    function childInfoClose()
    {
        $('#childInfoDisplay').hide('fast');
        return false;
    }
    
    function studentInfoShow(id)
    {
        $('.data').each(function()
        {
            if($(this).attr('id') != 'ele'+id)
            {
                $(this).hide('fast');
                $('#expand'+$(this).attr('id')).html('[+]');
            }
            else
            {
                if($(this).is(':visible'))
                {
                    $(this).hide('fast');
                    $('#expand'+id).html('[+]');
                }
                else
                {
                    $(this).show('fast', function()
                    {
                        //$(window).scrollTop($(this).offset().top - 100);
                        $("html, body").animate({ scrollTop: $(this).offset().top - 100 }, "slow");
                    });
                    $('#expand'+id).html('[-]');
                    
                }
            }
        });
        
        
        
        
    }
</script>