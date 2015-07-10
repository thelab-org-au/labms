<div class="full_w" >
	<div class="h_title">Sessions</div>
    <?php $this->load->view('display'); ?>

    <h3>Add session</h3>

        <?php echo form_open('admin/asessions/addsession/',array('id' => 'addsessionform')); ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 200px;">Location</th>
                        <th>Description</th>
                        <th style="width: 50px;">Add</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="labLoc" class="err" id="labLoc">
                                <option value="-2">Select location</option>
                                <?php foreach($locations as $loc): ?>
                                    <option value="<?php echo $loc['id'];?>"><?php echo $loc['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td style="padding-right: 20px;"><input style="width: 100%;" type="text" name="sessionDesc" id="sessionDesc" /></td>
                        <td><button id="addSession">Add</button></td>
                    </tr>
                </tbody>
            </table>
        </form>

    <h3>Edit session</h3>
    <?php echo form_open('admin/asessions/editSession/',array('id' => 'editsessionform')); ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%">location</th>
                    <th style="width: 25%">session</th>
                    <th style="width: 50%">description</th>
                    <th >update</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="location" class="err" id="labLocEdit">
                            <option value="-2">Select location</option>
                            <?php foreach($locations as $loc): ?>
                                <option value="<?php echo $loc['id'];?>"><?php echo $loc['name'];?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td>
                    <?php

                    foreach($labInfo as $lab)
                    {
                        if(isset($lab['sessions']) && sizeof($lab['sessions']) > 0)
                        {

                            if(isset($sessionInfo))
                                echo  '&nbsp;<select  name="lab'.$lab['id'].'" class="err editSession" id="labEdit'.$lab['id'].'" >';
                            else
                                echo  '&nbsp;<select style="display:none;" name="lab'.$lab['id'].'" class="err editSession" id="labEdit'.$lab['id'].'" >';

                           echo '<option value="-1">-Select Session-</option>';

                                foreach($lab['sessions'] as $session)
                                    echo '<option value="'.$session['id'].'"'.(isset($sessionInfo) && ($session['id'] == $sessionInfo[0]['id']) ? 'selected="selected"' : '' ) .'>'.$session['desc'].'</option>';

                           echo '</select>';
                        }
                    }
                ?>

                    </td>

                    <td ><input style="width: 97%;" type="text" name="editDesc" id="editDesc" /></td>
                    <td><button id="editSession">Update</button></td>
                </tr>
            </tbody>
        </table>
    </form>

    <h3>Add term</h3>
        <?php echo form_open('admin/asessions/addTerm/',array('id' => 'addsessionform')); ?>

            <label for="lab">Location <span class="red">(required)</span></label>
            <select name="lab" class="err" id="lab" onchange="labChangeSession()">
                <option value="-2">Select location</option>
                <!--<option value="-1">All labs</option>-->
                <?php foreach($locations as $loc): ?>
                    <option value="<?php echo $loc['id'];?>"><?php echo $loc['name'];?></option>
                <?php endforeach;?>
            </select>

        <input type="hidden" name="labCount" id="labCount" value="<?php echo sizeof($labInfo); ?>" />
  <div id="termAddDisplay">
                 <span id="sessionLabel" style="display: none;">
                     <br />
                     <br />
                    <label  >Session <span class="red">(required)</span></label>
                </span>

                <?php

                    foreach($labInfo as $lab)
                    {
                        if(isset($lab['sessions']) && sizeof($lab['sessions']) > 0)
                        {

                            if(isset($sessionInfo))
                                echo  '&nbsp;<select  name="lab'.$lab['id'].'" class="err" id="lab'.$lab['id'].'" >';
                            else
                                echo  '&nbsp;<select style="display:none;" name="lab'.$lab['id'].'" class="err" id="lab'.$lab['id'].'" >';

                           echo '<option value="-1">-Select Session-</option>';

                                foreach($lab['sessions'] as $session)
                                    echo '<option value="'.$session['id'].'"'.(isset($sessionInfo) && ($session['id'] == $sessionInfo[0]['id']) ? 'selected="selected"' : '' ) .'>'.$session['desc'].'</option>';

                           echo '</select>';
                        }
                    }
                ?>
                <span id="dates" style="display: none;">
                    <br />
                    <br />
                    <label for="startDate" >Start date <span class="red">(required)</span></label>
                    <input id="startDate" name="startDate" class="text err" />

                    <br />
                    <br />
                    <label for="endDate" >End date <span class="red">(required)</span></label>
                    <input id="endDate" name="endDate" class="text err" />

                    <br />
                    <br />
                    <button class="add">Add</button>
                </span>
        </form>
</div>
        <div id="sessionList">
            <?php $this->load->view('admin/sessions/showsessions'); ?>
        </div>

</div>


<div id="dialog-message-sessions" title="Message">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="dialogMessage-sessions">Please select lab location and session</span></p>
</div>

<script type="text/javascript">
      $( "#dialog-message-sessions" ).dialog({
      resizable: false,
      autoOpen: false,
      height:100,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        "Close": function() {
          $( this ).dialog( "close" );
        }
      }
    });

  $(function() {

    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate()+(7 * 5));
    $( "#startDate" ).datepicker({ dateFormat: "dd/mm/yy", minDate: today });
    $( "#endDate" ).datepicker({ dateFormat: "dd/mm/yy", minDate: tomorrow });
  });


  $('#addSession').click(function(){

    if($('#labLoc').val() == '-2')
    {
        $('#dialogMessage-sessions').html('Please select location!');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        return false;
    }

    if($.trim($('#sessionDesc').val()) == '')
    {
        $('#dialogMessage-sessions').html('Please enter session description');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        return false;
    }
  })

  $('#labLocEdit').change(function()
  {
    //alert($('#labLocEdit').val());
    $('#labEdit' + $('#labLocEdit').val()).show();

    $('select.editSession').each(function() {
       console.log(this.name);
       if(this.name != 'lab' + $('#labLocEdit').val())
       {
            $(this).hide();
            $(this).val('-1')
       }
    });
  });

  $("#editSession").click(function(event)
  {
    if($('#labLocEdit').val() == '-2')
    {
        $('#dialogMessage-sessions').html('Please select a location');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        event.preventDefault();
        return;
    }

    if($('#labEdit' + $('#labLocEdit').val()).val() == '-1')
    {
        $('#dialogMessage-sessions').html('Please select a session');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        event.preventDefault();
        return;
    }

    if($('#editDesc').val() == '')
    {
        $('#dialogMessage-sessions').html('Please enter a new description');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        event.preventDefault();
        return;
    }

    if($('#labEdit' + $('#labLocEdit').val() + ' option:selected').text() == $('#editDesc').val())
    {
        $('#dialogMessage-sessions').html('New description matches old description');
        $( "#dialog-message-sessions"  ).dialog( "open" );
        event.preventDefault();
        return;
    }
  });


    function labChangeSession()
    {
        $('#labSessionDsiplay').hide();
        $('#labList').val('-1');

        $('#termAddDisplay').show();
        var labCount = $('#labCount').val();
        var val = $('#lab').val();

        $('#lab' + val ).show();


        for(var cnt = 1; cnt <= labCount; cnt++)
        {
            if(cnt != val)
            {
               $('#lab' + cnt ).hide();
               $('#lab' + cnt ).val('-1');
            }
        }

        if(typeof  $('#lab' + val ).val() == 'undefined')
        {
            $('#dates').hide();
            $('#sessionLabel').hide();
        }
        else
        {
            $('#dates').show();
            $('#sessionLabel').show();
        }


    }

</script>
