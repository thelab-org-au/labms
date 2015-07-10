<div class="full_w" >

    <div class="h_title">Session assign students</div>

    <form>
        <button id="bPrevious">Previous</button>
        <button id="bWaitlist">Waitlist</button>
        <button id="bOther">Other</button>
        <button id="bSearch">Search</button>
    </form>
    <form action="assignSession/addStudents" method="post" >
        <input type="hidden" name="termSession" value=" <?php echo $termSessionId; ?>" />       
        
        
        <div id="previous" style="display: none;">
            <h3>Previous students</h3>
            <div  style="max-height: 500px; overflow-y: scroll;">
                
                
                <table style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach($previous as $p) : ?>
                        <tr>
                            <td><input type="checkbox" name="<?php echo $p['id']; ?>" /></td>
                            <td><?php echo $p['name']; ?></td>
                            <td><?php echo $p['dob'];?></td>
                            <td><?php echo $p['contact_email'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="waitlist" style="display: none;">
            <h3>Waitlist students</h3>
            <div  style=" max-height: 500px; overflow-y: scroll;">
                
                <table style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach($waitlist as $p) : ?>
                        <tr>
                            <td><input type="checkbox" name="<?php echo $p['id']; ?>" /></td>
                            <td><?php echo $p['name']; ?></td>
                            <td><?php echo $p['dob'];?></td>
                            <td><?php echo $p['contact_email'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="display: none;" id="other">
            <h3>Other students</h3>
            <div  style="max-height: 500px; overflow-y: scroll;">
                
                <table style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach($other as $p) : ?>
                        <tr>
                            <td><input type="checkbox" name="<?php echo $p['id']; ?>" /></td>
                            <td><?php echo $p['name']; ?></td>
                            <td><?php echo $p['dob'];?></td>
                            <td><?php echo $p['contact_email'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="search" style="display: none;">
            <h3>Search</h3>
     
            Enter name &nbsp;<input id="searchField" type="text" name="searchField" /> &nbsp;
            <button id="searchButton" onclick="return false;">Search</button>
            <div id="searchResults" style="display: none;"></div>
        </div>
        <br />
        
        <button>Add students</button>
    </form>


<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script>

    $('#bPrevious').click(function(e)
    {
        e.preventDefault();
        $('#previous').show();
        $('#waitlist').hide();
        $('#other').hide();
        $('#search').hide();
    });
    
    $('#bWaitlist').click(function(e)
    {
        e.preventDefault();
        $('#previous').hide();
        $('#waitlist').show();
        $('#other').hide();
        $('#search').hide();
    });
    
    $('#bOther').click(function(e)
    {
        e.preventDefault();
        $('#previous').hide();
        $('#waitlist').hide();
        $('#other').show();
        $('#search').hide();
    });
    
    $('#bSearch').click(function(e)
    {
        e.preventDefault();
        $('#previous').hide();
        $('#waitlist').hide();
        $('#other').hide();
         $('#search').show();
    });
    
    $('#searchButton').click(function(e)
    {
        e.preventDefault();
        var name = $('#searchField').val();
        var ajax = new Ajax();
        ajax.doReq('assignSession/search?name=' + name,callback,null);   
    });
    
    function callback(text,object)
    {
        $('#searchResults').html(text);
        $('#searchResults').show();
    }
    
    function stopRKey(evt) 
    { 
      var evt = (evt) ? evt : ((event) ? event : null); 
      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
    } 
    
    document.onkeypress = stopRKey; 

</script>


   
</div>

