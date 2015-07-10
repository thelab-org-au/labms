<h3>Sessions</h3>
<form id="listLab">
    <select name="labList" class="err" id="labList" >
        <option value="-1">Select location</option>
        <?php foreach($locations as $loc): ?>
            <option value="<?php echo $loc['id'];?>"><?php echo $loc['name'];?></option>                                
        <?php endforeach;?>
    </select>
    
<div id="labSessionDsiplay">  
    <?php foreach($sessionList as $session): ?>
        <?php if(sizeof($session[0]) > 0): ?>
    <table <?php echo 'id="session'.$session['id'].'" style="display: none; text-align: center;"' ?> >
        <thead>
            <tr>
               <!-- <th>Location</th>-->
                <th>Session</th>
                <th>Term start</th>
                <th>Term end</th>
                <th>Edit</th>
            </tr>
        </thead>
        
        <?php 
                echo '<tbody id="session'.$session['id'].'" >';
                foreach($session[0] as $sess)
                {
                    //var_dump($sess);
                    echo '<tr>';
                    //echo '<td>'.$sess['name'].'</td>';
                    echo '<td>'.$sess['desc'].'</td>';
                    echo '<td>'.($sess['startDate'] == null ? '-' :$sess['startDate']).'</td>';
                    echo '<td>'.($sess['endDate'] == null ? '-' :$sess['endDate']).'</td>';
                    echo '<td ><a href="javascript:void(0);" class="table-icon edit" title="Edit location"  onclick="javascript:sessionEdit();"></a></td>';
                    echo '</tr>';
                }
                
                
                echo '</tbody>';
        
        ?>
        
    </table>
    
        <?php endif;?>
    <?php 
        if(sizeof($session[0]) == 0)
        {
            echo '<div id="session'.$session['id'].'" style="display: none; padding-top: 10px;">';
            echo 'No sessions found';     
            echo '</div>';
        } 
        
    ?>
    <?php endforeach; ?>
</div>  
</form>

<?php //print_r($sessionList['Footscray']); ?>

<script type="text/javascript">
    function sessionEdit()
    {
        alert('TO be done yet');
    }
    
    $('#labList').change(function(){
        
        $('#listLab table').each(function(){
            $(this).hide();
        })
        
        $('#listLab div').each(function(){
            $(this).hide();
        })
        $('#session' + $(this).val()).show();
        $('#labSessionDsiplay').show();
        $('#termAddDisplay').hide();
        $('#lab').val('-1');
    })
    
    

</script>