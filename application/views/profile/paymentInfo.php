<div id="paymentInfoDisplay" > 
    <h2>Payments</h2>

    <a href="<?php echo site_url().'/payment' ?>">payments</a>
    
</div>
<script type="text/javascript">
    function paymentInfoClose()
    {
        $('#paymentInfoDisplay').hide('fast');
        return false;
    }
</script>