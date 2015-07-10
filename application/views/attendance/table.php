<h3>Current students</h3>


<?php if(count($att) > 0) : ?>
<div style="overflow: auto;">
<table style="text-align: center; " >
	<thead>
		<tr>
			<th style="min-width: 120px">Name</th>
            <th style="min-width: 70px;">Details</th>
            <th style="min-width: 80px"><?php echo date("d-m-Y"); ?></th>
            
            <?php
            
                //echo $termLength[0]['numWeeks'];
                for($cnt = 0; $cnt < (int)$termLength[0]['numWeeks'] -1; $cnt++)
                    echo '<th style="min-width: 80px">Date</th>';
            ?>
		</tr>
	</thead>

    <tbody id="attendanceBody">
<?php

    $ids = '';
    foreach($att as $record)
    {
        echo '<tr>';
        echo '<td style="min-width: 120px">'.$record['name'].'</td>';
        echo '<td style="min-width: 70px;">';
        echo anchor_popup(site_url().'/studentdetails/student?id='.$record['id'], ' ', array('class' => 'table-icon edit','title' => 'Student details'));
        echo anchor_popup(site_url().'/studentdetails/contact?id='.$record['id'], ' ', array('class' => 'table-icon archive','title' => 'Contact details'));
        echo '<a href="javascript:void(0);" class="table-icon delete" title="Remove from session"  onclick="javascript:displayConfirm(\''.$record['id'].'\',\''.$record['name'].'\');"></a>';
        echo '</td>';
        
        
        $ids .= $record['id'].'-';
        $cnt = 0;
        
        $date = date("d-m-Y");
        if(isset($record['attendance'][0]) && $record['attendance'][0]['date'] == $date)
        {
            echo '<td><input type="checkbox" name="'.$record['id'].'" value="1" '.($record['attendance'][0]['present'] == '1' ? 'checked="checked"' : '').'  /></td>';
        }
        else
        {
            echo '<td><input type="checkbox" name="'.$record['id'].'" value="1"  /></td>';
        }
        
        for(; $cnt < sizeof($record['attendance']); $cnt++)
        {
            if($record['attendance'][$cnt]['date'] != $date)
            {
                echo '<td>'. ($record['attendance'][$cnt]['present'] == '1' ? $record['attendance'][$cnt]['date'] : 'No').'</td>';
                if($cnt == (int)$termLength[0]['numWeeks'])
                    break;                 
            }
        }
        
        //if(count($record['attendance']) == 0)
            $cnt++;
        
        if($cnt < (int)$termLength[0]['numWeeks'])
        {
            while($cnt < (int)$termLength[0]['numWeeks'])
            {
                echo '<td>-</td>';
                $cnt++;
            }
        }

        
        echo '<input type="hidden" name="ids" value="'.(substr($ids,0,strlen($ids) - 1 ) ).'" />';
        
        echo '</tr>';
    }
    
    echo '<input type="hidden" name="sess" value="'.$sess.'" />';
?>

    </tbody>                
</table>
</div>
<?php //$this->load->view('pagination'); ?>
<input type="hidden" id="dpage" value="<?php echo $dpage; ?>"/>
<?php else : ?>
    <p>No students found</p>
<?php endif; ?>

<div id="dialog-confirm" title="Remove student?">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="confirmMessage"></span></p>
</div>


<script type="text/javascript">

    $( "#dialog-confirm" ).dialog({
      resizable: false,
      autoOpen: false,
      height:140,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        Cancel: function() {
          $( this ).dialog( "close" );
        },
        "Remove student": function() {
          $( this ).dialog( "close" );
          deleteStudent(confirmId,confirmName);
        }
      }
    });

    
    var confirmId;
    var confirmName;
    function displayConfirm(id,name)
    {
        confirmId = id;
        confirmName = name;
        $('#confirmMessage').html('Are you sure you wish to remove ' + name.toUpperCase() +  ' from this session?')
       $( "#dialog-confirm"  ).dialog( "open" );
    }
 
    
    function deleteStudent(id,name)
    {
        var labVal = $('#lab').val();
        var session = $('#labSession').val();
        ajax.doReq('<?php echo site_url(); ?>/studentdetails/remove?id=' + id + '&session=' + session ,removeCallback,null);      
    }
    
    function removeCallback(text,object)
    {     
        if(text == '1')
           getStudentData(); 
    }

    function pagination(index)
    {
        var val = $('#lab').val();
        
        var session = $('#lab' + val )
        
        ajax.doReq('<?php echo site_url(); ?>/attendance/GetStudentData?session=' + $('#labSession').val() +'&start=' + index + '&page=true' +'&dpage=' + $('#dpage').val(),callback,null);
       // $('#pag').val(index);
        //$('#attRecords').hide('fast');
    }
    
    function addStudentSessionPre(id)
    {
                var val = $('#lab').val();
        
        var session = $('#labSession');
        ajax.doReq('<?php echo site_url(); ?>/studentdetails/addToSession?session=' + session.val() + '&student=' + id,addStudentCallbackPre,null); 
    }
    
    function addStudentCallbackPre(text,object)
    {
        if(isNumeric(text) || text == 'true')
            getStudentData();
        else
            alert(text);
    }
    
    function isNumeric(n) 
    {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>
