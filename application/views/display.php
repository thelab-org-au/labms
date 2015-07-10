<?php if(isset($ok) ) echo '<div class="n_ok" ><p>'. $ok .'</p></div>'; 

        if($this->session->userdata('ok') != null) echo '<div id="ok" class="n_ok" ><p>'. $this->session->userdata('ok') .'</p></div>'; 
        
        $this->session->set_userdata('ok',null);
?>
<?php if(isset($error)) echo '<div class="n_error" ><p>'. $error .'</p></div>'; ?>