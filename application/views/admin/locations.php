<div class="full_w" >
	<div class="h_title"><?php echo $title;?></div>
    <?php $this->load->view('display'); ?>


    <?php //var_dump($locations); ?>
    <div  id="addLocation">
    <h3>Add new location</h3>

        <?php echo form_open('admin/alocations/add/',array('id' => 'locationForm')); ?>

        <p id="addError" style="display: none; color: red;"></p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Add</th>
                </tr>
            </thead>
            <tbody>
                <td style="width: 30%; padding-left: 1%; padding-right: 1%;"><input id="addName" name="name" style="width: 100%;" required="true" /></td>
                <td style="width: 50%; padding-left: 1%; padding-right: 1%;"><input id="addAddress" name="address" style="width: 100%;" required="true"/></td>
                <td style="text-align: center; width: 20%;"><button class="add" id="addLocationButton" > Add location</button></td>
            </tbody>
        </table>
        </form>
    </div>

    <div id="editLocation" style="display: none;">
        <h3>Edit location</h3>
        <div id="editData" >
            <?php //$this->load->view('admin/locationsEdit'); ?>
        </div>
    </div>
    <br />
    <br />
    <?php $this->load->view('admin/locationsTable'); ?>

</div>

<script type="text/javascript">
    $('#addLocationButton').click(function(){

        if(valLocation())
        {
            $('#addError').hide();
            $('#locationForm').submit();
        }
        else
        {
            $('#addError').text('All fields required');
            $('#addError').show();
            return false;
        }
    })

    function valLocation()
    {
        if($('#addName').val() == '')
            return false;

        if($('#addAddress').val() == '')
            return false;
        return true;
    }

</script>
