<!DOCTYPE html>
<html lang="en">
    <title>Student details</title>
<?php $this->load->view('template/head'); ?>

<body style="background: none;">

<div class="wrap">
    <div id="content">
        <div id="main" style="width: 100%;">
            <div class="full_w" style="width: 100%;" >
    	       <div class="h_title">Student details</div>
               
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
                              
                </div>
                
                
                <?php //var_dump($this->input->get()); ?>
                <?php //var_dump($studentDetails); ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>