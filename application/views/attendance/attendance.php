<div class="full_w" style="min-height: 500px;">
	<div class="h_title">Attendance</div>
    
    <div id="attendanceRecords">
        <?php $this->load->view('display'); ?>
            <?php // echo form_open('signup/waitlist/signup/',array('id' => 'parentForm')); ?> 
            <form>
            <?php
                if(isset($sessionInfo))
                {
                    echo '<input type="hidden" id="sessId" name="sessId" value="'.$sessionInfo[0]['id'].'" />';
                }
            ?>
            
            
            <div class="element">
        		<select name="lab" class="err" id="lab" onchange="labChange()">
        			<option value="-1">-Select Lab-</option>
                    
                    <?php 
                        foreach($labInfo as $lab)
                            echo '<option value="'.$lab['id'].'"'.( isset($sessionInfo) && ($lab['id'] == $sessionInfo[0]['location']) ? 'selected="selected"' : '' ) .'>'.$lab['name'].'</option>'; 
                           
                    ?>
                    
        		</select>
                    
                    <input type="hidden" name="labCount" id="labCount" value="<?php echo sizeof($labInfo); ?>" /> 
                 
                 <span id="sessionSelect"> 
                 
                    <?php if(isset($selectedSession)) echo $selectedSession;?>
                    </span> 
          </form>
                <?php
                    /*
                    foreach($labInfo as $lab)
                    {
                        if(isset($lab['sessions']) && sizeof($lab['sessions']) > 0)
                        {
							$display = false;
							if(isset($sessionInfo))
							{
								foreach($lab['sessions'] as $session)
								{
									if($session['id'] == $sessionInfo[0]['id'])
										$display = true;
								
								}
							}

                            if($display)
                                echo '&nbsp;<select  name="lab'.$lab['id'].'" class="err" id="lab'.$lab['id'].'" onchange="getStudentData()">';
                            else
                                echo  '&nbsp;<select style="display:none;" name="lab'.$lab['id'].'" class="err" id="lab'.$lab['id'].'" onchange="getStudentData()">';
                           echo '<option value="-1">-Select Session-</option>';
                           
                                foreach($lab['sessions'] as $session)
                                    echo '<option value="'.$session['id'].'"'.(isset($sessionInfo) && ($session['id'] == $sessionInfo[0]['id']) ? 'selected="selected"' : '' ) .'>'.$session['desc'].'</option>';
                                                        
                           echo '</select>';                    
                        }
                    }*/
                ?> 
                 
            </div>
       <!-- </form> -->
        
        <? echo form_open('attendance/process',array('id' => 'parentForm')); ?> 
        
            <div id="attRecords">

            </div>
            
            <div id="attDeRecords">

            </div>
            
    		<div class="entry" style="height: 29px;">
                <button type="submit" class="add" id="addChild" style="display: none;" onclick=" return false;">Add student</button> 
    			<button type="submit" style="float: right; display: none;" id="addAttendance" >Submit</button>
    		</div>
        </form>

    </div>
    
    <div id="addStudent" style="display: none;">
        <h3>Add student</h3>
        
        <div class="element">
            <form>
                <label for="labadd">Search by location</label>
                <select name="labadd" class="err" id="labAdd" onchange="searchByLab()" >
                    <option value="-1">-Select Lab-</option>
                    
                    <?php 
                        foreach($labInfo as $lab)
                            echo '<option value="'.$lab['id'].'"'.( isset($sessionInfo) && ($lab['id'] == $sessionInfo[0]['location']) ? 'selected="selected"' : '' ) .'>'.$lab['name'].'</option>'; 
                           
                    ?>
                
                </select>
            </form>
        </div>
        
        <div class="element">
            <form>
                <label for="labadd">Add new student</label>
                <button type="submit" id="newStudent" onclick=" return false;">New student</button>
           </form>     
        </div>
        
        <div class="element">
        
            <form>
                <label for="searchField">Search by name</label>
                <p>Leave blank to view all students</p>
    			<input id="searchField" name="searchField" class="text err" />
                &nbsp;&nbsp;&nbsp;
                <button type="submit" id="find" onclick=" return false;">Search</button>
                <br />
                <br />
                <button type="submit" id="close" onclick=" return false;">Close</button>
            </form>
        </div> 
        

        
        <div class="element">
            <div id="searchResults">
            </div>
        </div> 
         
    </div>  
    
    <div id="newStudentForm" style="display: none;">
        <?php $this->load->view('student/add'); ?>
    </div> 
</div>


