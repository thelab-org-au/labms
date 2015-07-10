<table style="text-align: center; " >

    <?php //var_dump($applications);?>
    <?php if (count($applications) > 0) : ?>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Age</th>
            <th>Address</th>
            <th style="min-width: 95px;">Locations</th>
            <th style="min-width: 70px;">details</th>
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
                
                $loc = '';
                
                foreach($app['locations'] as $l)
                    $loc .= $locations[$l['location']] .', ';
                
                
                echo '<td>'.substr(trim($loc),0,(strlen(trim($loc)) - 1)).'</td>';
                //echo '<td></td>';
                echo '<td>'.anchor_popup(site_url().'/admin/amentors/view?id='.$app['id'].'&m=true', ' ', array('class' => 'table-icon archive','title' => 'Application details', 'width' => '800'));
                echo '<a href="javascript:void(0);" class="table-icon edit" title="Add locations"  onclick="javascript:addMentor(\''.$app['id'].'\');"></a>';
                echo '<a href="javascript:void(0);" class="table-icon delete" title="Remove locations"  onclick="javascript:removeLocations(\''.$app['id'].'\');"></a></td>';      
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