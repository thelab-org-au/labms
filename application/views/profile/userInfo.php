<div id="userInfoDisplay" >
  <h2>My information</h2>
  <?php echo form_open(
    'user/profile',
    array('id' => 'updateUserForm'),
    array('id' => $user_id)
  ) ?>

    <?php foreach($field_groups as $group): ?><div class="element">
      <?php foreach($group as $field):

        echo form_label($field['label'], $field['name']);
        switch($field['type']):
          case 'text':
            echo form_input($field['name'], set_value($field['name'], $field['default']), 'class="text err"');
            break;
          case 'password':
            echo form_password($field['name'], '', 'class="text err"');
            break;
        endswitch;
        echo form_error($field['name']);

        ?><br /><br />

      <?php endforeach ?>
    </div><?php endforeach ?>

    <div class="element">
      <button>Update</button>
    </div>

  </form>

</div>
<script type="text/javascript">
    function userInfoClose()
    {
        $('#userInfoDisplay').hide('fast');
        return false;
    }
</script>
