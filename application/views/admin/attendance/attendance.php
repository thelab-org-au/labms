<div class="full_w" style="min-height: 500px;">
	<div class="h_title">Attendance</div>
  <div id="attendanceRecords">
    <?php $this->load->view('display'); ?>
    <?php echo form_open('',array('id' => 'parentForm')); ?>
      <div class="element">
        <label for="lab">Location</label>
    		<select name="lab" class="err" id="lab" onchange="javascript:updateFields()">
      		<option value="-1">-Select Lab-</option>
          <?php foreach($labData as $lab) {
              echo '<option value="'.$lab['id'].'">'.$labNames[$lab['id']]['name'].'</option>';
					} ?>
      	</select>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">
  $('#lab').ready(function(){
    var ajax = new Ajax();

		$('#search').on('click', function(e) {
			e.preventDefault();
      updateFields();
      return false;
    });

    function updateFields() {
	    ajax.doReq('<?php echo site_url(); ?>/admin/aAttendance/getLocationData?location=' + $('#lab').val(),callback,null);
    }

		function callback(text,object) {
      $('#attRecords').html(text);
    }

  });
</script>
