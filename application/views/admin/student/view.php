<h3>Current students</h3>
<div style="overflow: auto; max-height: 500px;">
<table style="text-align: center;">
    <thead>
        <tr>
            <th style="width: 30%;">Name</th>
            <th>Date of birth</th>
            <th>Location</th>
            <th>View</th>
        </tr>
    </thead>
    
    <tbody style="overflow: auto; max-height: 500px;">
        <?php
            foreach($students as $student)
            {
                echo '<tr>';
                echo '<td>'.$student['name'].'</td>';
                echo '<td>'.$student['dob'].'</td>';
                echo '<td>'.$student['locname'].'</td>';
                 echo '<td>'.anchor_popup(site_url().'/studentdetails/student?id='.$student['id'].'&admin=true', ' ', array('class' => 'table-icon archive','title' => 'Student details'));
                 echo '<a href="'.site_url().'/admin/astudents/editStudentDisplay?sid='.$student['id'].'" class="table-icon edit" title="Edit" ></a>'.'</td>';
                // echo '<a href="javascript:void(0);" class="table-icon edit" title="Edit"  onclick="javascript:addMentor(\''.$student['id'].'\');"></a>';
                // echo '<a href="javascript:void(0);" class="table-icon delete" title="Deactivate"  onclick="javascript:deactivate(\''.$student['id'].'\');"></a></td>';
;                echo '</tr>';
            }
        
        ?>
    </tbody>

</table>
</div>
<?php $this->load->view('pagination'); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">
    
    var ajax = new Ajax();
    function deactivate(id)
    {
        //ajax.doReq('<?php echo site_url(); ?>/admin/astudents/deactivate?id=' + id ,Callback,null);  
        $.ajax({
            url: '<?php echo site_url(); ?>/admin/astudents/deactivate?id=' + id, 
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
                  location.reload();
                }

				
				$("#main").unmask();                  
            }
        });
    }
    
    function Callback(text,object)
    {
       //alert(text);
       location.reload();
    }

</script>