<div id="dialog-message" title="Message" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="dialogMessage">Please select lab location and session</span></p>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">

    $( "#dialog-message" ).dialog({
      resizable: false,
      autoOpen: false,
      height:100,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        "Close": function() {
          $( this ).dialog( "close" );
          $('#dialogMessage').html('Please select lab location and session');
        }
      }
    });
	
	$('#addAttendance').click(function(event){
		if($('#attendanceBody tr').length == 0)
        {
            event.preventDefault();
            $('#dialogMessage').html('Please add students to the session');
            $( "#dialog-message"  ).dialog( "open" );
        }
			
	});

Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};

    var ajax = null;
    $('#lab').ready(function(){
        ajax = new Ajax();
        var now = new Date();
    })
    
    $('#attRecords').ready(function(){
        var session = $('#sessId' );
        //console.log(session);
        if(typeof session.val() != 'undefined')
        {
            
            ajax.doReq('<?php echo site_url(); ?>/attendance/GetStudentData?session=' + session.val(),callback,null); 
         }       
    })
    
    $('#addChild').click(function(){
        addStudent();
    })
    
    $('#close').click(function(){
        $('#attendanceRecords').show();
        $('#addStudent').hide();
    })
    
    $('#newStudent').click(function(){
        $('#addStudent').hide();
        $('#newStudentForm').show();
    })
    
    $('#cancelAdd').click(function()
    {
         $('#newStudentForm').hide();
        $('#addStudent').show();       
    })
    
    $('#find').click(function(){
        searchStudents();
    })
    
    function labChange()
    {
       $('#attRecords').hide();
        $('#addAttendance').hide();
        $('#addChild').hide();
        var labCount = $('#labCount').val();
        var val = $('#lab').val();
        
        $('#ok').remove();
        
        $("#main").mask("Loading...");
        $.get('attendance/getLabSessions?id=' + val, {}, 
            function(returnedData,status)
            {
                if(status == 'success')
                {
                    if(returnedData)
                    {
                        $("#sessionSelect").html(returnedData);
                    }
                        
                    else
                    {
                        window.location.href = '<?php echo site_url(); ?>/attendance';
                    }
                        
                }
                $("#main").unmask();
            }
        );  
    }
    
    function getStudentData()
    {
        
        
        var val = $('#lab').val();
        
        var session = $('#labSession');
        
        if(session.val() == '-1')
            return;
        
        $('#ok').remove();
        
        $('#addToSession').val(session.val());
        
        $("#main").mask("Loading...");
        $.get('<?php echo site_url(); ?>/attendance/GetStudentData?session=' + session.val() +'&start=1', {}, 
            function(returnedData,status)
            {
                if(status == 'success')
                {
                    if(returnedData)
                    {
                        var html = JSON.parse(returnedData);
                        $('#attendanceRecords').show();
                        $('#addStudent').hide();
                        $('#attRecords').html(html.active);
                        $('#attRecords').show();
                        
                        if(html.hasOwnProperty('deactive'))
                            $('#attDeRecords').html(html.deactive);
                            
                        
                        $('#addAttendance').show();
                        $('#addChild').show();
                    }
                    else
                        window.location.href = '<?php echo site_url(); ?>/attendance';
                        
                }
                $("#main").unmask();
            }
        );  
        
    }
    
    function callback(text,object)
    {
        var html = JSON.parse(text);
        $('#attendanceRecords').show();
        $('#addStudent').hide();
        $('#attRecords').html(html.active);
        $('#attRecords').show();
        
        if(html.hasOwnProperty('deactive'))
            $('#attDeRecords').html(html.deactive);
            
        
        
        $('#addAttendance').show();
        $('#addChild').show();
        $("#main").unmask();
        
    }
    
    function addStudent()
    {
        $(window).scrollTop(window);
        var labVal = $('#lab').val();
        if(labVal == '-1' || $('#lab' + labVal).val() == '-1')
        {
            //alert('Please select lab location and session');
            $( "#dialog-message"  ).dialog( "open" );
            return;
        }
        
        $('#attendanceRecords').hide();
        $('#searchResults').html('');
        $('#addStudent').show();
        
    }
    
    function searchByLab()
    {
        var labVal = $('#lab').val();
        var session = $('#lab' + labVal).val();
        if($('#labAdd').val() != '-1')
         {  //ajax.doReq('<?php echo site_url(); ?>/studentdetails/findStudentLab?search=' + $('#labAdd').val() + '&session=' + session,searchCallback,null);
            
            $("#main").mask("Loading...");
            $.get('<?php echo site_url(); ?>/studentdetails/findStudentLab?search=' + $('#labAdd').val() + '&session=' + session, {}, 
                function(returnedData,status)
                {
                    if(status == 'success')
                    {
                        if(returnedData)
                        {
                            $('#searchResults').html(returnedData);
                        }
                        else
                            window.location.href = '<?php echo site_url(); ?>/attendance';                        
                    }
                    $("#main").unmask();
                }
            );
        }
    }
    
    function searchStudents()
    {
        var labVal = $('#lab').val();
        var session = $('#lab' + labVal).val();
        //ajax.doReq('<?php echo site_url(); ?>/studentdetails/findStudent?search=' + $('#searchField').val() + '&session=' + session,searchCallback,null);
            $("#main").mask("Loading...");
            $.get('<?php echo site_url(); ?>/studentdetails/findStudent?search=' + $('#searchField').val() + '&session=' + session, {}, 
                function(returnedData,status)
                {
                    if(status == 'success')
                    {
                        if(returnedData)
                        {
                            $('#searchResults').html(returnedData);
                        }
                        else
                            window.location.href = '<?php echo site_url(); ?>/attendance';                        
                    }
                    $("#main").unmask();
                }
            );
    }
    
    function searchCallback(text,object)
    {
        $('#searchResults').html(text);
    }
    


</script>


