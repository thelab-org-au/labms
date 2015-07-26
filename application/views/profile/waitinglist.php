<div id="waitListInfoDisplay" style="padding-right: 10px;" >
    <h2>Waiting lists</h2>

    <?php if(count($studentData) > 0) : ?>
        <table style="text-align: center; ">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of birth</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($studentData as $student) : ?>
                    <tr>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['dob']; ?></td>
                        <td><?php echo $student['location']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h3>No waitlist information found</h3>
    <?php endif; ?>

    <p>
        <?php echo anchor('signup/waitlist', 'Waiting list signup') ?>
    </p>

</div>
<script type="text/javascript">
    function waitlistInfoClose()
    {
        $('#waitListInfoDisplay').hide('fast');
        return false;
    }
</script>
