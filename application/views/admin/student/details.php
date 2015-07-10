<!DOCTYPE html>
<html lang="en">
    <title>Student admin details</title>
<?php $this->load->view('template/head'); ?>

<body style="background: none;">

<div class="wrap">
    <div id="content">
        <div id="main" style="width: 100%;">
            <div class="full_w" style="width: 100%;" >
    	       <div class="h_title">Student admin details</div>
               
                <h2>Details</h2>
                <div style="padding: 15px;">
                
                    <p><h4>Name</h4></p> 
                    <p><?php echo $studentDetails['name']; ?> </p>
                    
                    <p><h4>Date of birth</h4></p>
                    <p><?php echo $studentDetails['dob']; ?> </p>
                    
                    <h3>School information</h3>
                    
                    <p><h4>Days at school</h4></p>
                    <p><?php echo $studentDetails['daysAtSchool']; ?> </p>
                    
                    <?php
                        echo '<p><h4>School types</h4></p>';
                        foreach($studentDetails['schools'] as $school)
                            echo '<p>'.$school['desc'].'</p>';
                        
                        if($studentDetails['schoolOther'] != null)
                            echo '<p>'.$studentDetails['schoolOther'].'</p>';
                    ?>
                    
                    
                    <h3>Conditions</h3>
                    
                    <?php
                        foreach($studentDetails['conditions'] as $condition)
                            echo '<p>'.$condition['desc'].'</p>'; 
                    ?>
                    
                    <h3>Interests</h3>
                    
                    <?php
                        echo '<p><h4>Technologies</h4></p>';
                        foreach($studentDetails['interests'] as $intrest)
                            echo '<p>'.$intrest['desc'].'</p>';
                    ?> 
                    
                    <h3>Experience</h3>
                    
                    <?php
                        echo '<p><h4>Technologies</h4></p>';
                        foreach($studentDetails['experience'] as $experience)
                            echo '<p>'.$experience['desc'].'</p>';
                    ?> 
                    
                    <h3>Session interest</h3>
                    
                        <?php 
                            $val = intval($studentDetails['sessionType']);
                            
                            $vals = array(1 => 'Social activities', 2 => "Learning programming and design skills" , 3 => 'Both');
                            
                            if($val === 0)
                                echo '<p>'.$studentDetails['sessionType'].'</p>';
                            else
                                echo '<p>'.$vals[$val].'</p>';
                                
                            
                        
                        ?>
                        
                    <h3>Laptop less than 3 years old</h3>
                        <?php echo '<p>'.($studentDetails['lapTop'] == '1' ? 'Yes' : 'No').'</p>'; ?>
                        
                    <h3>Additional information</h3>
                        <?php echo '<p>'.$studentDetails['otherInfo'].'</p>'; ?> 
                        
                        
                    <h3>Contacts</h3>
                    <p><h4>Name/Email</h4></p> 
                    <p><?php
						if(isset($contacts['primary'][0]['firstName'])) 
							echo $contacts['primary'][0]['firstName'] . ' ' . $contacts['primary'][0]['lastName']; 
						else if (isset($studentDetails['contact_email']))
							echo $studentDetails['contact_email'];
						
						?> </p>
                    
                    <p><h4>Phone</h4></p> 
                    <p><?php 
						if(isset($contacts['primary'][0]['phone'])) 
							echo $contacts['primary'][0]['phone'];
						else if(isset($studentDetails['contact_phone']))
							echo $studentDetails['contact_phone'];
						?> </p>
                    
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
                <?php //var_dump($studentDetails); ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>