<div class="full_w" >
	<div class="h_title">Sessions</div>
    <?php $this->load->view('display'); ?>
    
    <form>
        <button class="add" id="addSessionTime">Add session time</button>
        <button class="add" id="addTermDate">Add term dates</button>
        <button class="add" id="addLocationSession">Add location session</button>
    </form>
    
    
    <div id="addSessionDisplay" style="display: none;">
    <h3>Add session time</h3>
    
        <? echo form_open('admin/asessions/addsession/',array('id' => 'addsessionform')); ?> 
            <table style="width: 75%;">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th style="width: 50px;">Add</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <tr>
                        <td>
                            <select name="day" class="err" id="day">
                                <option value="-1">Select day</option>
                                <?php foreach($days as $day): ?>
                                    <option value="<?php echo $day;?>"><?php echo $day;?></option>                              
                                <?php endforeach;?>
                            </select>
                        
                        </td>
                        <td ><input name="start" value="" id="start" /></td>
                        <td ><input name="end" value="" id="end" /></td>
                        <td><button class="add" id="addSession">Add</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
        
        <h3>Existing session times</h3>    
        
        <form>
            <table style="width: 75%;">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start time</th>
                        <th>End time</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php foreach($sessionData as $session) : ?>
                        <tr>
                            <td><?php echo $session['day']; ?></td>
                            <td><?php echo $session['startTime']; ?></td>
                            <td><?php echo $session['endTime']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>    
    
    <div id="addTermDisplay" style="display: none;">   
    <h3>Add term dates</h3> 
    
        <? echo form_open('admin/asessions/addTerm/',array('id' => 'addTermform')); ?> 
            <table style="width: 75%;">
                <thead>
                    <tr>
                        <th >Start date</th>
                        <th>end date</th>
                        <th style="width: 50px;">Add</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input id="startDate" name="startDate" class="text err" /></td>
                        <td><input id="endDate" name="endDate" class="text err" /></td>
                        <td><button class="add" id="addTermSubmit">Add</button></td>
                    </tr>
                </tbody>
            </table>        
        </form>  
        
         <h3>Existing term dates</h3>    
        
        <form>
            <table style="width: 75%;">
                <thead>
                    <tr>
                        <th>Start date</th>
                        <th>End date</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php foreach($termData as $term) : ?>
                        <tr>
                            <td><?php echo $term['startDate']; ?></td>
                            <td><?php echo $term['endDate']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        
     </div>    
    
    <div id="addTermSessionDisplay" style="display: none;">   
    <h3>Add location session</h3> 
    
    <? echo form_open('admin/asessions/create/',array('id' => 'createsessionform')); ?> 
        <table style="width: 75%;">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Term</th>
                    <th>Session</th>
                    <th style="width: 50px;">Add</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <tr>
                    <td>
                        <select name="location" class="err" id="location">
                            <option value="-1">Select location</option>
                            <?php foreach($locations as $location): ?>
                                <option value="<?php echo $location['id'];?>"><?php echo $location['desc'];?></option>                              
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td>
                        <select name="term" class="err" id="term">
                            <option value="-1">Select term</option>
                            <?php foreach($terms as $term): ?>
                                <option value="<?php echo $term['id'];?>"><?php echo $term['desc'];?></option>                              
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td>
                        <select name="session" class="err" id="session">
                            <option value="-1">Select session</option>
                            <?php foreach($sessions as $session): ?>
                                <option value="<?php echo $session['id'];?>"><?php echo $session['desc'];?></option>                              
                            <?php endforeach;?>
                        </select>
                    </td>
                    <td><button class="add">Add</button></td>
                </tr>
            </tbody>
        
        </table>
    
    </form>
    </div> 
    
    <form><button id="closeDisplay" style="display: none;">Close</button></form>
    
    <div >
        <h3>Location sessions</h3>
        <table style="width: 96.5%;">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Term dates</th>
                    <th>Term length</th>
                    <th>Session time</th>
                    <th>Add students</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php
                    $c = 0;
                    foreach($termSessions as $row)
                    {
                        if($c == 0)
                        {
                            //var_dump($row);
                            $c++;
                        }

                        echo '<tr>';
                        echo '<td>'.$row['name'].'</td>';
                        echo '<td>'.$row['startDate']. ' - ' .$row['endDate'].'</td>';
                        echo '<td>'.$row['numWeeks'].' weeks</td>';
                        echo '<td>'.$row['day']. '  ' .$row['startTime']. ' - '.$row['endTime'] .'</td>';

                        if(datediff($row['endDate']))
                        {
                            echo '<td><a href="'.site_url().'/admin/assignSession?ti='.$row['termSessionId'].'&si='.$row['sessionTimeId'].'&li='.$row['locationId'].'" class="table-icon add-user-icon" title="Add students"></a></td>';
                        }
                        else
                            echo '<td>Session completed</td>';


                        echo '</tr>';
                    }


                    function datediff( $date2)
                    {
                        $first = date_create_from_format('d/m/Y', date('d/m/Y'));
                        $second = date_create_from_format('d/m/Y', $date2);
                        return ($first < $second);
                    }
                
                ?>
            </tbody>
        
        </table>
    
    </div>
    
