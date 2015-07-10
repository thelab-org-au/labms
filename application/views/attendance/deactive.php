<?php
    if($preStudents != null)
    {
        echo '<h3>Previous students</h3>';
        echo '<table style="text-align: center; width: 50%;">';
        echo '<thead><tr>';
        echo '<th>Name</th>';
        echo '<th>Dob</th>';
        echo '<th>Add</th>';
        echo '</tr></thead><tbody>';
        
         foreach($preStudents as $student)
        {
            echo '<tr>';
            
            echo '<td style="width:120px;">'.$student['name'].'</td>';
            echo '<td>'.$student['dob'].'</td>';
            echo '<td><a href="javascript:void(0);" class="table-icon add-user-icon" title="Add student"  onclick="javascript:addStudentSessionPre('.$student['id'].');"></a></td>';
            echo '</tr>';
        }       
        
        echo '</tbody></table>';
    }
?>


<?php $this->load->view('pagination'); ?>


<script type="text/javascript">

    function paginationDeactive(index)
    {
        var val = $('#lab').val();
        
        var session = $('#lab' + val )
        ajax.doReq('<?php echo site_url(); ?>/attendance/getDeactiveStudents?session=' + session.val() +'&start=' + index,deActiveCallback,null);
        $('#dpage').val(index);
        $('#attDeRecords').hide('fast');        
    }
    
    function deActiveCallback(text,object)
    {
        var html = JSON.parse(text);
        $('#attDeRecords').html(html.deactive);
        $('#attDeRecords').show();
    }

</script>