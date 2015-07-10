<form  >

    <span id="enterFields" style="display: none; color: red; font-size: 14px;">&nbsp; &nbsp;Please enter all fields</span>
    <input type="hidden" name="addToSession" id="addToSession" />
    <div class="element">

        <label for="fristName">Name</label>

        <input type="text"  id="addName" name="name" />

    </div>

    <div class="element">

        <label for="contactEmail">Contact email</label>

        <input type="text"  id="contactEmail" name="contactEmail"/>

    </div>

    <div class="element">

        <label for="phone">Contact phone</label>

        <input type="text"  id="phone" name="phone"/>

    </div>

    <div class="element">

        <button type="submit" value="Add student" id="addNewStudent" >Add student</button>

        <button type="submit" id="cancelAdd" onclick=" return false;">Cancel</button>

    </div>

    

</form>

<div id="dialog-message-add" title="Error">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
  <span id="dialogMessageAdd" style="color: red;">Please enter all fields</span></p>
</div>

<div id="dialog-message-add-error" title="Error">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0; color: red;"></span>
  <span id="dialogMessageAddError" style="color: red;">An error has occurred please refresh the page</span></p>
</div>

<script type="text/javascript">


    $( "#dialog-message-add" ).dialog({
      resizable: false,
      autoOpen: false,
      height:100,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        "Close": function() {
          $( this ).dialog( "close" );
          
        }
      }
    });
    
    $( "#dialog-message-add-error" ).dialog({
      resizable: false,
      autoOpen: false,
      height:100,
      modal: true,
      dialogClass: "no-close",
      buttons: {
        "Close": function() {
          $( this ).dialog( "close" );
          $('#dialogMessageAddError').html('An error has occured please refresh the page');
        }
      }
    });

    $('#addNewStudent').click(function(e)
    {
        e.preventDefault();
        //return true;
        //ajax.doReq('<?php echo site_url(); ?>/attendance/GetStudentData?session=' + session.val() +'&start=1',callback,null);  
        
        if($.trim($('#addName').val()) == '' || $.trim($('#contactEmail').val()) == '' || $.trim($('#phone').val()) == '')
        {
            $( "#dialog-message-add"  ).dialog( "open" );
            return false;
        }
        
        
        $("#main").mask("Processing...");

        $.ajax({
            url: 'students/add_student', 
            data: { name: $('#addName').val(), contactEmail : $('#contactEmail').val(), phone : $('#phone').val(),addToSession : $('#addToSession').val()},
            type: 'post',
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                   $("#main").unmask();
				   $("#dialogMessageAddError").html(errorThrown);
                   $( "#dialog-message-add-error"  ).dialog( "open" );
            },
            success: function(returnedData,status)
            {
                if(status == 'success')
                {
                    
                    if (typeof(getStudentData) != "undefined" && returnedData == 'true') 
                    { 
    					$('#newStudentForm').hide();
                        getStudentData();
                        
                        $('#phone').val('');
                        $('#contactEmail').val('');
                        $('#addName').val('');
                    }
                    else
                    {
                        $("#main").unmask();
                        $('#dialogMessageAddError').html(returnedData);
                        $( "#dialog-message-add-error"  ).dialog( "open" ); 
                    }                    
                }
                else
                {
                   $("#main").unmask();
				   $("#dialogMessageAddError").html(returnedData);
                   $( "#dialog-message-add-error"  ).dialog( "open" );
                }
				
				$("#main").unmask();                  
            }
        });

        
        
        return false;
    });

</script>