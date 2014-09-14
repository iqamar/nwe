<div id="tabcontent">
<div class="margintop10 marginbottom20"><h1>Check Who You Already Know on NetworkWe</h1></div>
  <div id="tabwrapper">
  <div style="" id="navigation">
    <ul>
      <li class="selected">
      	
        <a href="#">
        <div class="gmail_icon"></div>
			Gmail</a>
        </li>
      <li>
        <a href="#">
        <div class="yahoo_icon"></div>
        Yahoo!!</a>
        </li>
      <li>
        <a href="#">
        <div class="hotmail_icon"></div>
        Hotmail</a>
      </li></ul>
    </div>
    <div id="steps" style="width: 1830px;">
      <form method="post" action="" name="formElem" id="formElem">
        <fieldset class="step">
          <legend>Get started by adding your Gmail Account.</legend>
          <div class="contentbox">
                <table width="450" cellspacing="4" cellpadding="2" border="0">
                  <tbody><tr>
                    <td width="59"><strong>eMail ID:</strong></td>
                    <td width="371" align="left">
                    	<input type="text" id="gmail_email" size="80">
                    	<span class="redcolor" id="red_alert"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">
                    <a onclick="checkGemailEmailId()" href="#" class="button">Import</a>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">
                    <a onmouseover="tooltip.pop(this, '#why')" href="#why" class="smallnote">
                    You are Safe</a>
              				<div style="display:none;">
                                    <div id="why"> 
                                      <strong>Your contacts are safe with us!</strong><br>
We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.
                               		 </div>
                                     </div>
                    </td>
                  </tr>
                </tbody></table>

				<div></div>
            </div>
            </fieldset>
            
        
    <fieldset class="step">
          <legend>Get started by adding your Yahoo Account.</legend>
          <div class="contentbox">
            <table width="450" cellspacing="4" cellpadding="2" border="0">
              <tbody><tr>
                <td width="59"><strong>eMail ID:</strong></td>
                <td width="371" align="left">
                <input type="text" id="yahoo_email" size="80">
                <span class="redcolor" id="red_alert_yahoo"></span>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left"><a onclick="checkYahooEmailId('<?php echo $auth_url;?>')" href="#" class="button">Import</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right"><a onmouseover="tooltip.pop(this, '#why')" href="#why" class="smallnote"> You are Safe</a>
                  <div style="display:none;">
                    <div id="why2"> <strong>Your contacts are safe with us!</strong><br>
                      We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission. </div>
                  </div></td>
              </tr>
            </tbody></table>
            <div></div>
            </div>
            </fieldset>
    
    <fieldset class="step">
          <legend>Get started by adding your Hotmail Account.</legend>
          <div class="contentbox">
            <table width="450" cellspacing="4" cellpadding="2" border="0">
              <tbody><tr>
                <td width="59"><strong>eMail ID:</strong></td>
                <td width="371" align="left">
                	<input type="text" id="hotmail_email" size="80">
                    <span class="redcolor" id="red_alert_hotmail"></span>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left"><a href="#" onclick="checkHotmailEmailId('<?php echo $urls_?>')" class="button">Import</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right"><a onmouseover="tooltip.pop(this, '#why')" href="#why" class="smallnote"> You are Safe</a>
                  <div style="display:none;">
                    <div id="why3"> <strong>Your contacts are safe with us!</strong><br>
                      We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission. </div>
                  </div></td>
              </tr>
            </tbody></table>
            <div></div>
            </div>
            </fieldset>
    
        <div id="mcTooltipWrapper" style="padding: 9px; opacity: 0; display: none; visibility: hidden; top: 453px; left: 1223px;"><div id="mcTooltip" style="border-color: rgb(187, 187, 187); background-color: rgb(234, 236, 240); width: 301px; height: 17px;"></div><div id="mcttCo" style="width: 10px; height: 18px; margin: 0px -1px 0px 0px; visibility: hidden; left: 0px; top: 0px;"><em style="border-color: transparent rgb(187, 187, 187); margin: 0px; border-right: 9px solid rgb(187, 187, 187); border-left: 0px none rgb(187, 187, 187); border-style: dashed solid dashed none; border-width: 9px 9px 9px 0px; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none;"></em><b style="border-color: transparent rgb(234, 236, 240); margin: -18px 0px 0px 1px; border-right: 9px solid rgb(234, 236, 240); border-left: 0px none rgb(234, 236, 240); border-style: dashed solid dashed none; border-width: 9px 9px 9px 0px; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none;"></b></div><div id="mcttCloseButton" style="visibility: hidden;"></div></div></form>
      </div>
    </div>
</div>
<div class="clear"></div>
<div class="clear"></div>
<script>
	function checkGemailEmailId() {
		var gmail_id = $("#gmail_email").val();
		if (gmail_id != '') {
			var gmail_str = gmail_id.split("@");
			if (gmail_str[1] == 'gmail.com') {
				window.location.assign("https://accounts.google.com/o/oauth2/auth?client_id=<?php print $clientid;?>&redirect_uri=<?php print $redirecturi; ?>
&scope=https://www.google.com/m8/feeds/&response_type=code");
				
			}
			else {
				$("#red_alert").html("Please enter gmail account");
			return false;	
			}
			
		}
		else {
			$("#red_alert").html("Please enter gmail account");
			return false;	
			}
	}
	
	function checkYahooEmailId(yahoo_url) {
		var yahoo_id = $("#yahoo_email").val();
		if (yahoo_id != '') {
			var yahoo_str = yahoo_id.split("@");
			var yahoo_top_domain = yahoo_str[1].split(".");
			if (yahoo_top_domain[0] == 'yahoo' || yahoo_top_domain[0] == 'ymail') {
				window.location.assign(yahoo_url);
			}
			else {
				$("#red_alert_yahoo").html("Please enter yahoo account");
			return false;	
			}
			
		}
		else {
			$("#red_alert_yahoo").html("Please enter yahoo account");
			return false;	
			}
	}
	
	function checkHotmailEmailId(hotmail_url) {
		
		var hotmail_id = $("#hotmail_email").val();
		if (hotmail_id != '') {
			var hotmail_str = hotmail_id.split("@");
			var hotmail_top_domain = hotmail_str[1].split(".");
			if (hotmail_top_domain[0] == 'hotmail' || hotmail_top_domain[0] == 'live') {
				window.location.assign(hotmail_url);
				
			}
			else {
				$("#red_alert_hotmail").html("Please enter hotmail account");
			return false;	
			}
			
		}
		else {
			$("#red_alert_hotmail").html("Please enter hotmail account");
			return false;	
			}
	}
</script>