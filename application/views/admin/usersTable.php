    <h3>Current users</h3>
    <div class="element">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>User type</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php
                    $u = $this->session->userdata('user');
                    $ids = array();
                    
                    foreach($users as $user)
                    {
                        if(!in_array($user['id'],$ids))
                        {
                            $ids[] = $user['id'];
                            echo '<tr>';
                            echo '<td>'.$user['firstName']. ' '.$user['lastName'].'</td>';
                            echo '<td>'.$user['address'].' '.$user['suburb'].' '.$user['postcode'].'</td>';
                            echo '<td>'.$user['phone'].'</td>';
                            echo '<td>'.$user['email'].'</td>';
                            echo '<td>'.$user['type'].'</td>';
                            
                            if((int)$u['type'] >= (int)$user['typeId'])
                            {
                                echo '<td style="text-align: center;"><a href="javascript:void(0);" class="table-icon edit" title="Edit user"  onclick="javascript:editUser(\''.$user['id'].'\');"></a>';
                            //echo '<td style="text-align: center;">'.anchor(site_url().'/admin/alocations/edit?id='.$location['id'], ' ', array('class' => 'table-icon edit','title' => 'Edit location'));
                                echo '<a href="javascript:void(0);" class="table-icon delete" title="Remove user"  onclick="javascript:removeUser(\''.$user['id'].'\',\''.$user['firstName']. ' '.$user['lastName'].'\');"></a></td>';
                            //echo anchor(site_url().'/admin/ausers/delete?id='.$user['id'].'&name='.$user['firstName']. ' '.$user['lastName'], ' ', array('class' => 'table-icon delete','title' => 'Remove user')).'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
    
    <script type="text/javascript">
        var ajax = new Ajax();
        function editUser(id)
        {
           //alert(id);
           $('#userTableDisplay').hide('fast');
           
          // ajax.doReq('<?php echo site_url(); ?>/admin/ausers/getData?id=' + id,callback,null);
        $.ajax({
            url: '<?php echo site_url(); ?>/admin/ausers/getData?id=' + id, 
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
                    $('#editUser').show('fast');
                    $('#editData').html(returnedData);                  
                }

				
				$("#main").unmask();                  
            }
        });
        }
        
        function removeUser(id,name)
        {
            if(confirm('Are you sure you want to remove ' + name.toUpperCase()))
                window.location.href ='<?php echo site_url().'/admin/ausers/delete?id=';?>' + id;
        }
        
        function callback(text,object)
        {
            //alert(text);
            $('#editUser').show('fast');
            $('#editData').html(text);
            
            
        }
    
    </script>