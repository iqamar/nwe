<style>
.login_error_box {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #dfdfdf;
    border-radius: 7px;
    margin: 0 auto 60px;
    padding: 10px;
    width: 400px;
}
div-heading {
    font-size: 16px;
    margin: 0 0 8px;
}
.login_error_box .textfield {
    border: 1px solid #ccc;
    color: #999;
    font-size: 14px;
    padding: 8px 6px;
    width: 380px;
}

.red-bttn {
    background: none repeat scroll 0 0 #c70000;
    border: 1px solid #b00314;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    margin-top: 5px;
    padding: 4px 15px;
}
.login_error_box a {
    color: #c70000;
}
.margintop10 {
    margin-top: 5px;
}
</style>
 <div class="login_error_box">
        <div>
            <div class="greybox-div-heading"> 
                <h1>Sign in to Networkwe</h1>
            </div>
            <form accept-charset="utf-8" id="UserLoginForm" class="login_form" method="post" controller="users" action="/users/login"><div style="display:none;">
            <input type="hidden" value="POST" name="_method"></div>                
            <table width="100%" border="0" cellspacing="2" cellpadding="1">
                    <tbody><tr>
                        <td>
                        <input type="email" id="UserEmail" size="26" class="textfield signin-text" placeholder="User ID" required="required" name="data[User][email]">                        </td>
                    </tr>

                    <tr>
                        <td>
                        <input type="password" id="UserPassword" size="26" class="textfield signin-text" placeholder="Password" required="required" name="data[User][password]">                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Sign In" class="red-bttn"> or <a href="http://www.networkwe.net">Join Networkwe</a></td>
                    </tr>
					<tr>
						<td colspan="2">
							<div class="margintop10">
								<input type="hidden" value="0" id="remember_me_" name="data[User][remember_me]"><input type="checkbox" value="1" id="remember_me" name="data[User][remember_me]">&nbsp;Keep me Logged in
							</div>
						</td>
					</tr>
                </tbody></table>
            </form>        </div>
    </div>