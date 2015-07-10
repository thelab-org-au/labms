<h3>Previous students</h3>
<table style="text-align: center;">
    <thead>
        <tr>
            <th style="width: 200px;">Name</th>
            <th>Date of birth</th>
            <th>Location</th>
            <th>View</th>
        </tr>
    </thead>
    
    <tbody>
        <?php
            foreach($nonstudents as $student)
            {
                echo '<tr>';
                echo '<td>'.$student['name'].'</td>';
                echo '<td>'.$student['dob'].'</td>';
                echo '<td>'.$student['locname'].'</td>';
                 echo '<td>'.anchor_popup(site_url().'/studentdetails/student?id='.$student['id'].'&admin=true', ' ', array('class' => 'table-icon archive','title' => 'Student details'));
                echo '<a href="'.site_url().'/admin/astudents/editStudentDisplay?sid='.$student['id'].'" class="table-icon edit" title="Edit" ></a>'.'</td>';
                // echo '<a href="javascript:void(0);" class="table-icon edit" title="Edit"  onclick="javascript:addMentor(\''.$student['id'].'\');"></a></td>';
                // echo '<a href="javascript:void(0);" class="table-icon delete" title="Deactivate"  onclick="javascript:activate(\''.$student['id'].'\');"></a>';
;                echo '</tr>';
            }
        
        ?>
    </tbody>

</table>
<?php $this->load->view('pagination'); ?>

<?php
     //var_dump($students[0]); 
?>