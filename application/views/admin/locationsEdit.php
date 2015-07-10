<?php echo form_open('admin/alocations/edit/',array('id' => 'parentForm')); ?>
    <input type="hidden" name="id" value="<?php echo $info[0]['id'];?>" />
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Add</th>
            </tr>
        </thead>
        <tbody>
            <td style="width: 30%; padding-left: 1%; padding-right: 1%;"><input style="width: 100%;" name="name" value="<?php echo $info[0]['name'];?>" /></td>
            <td style="width: 50%; padding-left: 1%; padding-right: 1%;"><input style="width: 100%;" name="address" value="<?php echo $info[0]['address'];?>"/></td>
            <td style="text-align: center; width: 20%;"><button class="add" id="updateLocation"  >Apply</button> <button id="cancelEdit" onclick="return false;"> Cancel</button></td>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    $('#cancelEdit').click(function(){

        $('#addLocation').show("slow");
        $('#editLocation').hide("slow");

    })

</script>
