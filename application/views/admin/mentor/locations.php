<?php //var_dump($info[0]); ?>
<? echo form_open('admin/amentors/removeMentor/',array('id' => 'removeMentor')); ?>  
    <table style="text-align: center; width: 160px;">
        <thead>
            <tr>
                <th>Remove</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($info[0]['locations'] as $l)
                {
                    echo '<tr>';
                    echo '<td style="width:50px;"><input type="checkbox" name="'.$l['location'].'" value="'.$l['location'].'" /></td>';
                    echo '<td>'.$locations[$l['location']].'</td>';
                    echo '</tr>';
                }
            
            ?>
        </tbody>
    
    </table>
    <input type="hidden" name="mentorId" value="<?php echo $info[0]['id']; ?> " />
    <button >Submit</button>
    <button onclick="return closeRemoveDiv();">Close</button>
</form>