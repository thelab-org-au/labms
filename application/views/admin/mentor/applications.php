<table style="text-align: center; " >

    <?php //var_dump($applications);?>
    <?php if (count($applications) >0) : ?>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Age</th>
            <th>Address</th>
            <th style="min-width: 95px;">Location applied</th>
            <th>details</th>
        </tr>
    </thead>
    
    <tbody>
        <?php
        
            foreach($applications as $app)
            {
                echo '<tr>';
                echo '<td>'.$app['firstName']. ' '. $app['lastName'].'</td>';
                echo '<td>'.$app['email'].'</td>';
                echo '<td>'.$app['phone'].'</td>';
                echo '<td>'.$app['dob'].'</td>';
                echo '<td>'.$app['address'].' '.$app['suburb'].'</td>';
                echo '<td>'.$locations[$app['location']].'</td>';
  
                echo '<td>'.anchor_popup(site_url().'/admin/amentors/view?id='.$app['id'], ' ', array('class' => 'table-icon archive','title' => 'Application details', 'width' => '800'));
                echo '<a href="javascript:void(0);" class="table-icon add-user-icon" title="Add as mentor"  onclick="javascript:addMentor(\''.$app['id'].'\');"></a></td>';     
            }
            
        ?>
    </tbody>
    <?php else :?>
        <div>
            <h3>No records found</h3>
        </div>
    <?php endif;?>
</table>

<?php $this->load->view('pagination'); ?>

<script type="text/javascript">


</script>