<div class="full_w" >

	<div class="h_title">Session cost</div>
    


    <?php $this->load->view('display'); ?>

    <?php echo validation_errors(); ?>



    <? echo form_open('admin/cost/addCost',array('id' => 'createsessionform')); ?> 
    <label for="location">Location</label>
    <select name="location" class="err" id="location">
    
        <option value="-1">Select location</option>
    
        <?php foreach($locations as $location): ?>
    
            <option value="<?php echo $location['id'];?>"><?php echo $location['name'];?></option>
    
        <?php endforeach;?>
    
    </select>
    
    <div id="sessionInfo"></div>
    <!--
        <table style="width: 75%;">

            <thead>

                <tr>

                    <th>Location</th>

                    <th>Term</th>

                    <th>Session</th>



                </tr>

            </thead>

            <tbody style="text-align: center;">

                <tr>

                    <td>

                        <select name="location" class="err" id="location">

                            <option value="-1">Select location</option>

                            <?php foreach($locations as $location): ?>

                                <option value="<?php echo $location['id'];?>"><?php echo $location['name'];?></option>

                            <?php endforeach;?>

                        </select>

                    </td>

                    <td>

                        <select name="term" class="err" id="term">

                            <option value="-1">Select term</option>

                            <?php foreach($terms as $term): ?>

                                <option value="<?php echo $term['id'];?>"><?php echo $term['desc'];?></option>                              

                            <?php endforeach;?>

                        </select>

                    </td>

                    <td>

                        <select name="session" class="err" id="session">

                            <option value="-1">Select session</option>

                            <?php foreach($sessions as $session): ?>

                                <option value="<?php echo $session['id'];?>"><?php echo $session['desc'];?></option>                              

                            <?php endforeach;?>

                        </select>

                    </td>



                </tr>

            </tbody>

        

        </table>



        <table style="width: 75%;">

            <thead>

                <tr>

                    <th>Full</th>

                    <th>Concession</th>

                    <th style="width: 50px;">Add</th>

                </tr>

            </thead>



            <tbody style="text-align: center;">

                <tr>

                    <td>$ <input type="text" name="full" id="full" required="required" /></td>

                    <td>$ <input type="text" name="con" id="con" required="required" /> </td>

                    <td><button id="costSubmit" class="add">Add</button></td>

                </tr>



            </tbody>



        </table>

    
-->
    </form>

 </div>



<div id="dialog-message-sessions" title="Message" >

    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="dialogMessage-sessions"></span></p>

</div>


<script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
<script type="text/javascript">



    $( "#dialog-message-sessions" ).dialog({

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

    
    $('#location').change(function()
    {
        ajax = new Ajax();
        ajax.doReq('<?php echo site_url(); ?>/admin/cost/getLocationData?location=' + $('#location').val(),setCallback,$('#sessionInfo'));   
    });


    function setCallback(text,object)
    {
        object.html(text);
    }


    $('#costSubmit').click(function()

    {

        if($('#session').val() == '-1' || $('#term').val() == '-1' || $('#location').val() == '-1')

        {

            if(!valMessage($('#location'),'-1','Please select a location'))

            return false;



            if(!valMessage($('#term'),'-1','Please select a term'))

                return false;



            if(!valMessage($('#session'),'-1','Please select a session'))

                return false;

        }



        if(!valMessage($('#session'),'-1','Please select a session'))

            return false;



        if(!valMessage($('#full'),'','Please enter a full price'))

            return false;



        if(!valMessage($('#con'),'','Please enter a concession price'))

            return false;



        if(!valNumber($('#full'),'Full price must be a number'))

            return false;



        if(!valNumber($('#con'),'Concession price must be a number'))

            return false;



        return true;

    });



    function valMessage(object,val,message)

    {

        if(object.val() == val)

        {

            $('#dialogMessage-sessions').html(message);

            $( "#dialog-message-sessions" ).dialog( "open" );

            return false;

        }



        return true;

    };



    function valNumber(object,message)

    {

        if(isNaN(object.val() / 1))

        {

            $('#dialogMessage-sessions').html(message);

            $( "#dialog-message-sessions" ).dialog( "open" );

            return false;

        }



        return true;

    };





</script>