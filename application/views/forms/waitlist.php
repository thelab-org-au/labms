<div class="half_w half_left" style="width: 50%;"  >
	<div class="h_title">The Lab Membership Request</div>

    <div style="margin: auto;">


    <?php

        if(isset($valError))
            echo '<div style="padding:10px; color: red;">'. $valError . '</div>';

    ?>
    <?php echo validation_errors(); ?>

	<?php echo form_open('signup/waitlist/signup/',array('id' => 'parentForm')); ?>

         <div class="element">
        <p>Please fill out the following form and we will let you know when spaces become available at The Lab. </p>
        <p><i>Please note that all details are confidential.</i></p>
    </div>

        <?php
            if(!$loggedin)
            {
                echo '<div class="element">';
                echo '<p>If you have previously created an account please <a href="'.site_url().'/user/login?page=wait" style="color:#0000FF; text-decoration: underline;">LOGIN</a> </p>';
                echo '</div>';
                $this->load->view('forms/baseform');
            }
         ?>


        <div class="element">
			<label for="lab">Preferred Lab <span class="red">(required)</span></label>
			<select name="lab" class="err" id="lab">
				<option value="-1">-Select Lab-</option>

                <?php
                    foreach($labs as $lab)
                       echo '<option value="'.$lab['id'].'">'.$lab['name'].'</option>';
                ?>

			</select>
            <span id="labVal" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please select a lab</span>

            <br />
            <br />

		</div>


        <div class="element">
            <button type="submit" class="add" id="addContact" onclick=" return false;"> Add additional parent/contact</button>
        </div>
            <div class="element">
            <div class="h_title">Contacts</div>
            <div id="contactDetails" >

            </div>
            <input type="hidden" name="contactCount" id="contactCount" value="0" />

        </div>

        <div class="element">
        <div class="h_title">Child details</div>
        <div id="childData">
        <?php //$this->load->view('forms/waitlistdata'); ?>
        </div>
        </div>

        <div class="element">
            <button id="addChildButton" onclick="return waitlistForm(); return false;" class="add" >Add another child from the same family</button>
        </div>
		<div class="entry" style="height: 29px;">
			<button   type="submit" style="float: right;"  >Submit</button>
		</div>

            <input type="hidden" name="childCount" id="childCount" value="1" />
    <input type="hidden" name="totalChildCount" id="totalChildCount" value="-1" />

    <br />
    <h2>Thank you!</h2>
    <p>We will be in touch over the coming weeks.</p>
	</form>


    </div>

</div>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>

<script type="text/javascript">

    var ajax =new Ajax();
    var childDatacount = -1;
    var count = 0;
    var childDetails = $('#contactDetails');
    var childCount = $('#contactCount');


  function waitlistForm()
  {
    $('#addChildButton').hide();
    childDatacount++;
    ajax.doReq('<?php echo site_url(); ?>/signup/waitlist/getChildForm?count=' +childDatacount ,addChild,null);
    return false;
  }



  function addChild(text,object)
  {

    $('#childData').append('<div class="element">');
    $('#childData').append(text);
    $('#childData').append('</div>');

    $( "#age" + childDatacount ).datepicker({ dateFormat: "dd/mm/yy", maxDate: "-1y" });
    $(window).scrollTop($('#name' + childDatacount).offset().top - 40);


    $('#totalChildCount').val(childDatacount);

    $('#addChildButton').show();
    return false;
  }

    //add new child fields to form
    $('#addContact').click(function()
    {
        count++;
        childDetails.append('<div  class="element">');
        childDetails.append('<br/><label for="cName' + count + '">Contact\'s name</label><input id="cName' + count + '" name="cName' + count + '" class="text err" />');
        childDetails.append('<br/><br/><label for="cPhone' + count + '">Contact\'s phone number</label><input id="cPhone' + count + '" name="cPhone' + count + '" class="text err" />');
        childDetails.append('</div>');
        childCount.val(count);
    })


    $('#parentForm').submit(function()
    {
         return validateStudent();
    })

    function validateStudent()
    {
        var techs = <?php echo json_encode($techs); ?>;
        var schools = <?php echo json_encode($schools); ?>;
        var conditions = <?php echo json_encode($conditions); ?>;

        var count = $('#totalChildCount').val();

        if(count == '-1')
        {
            alert('Please enter child details');
            return false;
        }


        for(var cnt = 0; cnt <= parseInt(count); cnt++)
        {
            if($('#name' + cnt).val() === '')
                return showError('#nameval' + cnt)
           else
                $('#nameval' + cnt).hide();

            if($('#age' + cnt).val() === '')
                return showError('#ageval' + cnt)
           else
                $('#ageval' + cnt).hide();


            if(!valArray(schools,'otherText' + cnt))
                return showError('#typeval' + cnt);
            else
                $('#typeval'+ cnt).hide();


            if (!$("input[name='days"+ cnt+ "']:checked").val())
                return showError('#daysval'+ cnt);
            else
                $('#daysval'+ cnt).hide();

            if(!valArray(conditions,'otherConditionText'+ cnt))
                return showError('#conval'+ cnt);
            else
                $('#conval'+ cnt).hide();

            if(!valTechs(techs,'exp',cnt))
                return showError('#expval'+ cnt);
            else
                $('#expval'+ cnt).hide();

            if(!valTechs(techs,'intrest',cnt))
                return showError('#intrestval'+ cnt);
            else
                $('#intrestval'+ cnt).hide();

            if (!$("input[name='interested"+ cnt+ "']:checked").val())
                return showError('#inval'+ cnt);
            else
                $('#inval'+ cnt).hide();

            if ($("input[name='interested"+ cnt + "']").val() == '4' && $('#otherintrestText'+ cnt).val() == '')
                return showError('#inval'+ cnt);
            else
                $('#inval'+ cnt).hide();

            if (!$("input[name='pc"+ cnt+"']:checked").val())
                return showError('#pcval'+ cnt);
            else
                $('#pcval'+ cnt).hide();
        }

        return true;
    }

    function showError(ele)
    {
        alert(ele);
        $(ele).show();
        $(window).scrollTop($(ele).offset().top - 10);
        return false;
    }

    function valArray(values,text)
    {
        var valid = false;
        text = typeof text !== 'undefined' ? text : '';

        if(text != '')
            valid = ($('#' + text).val() != '');

        for(var cnt = 0; cnt < values.length; cnt++)
        {
            if ($("input[name='" + values[cnt]['name'] +"']:checked").val())
                valid = true;

        }
        return valid;
    }

    function valTechs(values,text,count)
    {
        var valid = false;

        for(var cnt = 0; cnt < values.length; cnt++)
        {
            console.log(text + values[cnt]['name'] + count);
            if ($("input[name='" + text + values[cnt]['name'] + count +"']:checked").val())
                valid = true;

        }
        return valid;
    }

</script>

