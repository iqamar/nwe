<style type="text/css">
/*USER send message*/
.black_overlay {
    background-color: #000000;
    display: none;
    height: 100%;
    left: 0;
    opacity: 0.6;
    overflow: inherit;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1001;
}
.dialog-wrapper {
    height: auto;
    width: auto;
	position:absolute;
	z-index:1002;
	top:30%;
	left:25%;
}
.dialog-mask {
    background:#B6B6B6;
    border-radius: 5px;
    padding: 15px;
	 border-radius: 0;
    padding: 5px;
	overflow:hidden;
}
.dialog-window {
    position: relative;
}
.dialog-title {
    clear: both;
    display: block;
    overflow: hidden;
	 background: none repeat scroll 0 0 #333333;
    border-style: none;
    padding: 0;
	position:relative;
}
.dialog-close {
    cursor: pointer;
    line-height: 1;
    position: absolute;
    right: 0;
    text-decoration: none;
    top: 0;
    vertical-align: top;
	background:url(/img/uploadify-cancel.png) no-repeat;
	z-index:100;
}
.dialog-title .title {
    color: #FFFFFF;
    font-size: 14px;
    font-weight: normal;
    line-height: 16px;
    margin: 0;
    padding: 10px 20px;
}
.dialog-body {
    background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 0;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15), -1px 0 0 rgba(0, 0, 0, 0.03), 1px 0 0 rgba(0, 0, 0, 0.03), 0 1px 0 rgba(0, 0, 0, 0.12);
	border-style: none;
    margin-bottom: 0;
    padding: 0;
	overflow:hidden;
}
.dialog-content {
    padding: 15px 20px;
}
.send-message-dialog {
    position: relative;
}
.send-message-dialog ul {
    background-color: #F4F4F4;
    margin: -15px -20px 0;
    padding: 15px 20px 0;
}
.send-message-dialog li {
    margin-bottom: 6px;
    overflow: hidden;
    padding: 2px;
    width: 98%;
}
.send-message-dialog li label {
    color: #333333;
    float: left;
    font-weight: bold;
    text-align: right;
    width: 75px;
}
.send-message-dialog li .elem {
    padding-left: 83px;
}
.send-message-dialog li.subject {
    margin-bottom: 6px;
    margin-top: 20px;
}
.send-message-dialog li .elem input {
    border: 1px solid #C7C7C7;
    border-radius: 3px;
    box-shadow: 0 0 7px 0 #EEEEEE inset;
    padding: 6px 8px;
    width: 340px;
}
.send-message-dialog textarea {
    border: 1px solid #C7C7C7;
    border-radius: 3px;
    box-shadow: 0 0 7px 0 #EEEEEE inset;
    margin-bottom: 15px;
    margin-top: 0;
    padding: 6px 8px;
    width: 430px;
	font-size: 13px;
    height: 100px;
}
.send-message-dialog li.actions {
    background-color: #FFFFFF;
    margin: 0 -20px;
    padding: 15px 20px 2px;
    width: 100%;
}
.send-message-dialog .btn-primary {
    margin-left: 0;
    margin-right: 35px;
	 background-color: #336699;
    border-right: 1px solid #CCCCCC;
    color: #fff;
    float: left;
    padding: 10px 25px;
    text-decoration: none;
	border-radius:5px;
}
</style>

<div style="display: block;" class="black_overlay" id="fade"></div>

 <!-- SEND MESSAGE FORM -->
<div class="dialog-wrapper" style="display:none;" id="userSendForm">
	<div class="dialog-mask">
		<div class="dialog-window">
			<div class="dialog-title">
				<button class="dialog-close" onclick="hideMessageForm();">close</button>
				<h3 class="title">Send Deepak Patil a message</h3>
			</div>
			<div class="dialog-body">
				<div class="dialog-content">
					<div class="send-message-dialog">
					<form name="sendMessage" method="post" action="">
						<ul>
							<li>
								<label>To:</label>
								<div class="elem">Deepak Patil</div>
							</li>
								<li>
								<label>Subject:</label>
								<div class="elem"><input type="text" class="inpt " maxlength="150" name="subject" /></div>
							</li>
							<li>
								<textarea rows="4" cols="50" name="message"></textarea>
							</li>
							<li class="action">
								<input type="submit" class="btn-primary" value="Send Message" name="submit" />
							</li>
						</ul>
					</form>
				</div>
			   </div>
			</div>
		</div>
	</div>
</div>
