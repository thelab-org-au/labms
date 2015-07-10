<div class="full_w" style="min-height: 500px;">
	<div class="h_title">Students</div>
    
    
    <div id="studentSearch" class="element">
    
        <form>
        	<label for="lab">Lab location</label>
			<select name="lab" class="err" id="lab">
				<option value="-2">All labs</option>
                
                <?php 
                    foreach($locations as $lab)
                       echo '<option value="'.$lab['id'].'">'.$lab['name'].'</option>'; 
                ?>
                
			</select>
            
            <br />
            <br />
            <label for="name">Search by name</label>
            <p>Leave blank for all students</p>
            <input id="name" name="name" class="text err" />
                &nbsp;&nbsp;&nbsp;
                <button type="submit" id="find" onclick=" return false;">Search</button>
            
            <span class="element"></span>
        </form>
    
    </div>
    
    <div id="studentAdd"></div>
    
    
    <div id="studentDisplay">
    
        <?php $this->load->view('admin/student/view');?>
    
    </div>
    
    
</div>