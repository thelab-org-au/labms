<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/navi.css" media="screen" />
<link href="<?php echo base_url(); ?>/css/jquery.loadmask.css" rel="stylesheet" type="text/css" />    
   <!-- Gui  --> 
   

   
   
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" type="text/css" />
  

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery.loadmask.min.js"></script>   
  

    <style type="text/css" media="screen">
  #canvas { height: 500px; background: #bebebe; border: 1px solid black; }
  </style>


<!--[if lt IE 7]>
 <script type="text/javascript" src="<?php echo base_url(); ?>/js/json2.js"></script>   
<![endif]-->

<!--<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript">
$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
    //$(".box").children(".h_title").each( function() { $(this).next("ul").slideToggle(); });
    
    try
    {
        $("#main").unmask();
    }
    catch(err){};
    
});
</script>



</head>