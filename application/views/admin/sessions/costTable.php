
    <table style="text-align: center;">
        <thead>
            <tr>
                <th style="width: 20%;">Term </th>
                <th style="width: 30%;">Session time</th>
                <th style="width: 20%;">Full</th>
                <th style="width: 20%;">Concession</th>
                <th style="width: 10%;">Add/Update</th>
            </tr>
        </thead>



        <tbody>

            <?php foreach($termSession as $session): ?>
                <tr>

                    <td style="width: 20%;"><?php echo $session['startDate']. ' - ' . $session['endDate']; ?></td>

                    <td style="width: 30%;"><?php echo $session['day']. " - " .$session['startTime']. " - " .$session['endTime']; ?></td>

                    <?php if(datediff($session['endDate'])) : ?>

                    <td style="width: 20%;">$ <input style="width: 80%;" value="<?php echo $session['full']; ?>" type="text" name="full" id="full<?php echo $session['termSessionId'] ?>" required="required" /></td>

                    <td style="width: 20%;">$ <input style="width: 80%;" value="<?php echo $session['con']; ?>"type="text" name="con" id="con<?php echo $session['termSessionId'] ?>" required="required" /> </td>

                    <td style="width: 10%;">
                        <button class="table-icon "  onclick="submitCost('<?php echo $session['termSessionId']; ?>'); return false;">Add/Update</button>
                    </td>

                    <?php else : ?>

                    <td style="width: 20%;">$ <?php echo $session['full']; ?></td>

                    <td style="width: 20%;">$ <?php echo $session['con']; ?></td>
                    <td>Session completed</td>
                    <?php endif;?>

                </tr>
            <?php endforeach;?>
        </tbody>

    </table>

    <?php echo form_open('admin/cost/setCost/',array('id' => 'addcostform')); ?>
        <input type="hidden" name="termSession" id="termSession" />
        <input type="hidden" name="con" id="costCon" />
        <input type="hidden" name="full" id="costFull" />
    </form>

<?php
    function datediff( $date2)
    {
        $first = date_create_from_format('d/m/Y', date('d/m/Y'));
        $second = date_create_from_format('d/m/Y', $date2);
        return ($first < $second);
    }

?>

<script type="text/javascript">

    function submitCost(termSession)
    {
        var con = $('#con' + termSession).val();
        var full = $('#full' + termSession).val();
        $('#termSession').val(termSession);
        $('#costCon').val(con);
        $('#costFull').val(full);

        $('#addcostform').submit();
        return false;


    }


</script>
