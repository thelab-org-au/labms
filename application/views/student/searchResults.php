
<div style="max-height: 500px; overflow-y: scroll;">
<input type="hidden" id="sessionReturn" value="<?php echo $session; ?>"/>
<table style="text-align: center;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Date of birth</th>
            <th>Add</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($data as $student)
            {
                echo '<tr>';
                
                echo '<td style="min-width:120px;">'.$student['name'].'</td>';
                echo '<td>'.$student['dob'].'</td>';
                echo '<td><a href="javascript:void(0);" class="table-icon add-user-icon" title="Add student"  onclick="javascript:addStudentSession('.$student['id'].');"></a></td>';
                echo '</tr>';
            }
        
        ?>
    </tbody>

</table>

<script type="text/javascript">
    
    function addStudentSession(id)
    {
        ajax.doReq('<?php echo site_url(); ?>/studentdetails/addToSession?session=' + $('#labSession').val() + '&student=' + id,addStudentCallback,null); 
    }
    
    function addStudentCallback(text,object)
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
<?php //echo json_encode($data); ?>
</div>
