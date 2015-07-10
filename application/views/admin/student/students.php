<div class="full_w" style="min-height: 500px;">
	<div class="h_title">Students</div>
    
    
    <div id="studentSearch" class="element">
    
        <form>
        	<label for="lab">Lab location</label>
			<select name="lab" class="err" id="lab" onchange="labChange()">
				<option value="-2">All labs</option>
                
                <?php 
                    foreach($locations as $lab)
                       echo '<option value="'.$lab['id'].'">'.$lab['name'].'</option>'; 
                ?>
                
			</select>
            
            <br />
            <br />
            <label for="name">Search by name</label>
            <p>Leave blank for all students</p>
            <input id="name" name="name" class="text err" />
                &nbsp;&nbsp;&nbsp;
                <button type="submit" id="find" onclick=" return false;">Search</button>
            
            <span class="element"></span>
        </form>
    
    </div>
    
    <div id="studentAdd"></div>
    
    
    <div id="studentDisplay" class="tableDiv">
        <?php   echo $active; ?>
    
    </div>
    
    
     <div id="deactiveStudents" class="tableDiv">
        <?php echo $deactive; ?>
    
    </div>   
    
</div>

<script type="text/javascript">
 
    $('#find').click(function(){
        $('#lab').val('-1');
        //ajax.doReq('<?php echo site_url(); ?>/admin/astudents/getByName?find=' + $('#name').val(),setText,null);
         $.ajax({
        	url: '<?php echo site_url(); ?>/admin/astudents/getByName?find=' + $('#name').val(), 
        	type: 'get',
        	error: function(XMLHttpRequest, textStatus, errorThrown)
        	{
        		   $("#main").unmask();
        		   $("#dialogMessageAjaxError").html(errorThrown);
        		   $( "#dialog-message-ajax-error"  ).dialog( "open" );
        	},
        	success: function(returnedData,status)
        	{
        		if(status == 'success')
        		{
                    var html = JSON.parse(returnedData);
                    $('#studentDisplay').html(html.active);
                    $('#deactiveStudents').html(html.deactive);
                    $('#studentDisplay').show('fast');
                    $('#deactiveStudents').show('fast');		  
        		}
        
        		
        		$("#main").unmask();                  
        	}
        });

        $('#studentDisplay').hide('fast');
        $('#deactiveStudents').hide('fast');
        return false; 
    });
 
    function labChange()
    {
        var val = $('#lab').val();
        ajax.doReq('<?php echo site_url(); ?>/admin/astudents/getByLab?lab=' + val,setText,null); 

        $('#studentDisplay').hide('fast');
        $('#deactiveStudents').hide('fast');
    }
    
    function setText(text,object)
    {
        var html = JSON.parse(text);
        $('#studentDisplay').html(html.active);
        $('#deactiveStudents').html(html.deactive);
        $('#studentDisplay').show('fast');
        $('#deactiveStudents').show('fast');
    }   

</script>