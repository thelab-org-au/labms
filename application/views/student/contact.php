<!DOCTYPE html>
<html lang="en">
    <title>Contact details</title>
<?php $this->load->view('template/head'); ?>

<body style="background: none;">

<div class="wrap">
    <div id="content">
        <div id="main" style="width: 100%;">
            <div class="full_w" style="width: 100%;" >
    	       <div class="h_title">Mailing List</div>
               
                <h2>Details</h2>
                <div style="padding: 15px;">
                
                    <p><h4>Student name</h4></p> 
                    <p><?php echo $contacts['name']; ?> </p>

                    <h3>Contacts</h3>
                    <p><h4>Name</h4></p> 
                    <p><?php if(count($contacts['primary']) > 0) echo $contacts['primary'][0]['firstName'] . ' ' . $contacts['primary'][0]['lastName'] ?> </p>
                    
                    <p><h4>Phone</h4></p> 
                    <p>
                    <?php 
                        if(count($contacts['primary']) > 0) 
                            echo $contacts['primary'][0]['phone']; 
                        else
                        {
                            if(isset($contacts['contact_phone']))
                                echo $contacts['contact_phone'];
                        }
                        
                        if(isset($contacts['contact_email']))
                        {
                            echo '<p><h4>Email</h4></p>';
                            echo '<p>'.$contacts['contact_email'] .'</p>';
                        }
                    ?>
                    </p>
                    
                    <?php
                        foreach($contacts['contacts'] as $contact)
                        {
                            
                            echo '<p><h4>Name</h4></p>';
                            echo '<p>'.$contact['name'] .'</p>';
                            echo '<p><h4>Phone</h4></p>';
                            echo '<p>'.$contact['phone'] .'</p>';
                        }
                    ?>   

                </div>
                
                <?php //var_dump($this->input->get()); ?>
                <?php //var_dump($contacts); ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>