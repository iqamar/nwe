<div class="box">
    <div class="boxheading">
		<a href="#Compose" onclick="msg_compose();" class="compose">Compose</a>
        <h1>Inbox</h1>
        <div class="boxheading-arrow"></div>
    </div>
	<div id="search-email">
		<input type="text" placeholder="Search Email" id="keyword"  name="keyword">
		<a id="emailsearch-bttn" onclick="searchMail();" href="#"></a>
	</div>
	<div class="clear"></div>
    <div id="tabs">
        <ul>
            <li><a href="#fragment-1" onclick="msg_inbox();"> Messages (<span id="unreadCount"><?php echo $unreadCount; ?></span>)</a></li>
            <li><a href="#fragment-1" onclick="msg_sent();"> Sent</a></li>
            <!--li><a href="#fragment-3"><img src="<?php echo MEDIA_URL; ?>/img/icon-summary.png" width="15" height="16" /> Archive</a></li-->
            <li><a href="#fragment-1" onclick="trashed_list();"> Trash</a></li>
			

        </ul>
		
		 
        <div>
            

            <div id="fragment-1" class="ui-tabs-panel">
               
            </div>
            

            
            <div id="fragment-2" class="ui-tabs-panel ui-tabs-hide">
                                
            </div>
            

            
            <div id="fragment-3" class="ui-tabs-panel ui-tabs-hide">
                
                
                
            </div>
            


            
            <div id="fragment-4" class="ui-tabs-panel ui-tabs-hide">
               
               
                
            </div>
			
            
			 
 
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
	
</div>