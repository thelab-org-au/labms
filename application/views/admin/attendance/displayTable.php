

    <table style="text-align: center;">
        <thead>
            <tr>
                <th style="width: 15%;">Term start date</th>
                <th style="width: 15%;">Term end date</th>
                <th style="width: 30%;">Session time</th>
                <th style="width: 10%;">View</th>
            </tr>
        </thead>
        </table>
<div style="max-height: 400px; overflow-y: auto;">
    <table style="text-align: center;">

        
        <tbody>
            <?php foreach($termSession as $session): ?>
                <tr>
                    <td style="width: 15%;"><?php echo $session['startDate']; ?></td>
                    <td style="width: 15%;"><?php echo $session['endDate']; ?></td>
                    <td style="width: 30%;"><?php echo $session['day']. " - " .$session['startTime']. " - " .$session['endTime']; ?></td>
                    <td style="width: 10%;">
                        <button class="table-icon "  onclick="showRecords('<?php echo $session['sessionId']; ?>','<?php echo $session['termId']; ?>');">View</button>
                    <?php 
                        //echo anchor_popup(site_url().'/admin/aAttendance/process?location='.$location.'&term='.$session[''].'&session='.$session['sessionId'], ' ', array('class' => 'table-icon archive','title' => 'View attendance')); 
                    ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    
    </table>
</div>

<div id="viewRecords">
    

</div>

<script type="text/javascript">


    function showRecords(session,term)
    {
        var location = '<?php echo $location; ?>';
        ajax.doReq('<?php echo site_url(); ?>/admin/aAttendance/process?location=' + location +
                                                                        '&term='+term+
                                                                        '&session=' + session,showCallback,null);
    } 
    
    function showCallback(text,object) 
    {
        $('#viewRecords').html(text); 
    }  

</script>