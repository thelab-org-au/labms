<div class="full_w" >
	<div class="h_title"><?php echo $title;?></div>
    <?php $this->load->view('display'); ?>

    <?php echo validation_errors(); ?>

    <form id="addButtonForm" >
        <button id="addNewUser" class="add" onclick="return false;">Add new user</button>
    </form>
    <div  id="addUser" style="display: none;">
    <h3>Add new user</h3>

        <?php echo form_open('admin/ausers/add/',array('id' => 'usersForm')); ?>

        <p id="addError" style="display: none; color: red;"></p>

        <?php $this->load->view('admin/userAdd'); ?>
    </form>
    </div>

    <div id="editUser" style="display: none;">
        <h3>Edit user</h3>
        <div id="editData" >
        </div>
    </div>
    <br />
    <br />

    <div id="userTableDisplay">
    <?php $this->load->view('admin/usersTable'); ?>
    </div>
</div>

<script type="text/javascript">
    $('#addNewUser').click(function(){
        $('#addButtonForm').hide();
        $('#addUser').show('fast');
        $('#userTableDisplay').hide();

    })

    $('#addUserClose').click(function(){
        $('#addUser').hide('fast');
        $('#addButtonForm').show();
        $('#userTableDisplay').show();
        return false;
    })

</script>
