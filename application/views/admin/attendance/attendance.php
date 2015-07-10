<div class="full_w" style="min-height: 500px;">

	<div class="h_title">Attendance</div>



    <div id="attendanceRecords">



        <?php $this->load->view('display'); ?>



        <?php echo form_open('',array('id' => 'parentForm')); ?>

            <div class="element">






                <label for="lab">Location</label>
            	<select name="lab" class="err" id="lab" onchange="javascript:updateFields()">

            		<option value="-1">-Select Lab-</option>



                    <?php

                        foreach($labData as $lab)

                        {

                            echo '<option value="'.$lab['id'].'">'.$labNames[$lab['id']]['name'].'</option>';

                        }



                    ?>



            	</select>


            <!--
              	<select name="term" class="err" id="term" onchange="javascript:updateFields()" >

            		<option value="-1">-Select Term-</option>



                    <?php

                        foreach($labTerms as $lab)

                        {

                            echo '<option value="'.$lab['id'].'">'.$lab['desc'].'</option>';



                        }



                    ?>



            	</select>



              	<select name="session" class="err" id="session" onchange="javascript:updateFields()">

            		<option value="-1">-Select Session-</option>



                    <?php

                        foreach($labSessions as $lab)

                        {

                            echo '<option value="'.$lab['id'].'">'.$lab['desc'].'</option>';



                        }



                    ?>



            	</select>
            -->




                <!--<button id="search">Search</button>-->

            </div>

        </form>

    </div>



    <div id="attRecords">



    </div>





</div>



<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>

<script type="text/javascript">



    var ajax = null;

    $('#lab').ready(function(){

        ajax = new Ajax();

    })



    $('#search').click(function(e)

    {

        e.preventDefault();

        updateFields();

        return false;

    });





    function updateFields()

    {
        /*ajax.doReq('<?php echo site_url(); ?>/admin/aAttendance/process?location=' + $('#lab').val() +

                                                                        '&term='+$('#term').val()+

                                                                        '&session=' + $('#session').val(),callback,null);*/

        ajax.doReq('<?php echo site_url(); ?>/admin/aAttendance/getLocationData?location=' + $('#lab').val(),callback,null);

    }



    function callback(text,object)

    {

        $('#attRecords').html(text);

    }





</script>
