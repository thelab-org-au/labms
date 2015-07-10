<div class="full_w" >

	<div class="h_title"><?php echo $title; ?></div>

    <?php $this->load->view('display');?>

<div id="mailoutConfirmation" style="display: none;">
    <div class="n_ok" ><p>Your mail out has been sent</p></div>

    <form>
        <button onclick="javascript:newMailout();return false;">New mailout</button>
    </form>

</div>

<div id="createMailout">
    <form>
        <button onclick="return selectRecipients();">Recipients</button>
        <button onclick="return selectMailout();">Mailout</button>
    </form>

    <?php echo form_open('mailout/sendMailout', array('id' => 'parentForm'));?>

	<div id="labSelect">
            <div class="element">
                <h3>Locations</h3>
                    <p>
                        <label >
                        <input id="selectAll" type="checkbox" name="allLabs" value="1" onclick='allChanged(this);' />
                        Select all&nbsp;&nbsp;

                        <input type="checkbox" name="noneLabs" value="1" onclick='nonChanged(this);' />
                        De-select all&nbsp;&nbsp;
                        </label>
                    </p>
                    <p><i>All users at selected locations will receive mailout</i></p>
                    <p><i>For individual users de-select all locations and select users below</i></p>

                <?php
                        echo '<table style="text-align:center;"><thead><tr>';

                        for ($cnt = 0; $cnt < 3; $cnt++)
                        {
                            echo '<th style="width: 50px;">Select</th>';
                            echo '<th>Location</th>';
                        }

                        echo '</tr></thead><tbody>';

                        $count = 0;

                        for ($cnt = 0; $cnt < (sizeof($locations) / 3); $cnt++)
                        {
                            echo '<tr>';
                            for ($cnt2 = 0; $cnt2 < 3; $cnt2++)
                            {
                                if (isset($locations[$count]))
                                {
                                    $pre = (in_array($locations[$count]['id'], $userLocations));
                                    echo '<td><input type="checkbox" id="lab' . $count . '" name="lab' . $locations[$count]['id'] . '" value="' . $locations[$count]['id'] . '" ' . ($pre == 1 ? 'checked="true"' : '') .
                                        '" onclick="selectLocation()" /></td>';

                                    echo '<td>' . $locations[$count]['name'] . '</td>';
                                }
                                else
                                {
                                    echo '<td></td><td></td>';
                                }
                                $count++;
                            }
                            echo '</tr>';
                        }

                        echo '</tbody></table>';

                        ?>

             </div>
              <div class="element" id="userOptions">
                <h3>Recipients</h3>
                <p>
                    <label for="all">
                    <input type="checkbox" id="selectAll" name="all" value="1" onclick='selectAllUsers(this);'/>
                    All&nbsp;&nbsp;

                    <input type="checkbox" name="mentor" value="2" onclick='selectAllUsers(this);'/>
                    Mentors&nbsp;&nbsp;
                    <input type="checkbox" name="parents" value="3" onclick='selectAllUsers(this);'/>
                    Parents&nbsp;&nbsp;

                    <input type="checkbox" name="admins" value="4" onclick='selectAllUsers(this);'/>

                    Admins&nbsp;&nbsp;

                    <input type="checkbox" name="maillist" value="6" onclick='selectAllUsers(this);'/>

                    Maillist&nbsp;&nbsp;

                    </label>
                </p>
        </div>


