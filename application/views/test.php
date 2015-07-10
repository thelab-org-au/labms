<h1>Test page</h1>




<?php echo $error;?>

<?php echo form_open_multipart('test/upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

