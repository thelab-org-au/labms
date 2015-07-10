    <h3>Current locations</h3>
    <div class="element">
        <table>
            <thead>
                <tr>
                    <th style="min-width: 20%;">Name</th>
                    <th>Address</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($locations as $location)
                    {
                        echo '<tr>';
                        echo '<td>'.$location['name'].'</td>';
                        echo '<td>'.$location['address'].'</td>';
                        echo '<td style="text-align: center;"><a href="javascript:void(0);" class="table-icon edit" title="Edit location"  onclick="javascript:editLocation(\''.$location['id'].'\');"></a>';
                        //echo '<td style="text-align: center;">'.anchor(site_url().'/admin/alocations/edit?id='.$location['id'], ' ', array('class' => 'table-icon edit','title' => 'Edit location'));
                        echo anchor(site_url().'/admin/alocations/delete?id='.$location['id'].'&name='.$location['name'], ' ', array('class' => 'table-icon delete','title' => 'Remove location')).'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
    
    <script type="text/javascript">
        var ajax = new Ajax();
        function editLocation(id)
        {
           //alert(id);
          // ajax.doReq('<?php echo site_url(); ?>/admin/alocations/getData?id=' + id,callback,null);
        $.ajax({
            url: '<?php echo site_url(); ?>/admin/alocations/getData?id=' + id, 
            type: 'get',
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                   $("#main").unmask();
				   $("#dialogMessageAjaxError").html(errorThrown);
                   $( "#dialog-message-ajax-error"  ).dialog( "open" );
            },
            success: function(returnedData,status)
            {
                if(status == 'success')
                {
                    $('#editData').html(returnedData);
                    $('#addLocation').hide("slow");
                    $('#editLocation').show("slow");                  
                }

				
				$("#main").unmask();                  
            }
        });
           $('#editLocation').hide("slow"); 
        }
        
        function callback(text,object)
        {
            //alert(text);
            $('#editData').html(text);
            $('#addLocation').hide("slow");
            $('#editLocation').show("slow");
            
        }
    
    </script>