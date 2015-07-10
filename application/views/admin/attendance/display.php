<div style="overflow: auto;">

<table style="text-align: center; " >
	<thead>
		<tr>
			<th style="min-width: 120px">Name</th>
            <?php
                
                $count = 0;
                $record = null;
                foreach($data as $d)
                {
                    if(count($d['attendance']) > $count)
                    {    
                        $count = count($d['attendance']);
                        $record = $d['attendance'];
                    }
                }
                      
                foreach($record as $r) 
                    echo '<th style="min-width: 80px">'.$r['date'].'</th>';       
                //for($cnt = 0; $cnt < $count; $cnt++)
                    //echo '<th style="min-width: 80px">Date</th>';
            ?>
		</tr>
	</thead>

    <tbody id="attendanceBody">
    
        <?php
            foreach($data as $student)
            {
                echo '<tr>';
                echo '<td style="min-width: 120px">'.$student['info']['name'].'</td>';
                
                $cnt = 0;
                foreach($student['attendance'] as $att)
                {
                    if($att['present'] === '1')
                    {
                        echo '<td bgcolor="#00FF00">Yes</td>';
                    }
                    else
                    {
                         echo '<td bgcolor="#FF0000"> No </td>';
                    }
                    $cnt++;
                }
                
                while($cnt < $count)
                {
                    echo '<td bgcolor="#FF0000"> No </td>';
                    $cnt++;
                }
                
                echo '</tr>';
            }
        ?>
    
    
    </tbody>
</table>

</div>