<div class="full_w" >
	<div class="h_title"><?php echo $title;?></div>
    <?php $this->load->view('display'); ?>
    
<? echo form_open('training/addNew',array('id' => 'parentForm')); ?>

    <div class="element">
        <label for="trainingDesc">Description</label>
        <input name="trainingDesc" style="width: 200px;" /> 
    </div> 
    
    <div class="element">
        <textarea id="trainingContent" name="trainingContent"></textarea>
    </div>
    
    <div class="element">
        <input type="submit" />
    </div>
</form>
    
    
</div>

<script type="text/javascript" src="<?php echo base_url();?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
    
    //SET FULL url in js/kcfinder/config.php  uploadURL to full domain  http://192.168.0.3/lab/js/kcfinder/upload
        // General options
        mode : "textareas",
        selector: "trainingContent",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        width: '100%',
        height: 700,
        file_browser_callback: 'openKCFinder',
        
        convert_urls : false,

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "<?php echo $userName; ?>",
                staffid : "991234"
        }
});

function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: '<?php echo base_url();?>js/kcfinder/browse.php?opener=tinymce&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}
</script>
</script>