<div id="userData">




    <?php

        echo '<table style="text-align:center;"><thead><tr>';

        for ($cnt = 0; $cnt < 3; $cnt++)
        {
            echo '<th style="width: 50px;">Select</th>';
            echo '<th>User name</th>';
        }

        echo '</tr></thead><tbody>';

        $count = 0;

        for ($cnt = 0; $cnt < (sizeof($users) / 3); $cnt++)
        {
            echo '<tr>';

            for ($cnt2 = 0; $cnt2 < 3; $cnt2++)
            {
                if (isset($users[$count]))
                {
                    //$pre = (in_array($users[$count]['id'],$userLocations));
                    echo '<span><td><input type="checkbox" id="user' . $count . '" name="user' . $users[$count]['id'] . '" value="' . $users[$count]['id'] . '" userType="' . $users[$count]['userType'] .
                        '" userLocations="' . $users[$count]['locations'] . '" /></td>';

                    echo '<td>' . $users[$count]['firstName'] . ' ' . $users[$count]['lastName'] . '</td></span>';
                }
                else
                {
                    echo '<td></td><td></td>';
                }
                $count++;
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
        ?>



    <script type="text/javascript">



    </script>

    </div>

	</div>


<!--	 <div class="element" id="selectUsers">


    <h3>Users</h3>

        <p>

            <label for="allUsers">

            <input type="checkbox" name="allUsers" value="1" onclick='allUsersChanged(this);' />

            All&nbsp;&nbsp;

            </label>

        </p>-->


    	<div id="createForm" style="display:none">
    			<div class="element">
    				<label for="mailoutDesc">Description</label>
    				<input id="mailoutDesc" name="mailoutDesc" style="width: 400px;" />
    			</div>

    			<div class="element">
    				<textarea  id="mailoutContent" name="mailoutContent"></textarea>
    			</div>

    			<div class="element" style="height: 29px;">
                    <button style="float: right;" onclick="javascript:preview(); return false;">Preview</button>
    				<button style="float: right;" onclick="javascript:send(); return false;">Send</button>
    			</div>
    	</div>
    </form>

</div>

<div id="dialog-message-mailout" title="Error" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
  <span id="dialogMessageMailout" style="color: red;"></span></p>

</div>

</div>

<link href="<?php echo base_url(); ?>/css/messi.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/js/messi.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">

    $( "#dialog-message-mailout" ).dialog({
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


        var labCount = <?php echo sizeof($locations);?>;
        function allChanged(all)
        {
            if(all.checked)
            {
                for (var cnt = 0; cnt < labCount; cnt++)
                    $('#lab' + cnt).attr('checked','checked');

                if($('#userData').html() == '')
                {
                    $("#selectUsers").mask("Processing...");
                    $.get('mailout/getUsers?all=true', {},
                        function(returnedData,status)
                        {
                            if(status == 'success')
                            {
                                $('#userData').hide('fast');
                                $('#userData').html(returnedData);

                               $('#userOptions input:checked').each(function()
                                {
                                    selectAllUsers(this);
                                });
                            }
                            $('#userData').show('fast');
                            $("#selectUsers").unmask();
                        }
                    );
                }
            }
            else
            {
                for (var cnt = 0; cnt < labCount; cnt++)
                    $('#lab' + cnt).removeAttr('checked');

                $('#userData').hide('fast',function()
                {
                    $('#userData').html('');
                });
            }
        }

        function nonChanged(none)
        {
            for (var cnt = 0; cnt < labCount; cnt++)
                $('#lab' + cnt).removeAttr('checked');

            $(none).removeAttr('checked');
            $('#selectAll').removeAttr('checked');

            $('#userData').hide('fast',function()
            {
                $('#userData').html('');
            });
        }

        function allUsersChanged(all)
        {
            var count = <?php echo sizeof($users);?>;
            if(all.checked)
            {
                for (var cnt = 0; cnt < count; cnt++)
                    $('#user' + cnt).attr('checked','checked');
            }
            else
            {
                for (var cnt = 0; cnt < count; cnt++)
                    $('#user' + cnt).removeAttr('checked');
            }
        }

        function selectAllUsers(option)
        {
            var type = $(option).val();

            if(type == 6)
                return;

            var count = <?php echo sizeof($users); ?>;
            for (var cnt = 0; cnt < count; cnt++)
            {
                if($('#user' + cnt).attr('userType') == type && type != '1')
                {
                    if(option.checked)
                      $('#user' + cnt).attr('checked','checked');
                    else

                        $('#user' + cnt).removeAttr('checked');
                }
                if(type == '1')
                {
                    if(option.checked)
                      $('#user' + cnt).attr('checked','checked');
                    else
                        $('#user' + cnt).removeAttr('checked');

                   $('#userOptions input').each(function()
                    {
                        this.checked = option.checked;
                    });
                }
            }
        }


    function send()
    {
        if($('#mailoutDesc').val() == '')
        {
            $('#dialogMessageMailout').html('Please enter mailout description!');
            $( "#dialog-message-mailout"  ).dialog( "open" );
            return;
        }


        if(tinyMCE.activeEditor.getContent() != '')
        {
                var ids = '';
                $('#userData input:checked').each(function()
                {
                    ids += this.value + ',';
                });

                ids = ids.substring(0, ids.length - 1);


                var labs = '';
                $('#parentForm :input').each(function(index, elm)
                {
                    if(elm.name.indexOf("lab") != -1 && elm.checked)
                    {
                        labs += elm.value +',';
                    }
                });
                labs = labs.substring(0, labs.length - 1);

                var maillist = false;
                $('#userOptions :input').each(function()
                {
                    if(this.name == 'maillist')
                        maillist = this.checked;
                });

                $("#main").mask("Sending...");
                $.post('mailout/sendMailout', { mailoutDesc: $('#mailoutDesc').val(), mailoutContent : tinyMCE.activeEditor.getContent(), ids : ids, labs : labs , maillist : maillist},
                    function(returnedData,status)
                    {
                        if(status == 'success')
                        {
                            if(returnedData == '')
                            {
                                $(window).scrollTop(window);
                                $("#main").unmask();
                                console.log(returnedData) ;
                                $('#createMailout').hide();
                                $('#mailoutConfirmation').show();
                            }
                            else
                            {
                                $(window).scrollTop(window);
                                $('#dialogMessageMailout').html(returnedData);
                                $( "#dialog-message-mailout"  ).dialog( "open" );
                                $("#main").unmask();
                            }

                        }

                    }
                );
            //$('#parentForm').submit();
            return;
        }
        else
        {
            $('#dialogMessageMailout').html('Please enter mailout content!');
            $( "#dialog-message-mailout"  ).dialog( "open" );
            return;
        }




    }

    function preview()
    {
        if(tinyMCE.activeEditor.getContent() == '')
        {
            $('#dialogMessageMailout').html('Please enter mailout content');
            $( "#dialog-message-mailout"  ).dialog( "open" );
            return;
        }

        console.log($('#mailoutContent').val());

        $("#main").mask("Processing...");
        $.post('mailout/preview', { mailoutDesc: $('#mailoutDesc').val(), mailoutContent : tinyMCE.activeEditor.getContent()},
            function(returnedData,status)
            {
                if(status == 'success')
                {
                    $("#main").unmask();
                    $(window).scrollTop(window);
                    new Messi(returnedData, {title: 'Mailout preview', modal: true});
                    console.log(returnedData);
                }
            }
        );


    }


    function selectLocation()
    {
        var ids = '';
        $('#parentForm :input').each(function(index, elm)
        {
            if(elm.name.indexOf("lab") != -1 && elm.checked)
            {
                ids += elm.value +',';
            }
        });



        ids = ids.substring(0, ids.length - 1);

        if(ids == '')
        {
            $('#userData').hide('fast',function()
            {
                $('#userData').html('');
            });

            return;
        }


        $("#userData").mask("Processing...");
        $.get('mailout/getUsers?ids=' + ids, {},
            function(returnedData,status)
            {
                if(status == 'success')
                {
                    $('#userData').hide('fast');
                    $('#userData').html(returnedData);

                   $('#userOptions input:checked').each(function()
                    {
                        selectAllUsers(this);
                    });
                }
                $('#userData').show('fast');
                $("#userData").unmask();
            }
        );
    }

    function selectRecipients()
    {
        $('#labSelect').show('slow');
        $('#createForm').hide('slow');

        return false;
    }



    function selectMailout()
    {
        $('#labSelect').hide('slow');
        $('#createForm').show('slow');
        return false;
    }


    function newMailout()
    {
        location.reload();
    }


</script>

<script type="text/javascript">
tinyMCE.init({mode:"textareas",selector:"mailoutContent",theme:"advanced",plugins:"autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",width:'100%',height:700,file_browser_callback:'openKCFinder',convert_urls:false,theme_advanced_buttons1:"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",theme_advanced_buttons3:"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",theme_advanced_toolbar_location:"top",theme_advanced_toolbar_align:"left",theme_advanced_statusbar_location:"bottom",theme_advanced_resizing:true,skin:"o2k7",skin_variant:"silver",content_css:"",template_external_list_url:"js/template_list.js",external_link_list_url:"js/link_list.js",external_image_list_url:"js/image_list.js",media_external_list_url:"js/media_list.js",template_replace_values:{username:"<?php echo $userName; ?>",staffid:"991234"}});function openKCFinder(field_name,url,type,win){tinyMCE.activeEditor.windowManager.open({file:'<?php echo base_url(); ?>js/kcfinder/browse.php?opener=tinymce&type='+type,title:'KCFinder',width:700,height:500,resizable:"yes",inline:true,close_previous:"no",popup_css:false},{window:win,input:field_name});return false;}
</script>