</div>


<div id="dialog-message-sessions" title="Message" >
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="dialogMessage-sessions"></span></p>
</div>

<div id="dialog-confirm" title="Confirm" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="confirmMessage"></span></span></p>
</div>

<link href="<?php echo base_url(); ?>/css/jquery.ptTimeSelect.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery.ptTimeSelect.js"></script> 
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
    
    $(document).ready(function()
    {
        $('#start').timePicker({show24Hours: false,'step': 15 });
        $('#end').timePicker({show24Hours: false, 'step': 15 });
        
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate()+(7 * 3));
        $( "#startDate" ).datepicker({ dateFormat: "dd/mm/yy" });
        $( "#endDate" ).datepicker({ dateFormat: "dd/mm/yy" });
    });
    
    
    
    $('#addSession').click(function(event)
    {
        event.preventDefault();
        
        if(!valMessage($('#day'),'-1','Please select the day'))
            return;
        
        if(!valMessage($('#start'),'','Please select start time'))
            return;

        if(!valMessage($('#end'),'','Please select end time'))
            return;
            
        $('#confirmMessage').html('Add session data </br></br>' + $('#day').val() + ' ' + $('#start').val() + ' ' + $('#end').val());
         
        $( "#dialog-confirm" ).clone().dialog(
        {
              resizable: false,
              height:140,
              modal: true,
              buttons:
              {
                    "Add sesion": function() 
                    {
                        $( this ).dialog( "close" );
                        $('#addsessionform').submit();
                    },
                    Cancel: function() 
                    {
                        $( this ).dialog( "close" );
                    }                
              }             
        });  
    });

                
        
    
    
    
    
    $('#addTermSubmit').click(function(event)
    {
        event.preventDefault(); 

        if(!valMessage($('#startDate'),'','Please select start date'))
            return;

        if(!valMessage($('#endDate'),'','Please select end date'))
            return; 
            
         $('#confirmMessage').html('Add term data </br></br>'  + $('#startDate').val() + ' ' + $('#endDate').val());
         
        $( "#dialog-confirm" ).clone().dialog(
        {
              resizable: false,
              height:140,
              modal: true,
              buttons:
              {
                    "Add term": function() 
                    {
                        $( this ).dialog( "close" );
                        $('#addTermform').submit();
                    },
                    Cancel: function() 
                    {
                        $( this ).dialog( "close" );
                    }                
              }            
        });        
    });

    
    function valMessage(object,val,message)
    {
        if(object.val() == val)
        {
            $('#dialogMessage-sessions').html(message);
            $( "#dialog-message-sessions" ).dialog( "open" );
            return false;
        }
        
        return true;        
    };
    
    $('#addSessionTime').click(function(event)
    {
       event.preventDefault(); 
       $('#addSessionDisplay').show();
       $('#closeDisplay').show();
       $('#addTermDisplay').hide();
       $('#addTermSessionDisplay').hide();
    });
    
    $('#addTermDate').click(function(event)
    {
       event.preventDefault(); 
       $('#addTermDisplay').show();
       $('#closeDisplay').show();
       $('#addSessionDisplay').hide();
       $('#addTermSessionDisplay').hide();
    });
    
    $('#addLocationSession').click(function(event)
    {
       event.preventDefault(); 
       $('#addTermSessionDisplay').show();
       $('#closeDisplay').show();
       $('#addTermDisplay').hide();
       $('#addSessionDisplay').hide();
    });
    
    $('#closeDisplay').click(function(event)
    {
        event.preventDefault();
       $('#addTermSessionDisplay').hide();
       $('#addTermDisplay').hide();
       $('#addSessionDisplay').hide(); 
       $('#closeDisplay').hide(); 
    });
    
    
</script>



