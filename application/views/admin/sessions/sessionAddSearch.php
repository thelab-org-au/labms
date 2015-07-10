<?php //var_dump($data); ?>

<div  id="results">
    <h3>Search results</h3>
    <div  style="max-height: 500px; overflow-y: scroll;">
        
        <table style="text-align: center;">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
            
            <?php foreach($data as $p) : ?>
                <tr>
                    <td><input type="checkbox" name="<?php echo $p['id']; ?>" /></td>
                    <td><?php echo $p['name']; ?></td>
                    <td><?php echo $p['dob'];?></td>
                    <td><?php echo $p['contact_email'];?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>