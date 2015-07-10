<div id="mentorInfoDisplay" >
    <h2>Mentor</h2>

    <?php //var_dump($mentorData); ?>
    <?php

        if(isset($valError))
            echo '<div style="padding:10px; color: red;">'. $valError . '</div>';

    ?>
    <?php //echo validation_errors(); ?>

    <?php if($mentor) : ?>

	<?php echo form_open_multipart('user/profile/mentorUpdate',array('id' => 'parentForm')); ?>
        <input type="hidden" name="id" value="<?php echo $mentorData['id']; ?>" />
        <div class="element">
            <h3>Educational History <span class="red"> *</span><span id="eduVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please list all educational history, including a list of schools attended (name + address), # of years completed, and any major/degree.</p>
            <br />
            <textarea id="education" name="education" rows="8" style="width: 98%;" required="true" ><?php echo $mentorData['education']; ?></textarea>
        </div>

        <div class="element">
            <h3>Have you ever been convicted of a crime?  <span class="red"> *</span><span id="crimeVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="crime" >
                        <?php $check = ($mentorData['conviction'] == '1') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="crime" value="1" <?php echo $check; ?> />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="crime" >
                        <?php $check = ($mentorData['conviction'] == '2') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="crime" value="2"  <?php echo $check; ?>/>&nbsp;No
                    </label>
                </li>
            </ul>


            <p>If yes, explain number of conviction(s), nature of offence(s) leading to conviction(s), how recently such offence(s) was/were committed, sentence(s) imposed, and type(s) of rehabilitation.<span id="crimeDetailVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></p>
            <br />
            <textarea id="crimeDetails" name="crimeDetails" rows="8" style="width: 98%;" ><?php echo $mentorData['convictionDetails']; ?></textarea>
        </div>

        <div class="element">

             <h3>Do you have a Working with Children Check? <span class="red"> *</span><span id="workChildVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="workChild" >
                        <?php $check = ($mentorData['childrenCheck'] == '1') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="workChild" value="1" <?php echo $check; ?>  />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="workChild" >
                        <?php $check = ($mentorData['childrenCheck'] == '1') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="workChild" value="2" <?php echo $check; ?>   />&nbsp;No
                    </label>
                </li>
            </ul>

            <br />
            <h3>Working with Children</h3>
            <p>Do you have any experience working with children? Please describe.</p>
            <br />
            <textarea name="childExperience" rows="8" style="width: 98%;" ><?php echo $mentorData['workingWithChild']; ?></textarea>
        </div>

    <div class="element">
        <h3>Technical skills and experience ?<span class="red"> *</span><span id="expTechval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
        <p>Please indicate the level of expertise you have with the following technologies.</p>
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
                        if(isset($mentorData['exp'][$tech['id']]))
                            $check = ($mentorData['exp'][$tech['id']] == ($cnt2 + 1)) ? 'checked="checked"': '';

                        echo '<td><input type="radio" name="Tech'.$tech['id'].'" value="'. ($cnt2 + 1) .'" '.$check.' /></td>';
                    }


                    echo '</tr>';
                }
            ?>
        </table>
    </div>

        <div class="element">
            <h3>Other skills</h3>
            <p>Do you have any other skills you feel would assist you as a mentor at The Lab?</p>
            <br />
            <textarea id="otherSkills" name="otherSkills" rows="8" style="width: 98%;" ><?php echo $mentorData['otherSkills']; ?></textarea>
        </div>


        <div class="element">
            <h3>References<span class="red"> *</span><span id="refval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please list two references other than relatives or friends.</p>
            <br />
            <textarea id="references" name="references" rows="8" style="width: 98%;" required="true"><?php echo $mentorData['references']; ?></textarea>
        </div>

        <div class="element">
            <h3>Work Experience<span class="red"> *</span><span id="workExpval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please provide a list of work experience from most recent to least recent for the last 5 years. Please include employer address, name of supervisor, dates of employment, hourly rate, title, and reason for leaving.</p>
            <br />
            <textarea  id="workExperience" name="workExperience" rows="8" style="width: 98%;" required="true"><?php echo $mentorData['workExp']; ?></textarea>
        </div>

        <div class="element">
            <h3>May we contact your current employer? <span class="red"> *</span><span id="contactVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="contactEmployer" >
                        <?php $check = ($mentorData['contactEmployer'] == '1') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="contactEmployer" value="1" <?php echo $check; ?>  />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="contactEmployer" >
                        <?php $check = ($mentorData['contactEmployer'] == '2') ? 'checked="checked"': ''; ?>
                        <input type="radio" name="contactEmployer" value="2" <?php echo $check; ?> />&nbsp;No
                    </label>
                </li>
            </ul>
        </div>

        <div class="element">
            <h3>Additional Information</h3>
            <p>Please summarise any additional information necessary to describe your qualifications for the position you are applying for.</p>
            <br />
            <textarea id="addInfo" name="addInfo" rows="8" style="width: 98%;" ><?php echo $mentorData['addInfo']; ?></textarea>
        </div>

        <div class="element">
            <label for="current">Current Resume</label>
            <p id="current"><?php echo $mentorData['origFileName']; ?></p>
            <input type="hidden" name="currentFile" value="<?php echo $mentorData['fileName']; ?>" />
            <?php echo '<p>'.anchor_popup(base_url().'uploads/'.$mentorData['fileName'], 'Download resume ', array('title' => 'Download resume', 'width' => '800')).'</p>'; ?>
        </div>

        <div class="element">
            <label for="file">Upload new Resume</label>
            <p>&nbsp;&nbsp;Formats accepted: pdf, doc, docx, txt, odt</p>
            <br />
            <input type="file" name="userfile" id="file"  />
        </div>

        <div class="entry" style="height: 29px;">
			<button type="submit" style="float: right;"  >Update</button>
		</div>
    </form>
    <?php endif; ?>

    <?php if(!$mentor) :?>
        <h3>No mentor information found</h3>
    <?php endif;?>
</div>
<script type="text/javascript">
    function mentorInfoClose()
    {
        $('#mentorInfoDisplay').hide('fast');
        return false;
    }
</script>
