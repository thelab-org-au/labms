<div class="full_w" style="min-height: 500px;">
	<div class="h_title"><?php echo $title;?></div>
    <h3>Available training content</h3>
    
    <div class="element">
        <table style="width: 50%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 20%;">View</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php
                    foreach($info as $i)
                    {
                        echo '<tr>';
                        echo '<td>'.$i['desc'].'</td>';
                        echo '<td>'.anchor_popup(site_url().'/training/view?id='.$i['id'], ' ', array("class" => "table-icon archive" , 'title' => 'View content')).'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>

    
</div>