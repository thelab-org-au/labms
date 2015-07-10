<div id="mailoutInfoDisplay" style="padding-right: 10px;" > 
    <h2>Mailing lists</h2>
    <?php //var_dump($studentData); ?>
    
    <?php if(count($studentData) > 0) : ?>
    <table style="text-align: center; ">
        <thead>
            <tr>
                <th>Location</th>
                <th>Unsubscribe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($studentData as $location): ?>
                <tr>
                    <td><?php echo $location['name']; ?></td>
                    <td><a href="../profile/mailRemove?id=<?php echo $location['id'];?>" title="Unsubscribe">Unsubscribe</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php else : ?>
    
        <h3>No mailout information found</h3>
    <?php endif; ?>
    
</div>
<script type="text/javascript">
    function mailoutInfoClose()
    {
        $('#mailoutInfoDisplay').hide('fast');
        return false;
    }
</script>