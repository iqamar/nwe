<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $paypalData['business']; ?>">
<input type="hidden" name="amount" value="<?php echo $paypalData['business']; ?>">
<input type="hidden" name="item_name_1" value="<?php echo $paypalData['item_name_1']; ?>">
<input type="hidden" name="item_number_1" value="<?php echo $paypalData['item_number_1']; ?>">
<input type="hidden" name="amount_1" value="<?php echo $paypalData['amount_1']; ?>">
<input type="hidden" name="currency_code" value="<?php echo $paypalData['currency_code']; ?>">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>-->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="111@gulfbankers.com">
    <input type="hidden" name="amount" value="89">
    <input type="hidden" name="item_name" value="Entry Level - 0 to 3 Years Experience">
    <input type="hidden" name="currency_code" value="USD">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<?php
//echo $this->Html->script(array(MEDIA_URL . '/js/bsn.AutoSuggest_2.1.3.js'));
//echo $this->Html->css(array(MEDIA_URL . '/css/autosuggest_inquisitor.css'));
?>
<?php
/*echo $this->Html->script(array(
    'http://textextjs.com/textext/js/textext.core.js', 
    'http://textextjs.com/textext/js/textext.plugin.ajax.js',
    'http://textextjs.com/textext/js/textext.plugin.filter.js'
    ));
echo $this->Html->css(array(
    'http://textextjs.com/textext/css/textext.core.css', 
    'http://textextjs.com/textext/css/textext.plugin.autocomplete.css',
    'http://textextjs.com/textext/css/textext.plugin.tags.css'
    ));*/
?>
<?php
echo $this->Html->script(array('http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.min.js',MEDIA_URL . '/js/jquery.fcbkcomplete.js'));
echo $this->Html->css(array(MEDIA_URL . '/css/fcbkcomplete.css'));
?>


<form action="submit.php" method="POST" accept-charset="utf-8">
            <select id="select3" name="select3">
                <option value="sleep" class="selected">sleep</option>
                <option value="sport">sport</option>
                <option value="freestyle">freestyle</option>
            </select>
            <br/>
            <br/>
            <input type="submit" value="Send">
        </form>
        <form action="submit.php" method="POST" accept-charset="utf-8">
            <select id="select2" name="select2">
                <option value="sleep" class="selected">sleep</option>
                <option value="sport">sport</option>
                <option value="freestyle">freestyle</option>
            </select>
            <br/>
            <br/>
            <input type="submit" value="Send">
        </form>
        <script type="text/javascript">
            $(document).ready(function(){                
                $("#select3").fcbkcomplete({
                    json_url: "data.txt",
                    addontab: true,                   
                    maxitems: 2,
                    height: 2,
                    cache: true
                });
                $("#select2").fcbkcomplete({
                    json_url: "/users_profiles/fetch_skills/",
                    addontab: true,                   
                    maxitems: 2,
                    height: 2,
                    cache: true
                })
            });
        </script>
        
        <div id="testme"></div>



<!--<link rel="stylesheet" href="/textext/css/textext.core.css" type="text/css" />
<link rel="stylesheet" href="http://textextjs.com/textext/css/textext.plugin.tags.css" type="text/css" />
		<link rel="stylesheet" href="http://textextjs.com/textext/css/textext.plugin.autocomplete.css" type="text/css" />
		<link rel="stylesheet" href="http://textextjs.com/textext/css/textext.plugin.focus.css" type="text/css" />
		<link rel="stylesheet" href="http://textextjs.com/textext/css/textext.plugin.prompt.css" type="text/css" />
		<link rel="stylesheet" href="http://textextjs.com/textext/css/textext.plugin.arrow.css" type="text/css" />
		<script src="http://textextjs.com/textext/js/textext.core.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.tags.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.autocomplete.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.suggestions.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.filter.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.focus.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.prompt.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.ajax.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://textextjs.com/textext/js/textext.plugin.arrow.js" type="text/javascript" charset="utf-8"></script>
<textarea id="textarea" class="example" rows="1"></textarea>
<script type="text/javascript">
	$('#textarea')
		.textext({
			plugins : 'autocomplete filter tags ajax',
			ajax : {
				url : '<?php echo $NETWORKWE_URL; ?>/users_profiles/fetch_skills/',
				dataType : 'json',
				cacheResults : true
			}
		})
	;
</script>-->

<!--<script type="text/javascript">
        var options = {
                script:"test.php?json=true&limit=6&",
                varname:"input",
                json:true,
                shownoresults:false,
                maxresults:6,
                callback: function (obj) { document.getElementById('testid').value = obj.id; }
        };
        var as_json = new bsn.AutoSuggest('testinput', options);
        
        
        var options_xml = {
                script: function (input) { return "test.php?input="+input+"&testid="+document.getElementById('testid').value; },
                varname:"input"
        };
        var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
</script>
<form method="get" action="" class="asholder">
        <small style="float:right">Hidden ID Field: <input type="text" id="testid" value="" style="font-size: 10px; width: 20px;" disabled="disabled" /></small>
        <label for="testinput">Person</label>
        <input style="width: 200px" type="text" id="testinput" value="" /> 
        <input type="submit" value="submit" />
</form>-->