
<!DOCTYPE html>
<html lang="en">
    <title>Applicant details</title>
<?php $this->load->view('template/head'); ?>

<body style="background: none; padding: 5%; width: 90%;">

<div class="wrap" style=" width: 100%;">
    <div id="content" style=" margin: 0px;">
        <div id="main" style="width: 100%;">
            <div class="full_w"  >
    	       <div class="h_title">Applicant</div>
               
                <h2>Details</h2>
                <div >
                    <?php 
                        $applicant = $applications[0];
                        echo '<p>'.$applicant['firstName'].' '.$applicant['lastName'].'</p>';
                        echo '<p>'.$applicant['email'].'</p>';
                        echo '<p>'.$applicant['phone'].'</p>';
                        echo '<p>'.$applicant['dob'].'</p>';
                        echo '<p>'.$applicant['address'].' '.$applicant['suburb'].' '.$applicant['postcode'].'</p>';
                    
                        
                        echo '<h2>Application</h2>';
                        echo '<h3>Educational History</h3>';
                        echo '<p>'.$applicant['education'].'</p>';
                        
                        echo '<h3>Criminal convictions</h3>';
                        echo '<p>'.($applicant['conviction'] == '2' ? 'No' : 'Yes').'</p>';
                        
                        if($applicant['conviction'] == '1')
                        {
                            echo '<p><i>Conviction details</i></p>';
                            echo '<p>'.$applicant['convictionDetails'].'</p>';
                        }
                        
                        echo '<h3>Working with Children Check</h3>';
                        echo '<p>'.($applicant['childrenCheck'] == '2' ? 'No' : 'Yes').'</p>';
                        
                        if($applicant['childrenCheck'] == '1')
                        {
                            echo '<h3>Working with Children experience</h3>';
                            echo '<p>'.$applicant['workingWithChild'].'</p>';
                        }
                        
                        echo '<h3>Technical skills and experience </h3>';
                        
                        echo '<table style="width:200px;"><thead><tr>';
                        echo '<th>Technology</th><th style="width:50px;">Level</th>';
                        echo '</tr></thead><tbody>';
                        
                        foreach($applicant['experience'] as $exp)
                        {
                            echo '<tr><td>'.$exp['desc'].'</td>';
                            
                            switch($exp['level'])
                            {
                                case '1':
                                    echo '<td style="width:50px;">Low</td>';
                                break;
                                case '2':
                                    echo '<td style="width:50px;">Medium</td>';
                                break;
                                case '3':
                                    echo '<td style="width:50px;">High</td>';
                                break;
                            }
                            echo '</tr>';
                        }
                        
                        echo '</tbody></table>';
                        
                        if($applicant['otherSkills'] != '')
                        {
                            echo '<h3>Other skills</h3>';
                            echo '<p>'.$applicant['otherSkills'].'</p>';                            
                        }
  
                        echo '<h3>References</h3>';
                        echo '<p>'.$applicant['references'].'</p>'; 
                        
                        echo '<h3>Work Experience </h3>';
                        echo '<p>'.$applicant['workExp'].'</p>';
                        
                        echo '<h3>Contact current employer</h3>';
                        echo '<p>'.($applicant['contactEmployer'] == '2' ? 'No' : 'Yes').'</p>'; 
                        
                        if($applicant['addInfo'] != '')
                        {
                            echo '<h3>Additional Information</h3>';
                            echo '<p>'.$applicant['addInfo'].'</p>';                            
                        }
                        
                        if($applicant['fileName'] != null)
                        {
                            echo '<h3>Resume</h3>';
                            echo '<p>'.anchor_popup(base_url().'uploads/'.$applicant['fileName'], 'Download resume ', array('title' => 'Download resume', 'width' => '800')).'</p>';                            
                        }                        
                     ?>
                              
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">

    function getCv()
    {
        var ajax = new Ajax();
    }

</script>

</body>
</html>