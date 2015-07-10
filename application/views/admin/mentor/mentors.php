<div class="full_w" >
	<div class="h_title"><?php echo $title;?></div>
    <?php $this->load->view('display'); ?>

    <div id="mentorDetails">

    <div id="mentorSelectForm">
        <h3>Current mentors</h3>


        <form>
            <div class="element">
            	<select name="labCurrent" class="err" id="labCurr" onchange="labChange()">
            		<option value="-1">-All labs-</option>

                    <?php
                        foreach($labInfo as $lab)
                            echo '<option value="'.$lab['id'].'"'.( isset($sessionInfo) && ($lab['id'] == $sessionInfo[0]['location']) ? 'selected="selected"' : '' ) .'>'.$lab['name'].'</option>';

                    ?>

            	</select>

                <br />
                <br />
                <label for="searchFieldmentor">Search by name</label>
                <p><i>Leave blank to view all mentors</i></p>
        		<input id="searchFieldmentor" name="searchFieldmentor" class="text err" />&nbsp;&nbsp;
                <button onclick="return searchMentorName();">search</button>

            </div>
        </form>
    </div>
        <div id="mentors">
        </div>


       <!-- <h3>Previous mentors</h3> -->



     <div id="applicationsDisplay">
        <h3>Mentor applications</h3>

        <form>
            <div class="element">
            	<select name="labApplications" class="err" id="labApp" onchange="labChangeApp()">
            		<option value="-1">-All labs-</option>

                    <?php
                        foreach($labInfo as $lab)
                            echo '<option value="'.$lab['id'].'"'.( isset($sessionInfo) && ($lab['id'] == $sessionInfo[0]['location']) ? 'selected="selected"' : '' ) .'>'.$lab['name'].'</option>';

                    ?>

            	</select>

                <br />
                <br />
                <label for="searchField">Search by name</label>
                <p><i>Leave blank to view all applications</i></p>
        		<input id="searchField" name="searchField" class="text err" />&nbsp;&nbsp;
                <button onclick="return searchAppName();">search</button>
            </div>
        </form>

        <div id="applications">
        </div>
    </div>
   </div>

   <div id="mentorLabSelect" style="display: none; ">

    <?php echo form_open('admin/amentors/createMentor/',array('id' => 'addMentor')); ?>
        <table style="width: 300px; text-align: center;">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Location</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach($labInfo as $lab)
                    {
                        echo '<tr>';
                        echo '<td style="width:50px;"><input type="checkbox" name="'.$lab['name'].'" value="'.$lab['id'].'" /></td>';
                        echo '<td>' . $lab['name'] . '</td>';
                        echo '</tr>';
                    }

                ?>
            </tbody>

       </table>

       <input type="hidden" name="mentorId" id="mentorId" />
       <button>Submit</button>
       <button onclick="return closeDiv();">Close</button>
   </form>

   </div>

   <div id="removeLab" style="display: none;">

   </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">

    var ajax = new Ajax();
    function labChange()
    {
        var lab = $('#labCurr' );
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/getMentors?lab=' + lab.val(),applicationCallback,$('#mentors'));
        $('#mentors').html('');
    }

    function labChangeApp()
    {
        var lab = $('#labApp' );
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/getMentorApplications?lab=' + lab.val(),applicationCallback,$('#applications'));
        $('#applications').html('');
    }

    function searchMentorName()
    {
        var search = $('#searchFieldmentor').val();
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/searchMentors?search=' + search,applicationCallback,$('#mentors'));
        //$('#mentors').html('');
        $('#mentors').hide('fast');
        return false;
    }

    function searchAppName()
    {
        var search = $('#searchField').val();
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/searchApplications?search=' + search,applicationCallback,$('#applications'));

        //$('#applications').html('');
        $('#applications').hide('fast');
        return false;
    }

    function applicationCallback(text,object)
    {

         object.html(text);
         object.show('fast');
    }

    function appPagination(index)
    {
        var lab = $('#labApp' );
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/getMentorApplications?lab=' + lab.val() +'&start=' + index,applicationCallback,$('#applications'));
        $('#applications').html('');
    }

    function closeDiv()
    {
        $('#mentorId').val('');
        $('#mentorDetails').show('slow');
        $('#mentorLabSelect').hide('slow');
        return false;
    }

    function addMentor(id)
    {
        //alert('add');
        $('#mentorId').val(id);
        $('#mentorDetails').hide('slow');
        $('#mentorLabSelect').show('slow');
        closeRemoveDiv();
    }

    function removeLocations(id)
    {
        ajax.doReq('<?php echo site_url(); ?>/admin/amentors/getMentorLabs?id='+id,removeCallback,$('#removeLab'));
        $('#removeLab').html('');
    }

    function removeCallback(text,object)
    {
         object.html(text);
         object.show('fast');
        $('#applicationsDisplay').hide('slow');
        $('#mentorLabSelect').hide('slow');
        $('#mentorSelectForm').hide('slow');
    }

    function closeRemoveDiv()
    {
        $('#removeLab').hide('slow');
        $('#mentorSelectForm').show('slow');
        $('#applicationsDisplay').show('slow');
        return false;
    }

</script>
