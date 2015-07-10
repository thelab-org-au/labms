<!DOCTYPE html>
<html lang="en">
    <!--<title><?php echo $title;  ?></title>-->
<?php $this->load->view('template/head'); ?>

<body>

<div class="wrap">

	<?php $this->load->view('template/header/header'); ?>
    
    <?php $this->load->view('template/content/content'); ?>

    <?php //$this->load->view('template/footer'); ?>
 
 
 <div id="dialog-message-ajax-error" title="Error">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0; color: red;"></span>
  <span id="dialogMessageAjaxError" style="color: red;">An error has occurred please refresh the page</span></p>
</div>
 
 
</div>

<script type="text/javascript">

    
    $( "#dialog-message-ajax-error" ).dialog({
      resizable: false,
      autoOpen: false,
      height:100,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        "Close": function() {
          $( this ).dialog( "close" );
          $('#dialogMessageAjaxError').html('An error has occured please refresh the page');
        }
      }
    });

    var profileids = new Array('userInfoDisplay','childInfoDisplay','mentorInfoDisplay','paymentInfoDisplay','waitListInfoDisplay','mailoutInfoDisplay');

    function showInfo(show)
    {
        var url = document.URL;
        url = url.split('/');
        
        
        if(url[5] != 'user' && url[6] != 'profile')
        {
            alert("http://" + url[2] + '/' + url[3] + '/' + url[4] + '/user/profile');
            window.location = "http://" + url[2] + '/' + url[3] + '/' + url[4] + '/user/profile';
            return;
        }
            //alert(url[5] + ' ' + url[6]);
        
        for (var cnt = 0; cnt < profileids.length; cnt++)
        {
            if(profileids[cnt] != show)
                $('#' + profileids[cnt]).hide();
        }
        $('#' + show).show('fast');
        return false;
    }


</script>
</body>
</html>
