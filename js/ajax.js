function Ajax() 
{
    this.req = null;
    this.url = '';
    this.method = 'GET';
    this.async = true;
    this.status = null;
    this.statusText = '';
    this.postData = null;
    this.readyState = null;
    this.responseText = null;
    this.responseXML = null;
    this.handleResp = null;
    this.responseFormat = 'text', // 'text', 'xml', or 'object'
    this.mimeType = null;
    
    
    this.init = function() 
    {
        if (!this.req)
        {
            try
            {
                // Try to create object for Firefox, Safari, IE7, etc.
                this.req = new XMLHttpRequest();
            }
            catch (e) 
            {
                try 
                {
                    // Try to create object for later versions of IE.
                    this.req = new ActiveXObject('MSXML2.XMLHTTP');
                }
                catch (e) 
                {
                    try 
                    {
                        // Try to create object for early versions of IE.
                        this.req = new ActiveXObject('Microsoft.XMLHTTP');
                    }
                    catch (e) 
                    {
                        // Could not create an XMLHttpRequest object.
                        return false;
                    }
                }
            }
        }
        return this.req;
    };
    
    this.doReq = function(url,callback,object,loading) 
    {

 
 		$.ajax({
			url: url, 
			type: 'get',
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				   $("#main").unmask();
				   $("#dialogMessageAjaxError").html(errorThrown);
				   $( "#dialog-message-ajax-error"  ).dialog( "open" );
			},
			success: function(returnedData,status)
			{
				if(status == 'success')
				{
                    if(callback != null)
            			callback(returnedData,object);				  
				}

				
				$("#main").unmask();                  
			}
		});
 /*
        
            
        try
        {
            if(callback != null)
                $("#main").mask("Loading...");
        }
        catch(err){};
            
        this.url = url;
        if (!this.init()) 
        {
            alert('Could not create XMLHttpRequest object.');
            return;
        }
        this.req.open(this.method, this.url, this.async);

        if (this.mimeType) 
        {
            try 
            {
                req.overrideMimeType(this.mimeType);
            }
            catch (e) 
            {
            // couldn't override MIME type -- IE6 or Opera?
            }
        }        
        
        var self = this; // Fix loss-of-scope in inner function
        this.req.onreadystatechange = function() 
        {
            var resp = null;
            if (self.req.readyState == 4) 
            {
                // Do stuff to handle response
                resp = self.req.responseText;
                if (self.req.status >= 200 && self.req.status <= 299) 
                {
                    self.handleResp(resp,callback,object);
                }
                else 
                {
                    self.handleErr(resp + ' ' + self.req.status);
                }
            }
			try
			{
				$("#main").unmask();
			}
			catch(err){ };
        };
        
        this.req.send(this.postData);*/
    };
    
    this.setMimeType = function(mimeType) 
    {
        this.mimeType = mimeType;
    };
    
    this.handleErr = function(text) 
    {
        document.write(text);
        try
        {
            $("#main").unmask();
        }
        catch(err){ };
        return false;
    }
	
    this.handleResp = function(text,callback,object) 
    {
        if(callback != null)
			callback(text,object);
                  
         try
        {
            $("#main").unmask();
        }
        catch(err){ };
    }
    
}