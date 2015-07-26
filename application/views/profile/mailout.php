<div id="mailoutInfoDisplay" style="padding-right: 10px;" >
    <h2>Mailing lists</h2>

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
                        <td><?php echo anchor('profile/mailRemove?id=' . $location['id'], 'Unsubscribe', 'title="Unsubscribe"') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else : ?>
        <h3>No mailout information found</h3>
    <?php endif; ?>

    <p>
        <?php echo anchor('signup/mailinglist', 'Mailing list signup') ?>
    </p>

</div>
<script type="text/javascript">
    function mailoutInfoClose()
    {
        $('#mailoutInfoDisplay').hide('fast');
        return false;
    }
</script>
