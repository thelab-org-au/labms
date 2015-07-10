<div class="half_w half_left" style="width: 50%;"  >
	<div class="h_title">The Lab mentor application</div>

    <div style="margin: auto;">


    <?php

        if(isset($valError))
            echo '<div style="padding:10px; color: red;">'. $valError . '</div>';

    ?>
    <?php echo validation_errors(); ?>

	<?php echo form_open_multipart('signup/mentor/signup/',array('id' => 'parentForm')); ?>

         <div class="element">
        <p>If you would like to become a mentor at The Lab please fill out the following form.</p>
        <!--<p><i>Please note that all details are confidential.</i></p>-->
    </div>

        <?php
            if(!$loggedin)
            {
                echo '<div class="element">';
                echo '<p>If you have previously created an account please <a href="'.site_url().'/user/login?page=mentor" style="color:#0000FF; text-decoration: underline;">LOGIN</a> </p>';
                echo '</div>';
                $this->load->view('forms/baseform');
            }
         ?>


        <div class="element">
			<label for="lab">Lab location you are applying for <span class="red">(required)</span></label>
			<select name="lab" class="err" id="lab">
				<option value="-1">-Select Lab-</option>

                <?php
                    foreach($labs as $lab)
                       echo '<option value="'.$lab['id'].'">'.$lab['name'].'</option>';
                ?>

			</select>
            <span id="labVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please select a lab</span>
		</div>


        <div class="element">
            <h3>Educational History <span class="red"> *</span><span id="eduVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please list all educational history, including a list of schools attended (name + address), # of years completed, and any major/degree.</p>
            <br />
            <textarea id="education" name="education" rows="8" style="width: 98%;" required="true" ></textarea>
        </div>

        <div class="element">
            <h3>Have you ever been convicted of a crime?  <span class="red"> *</span><span id="crimeVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="crime" >
                        <input type="radio" name="crime" value="1"  />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="crime" >
                        <input type="radio" name="crime" value="2"  />&nbsp;No
                    </label>
                </li>
            </ul>


            <p>If yes, explain number of conviction(s), nature of offence(s) leading to conviction(s), how recently such offence(s) was/were committed, sentence(s) imposed, and type(s) of rehabilitation.<span id="crimeDetailVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></p>
            <br />
            <textarea id="crimeDetails" name="crimeDetails" rows="8" style="width: 98%;" ></textarea>
        </div>


        <div class="element">

             <h3>Do you have a Working with Children Check? <span class="red"> *</span><span id="workChildVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="workChild" >
                        <input type="radio" name="workChild" value="1"  />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="workChild" >
                        <input type="radio" name="workChild" value="2"  />&nbsp;No
                    </label>
                </li>
            </ul>

            <br />
            <h3>Working with Children</h3>
            <p>Do you have any experience working with children? Please describe.</p>
            <br />
            <textarea name="childExperience" rows="8" style="width: 98%;" ></textarea>
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
                        echo '<td><input type="radio" name="expTech'.$tech['name'].'" value="'. ($cnt2 + 1) .'" /></td>';

                    echo '</tr>';
                }
            ?>
        </table>
    </div>

        <div class="element">
            <h3>Other skills</h3>
            <p>Do you have any other skills you feel would assist you as a mentor at The Lab?</p>
            <br />
            <textarea id="otherSkills" name="otherSkills" rows="8" style="width: 98%;" ></textarea>
        </div>


        <div class="element">
            <h3>References<span class="red"> *</span><span id="refval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please list two references other than relatives or friends.</p>
            <br />
            <textarea id="references" name="references" rows="8" style="width: 98%;" required="true"></textarea>
        </div>

        <div class="element">
            <h3>Work Experience<span class="red"> *</span><span id="workExpval" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span></h3>
            <p>Please provide a list of work experience from most recent to least recent for the last 5 years. Please include employer address, name of supervisor, dates of employment, hourly rate, title, and reason for leaving.</p>
            <br />
            <textarea  id="workExperience" name="workExperience" rows="8" style="width: 98%;" required="true"></textarea>
        </div>


        <div class="element">
            <h3>May we contact your current employer? <span class="red"> *</span><span id="contactVal" style="display: none; color: red; font-size: 11px;">&nbsp; &nbsp;Required</span> </h3>
            <br />
            <ul style="list-style: none; ">
                <li>
                    <label for="contactEmployer" >
                        <input type="radio" name="contactEmployer" value="1"  />&nbsp;Yes
                    </label>
                </li>
                <li>
                    <label for="contactEmployer" >
                        <input type="radio" name="contactEmployer" value="2"  />&nbsp;No
                    </label>
                </li>
            </ul>
        </div>

        <div class="element">
            <h3>Additional Information</h3>
            <p>Please summarise any additional information necessary to describe your qualifications for the position you are applying for.</p>
            <br />
            <textarea id="addInfo" name="addInfo" rows="8" style="width: 98%;" ></textarea>
        </div>

        <div class="element">
            <label for="file">Upload Resume</label>
            <p>&nbsp;&nbsp;Formats accepted: pdf, doc, docx, txt, odt</p>
            <br />
            <input type="file" name="userfile" id="file"  />
        </div>

		<div class="entry" style="height: 29px;">
			<button type="submit" style="float: right;"  >Submit</button>
		</div>
	</form>
    </div>
</div>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">
  $(function() {
    $( "#age1" ).datepicker({ dateFormat: "dd/mm/yy", maxDate: "-1y" ,changeYear: true,yearRange: "-50:+0",});
  });

    var techs = <?php echo json_encode($techs); ?>;

    $('#parentForm').submit(function()
    {
        return validateMentor();
    })

    function validateMentor()
    {
        if ($('#education').val() == '' || $('#education').val() == null)
            return showError('#eduVal');
        else
            $('#eduVal').hide();

        if (!$("input[name='crime']:checked").val())
            return showError('#crimeVal');
        else
            $('#crimeVal').hide();

         if ($("input[name='crime']:checked").val() == '1')
         {
            if ($('#crimeDetails').val() == '' || $('#crimeDetails').val() == null)
                return showError('#crimeDetailVal');
            else
                $('#crimeDetailVal').hide();
         }

        if (!$("input[name='workChild']:checked").val())
            return showError('#workChildVal');
        else
            $('#workChildVal').hide();


        if(!valTechs(techs,'expTech'))
            return showError('#expTechval');
        else
            $('#expTechval').hide();


        if ($('#references').val() == '' || $('#references').val() == null)
            return showError('#refval');
        else
            $('#refval').hide();


        if ($('#workExperience').val() == '' || $('#workExperience').val() == null)
            return showError('#workExpval');
        else
            $('#workExpval').hide();

        if (!$("input[name='contactEmployer']:checked").val())
            return showError('#contactVal');
        else
            $('#contactVal').hide();

        return true;
    }

    function showError(ele)
    {
        $(ele).show();
        $(window).scrollTop($(ele).offset().top - 10);
        return false;
    }

    function valTechs(values,text)
    {
        var valid = false;

        for(var cnt = 0; cnt < values.length; cnt++)
        {
            console.log(text + values[cnt]['name']);
            if ($("input[name='" + text + values[cnt]['name'] +"']:checked").val())
                valid = true;

        }
        return valid;
    }

</script>
