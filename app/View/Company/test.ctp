<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>
    
  $(function() {
    FB.init({
      appId  : '208209559352635',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });
    document.getElementById('fb-login').onclick = function() {
    FB.getLoginStatus(function(response) {
      if (response.status == 'connected') {
        getCurrentUserInfo(response)
      } else {
        FB.login(function(response) {
          if (response.authResponse){
            getCurrentUserInfo(response)
          } else {
            //console.log('Auth cancelled.')
          }
        }, { scope: 'email' });
      }
    });
    
  };

    function getCurrentUserInfo() {
      FB.api('/me', function(userInfo) {
        console.log(userInfo.name + ': ' + userInfo.email);
      });
    }
  });
</script>
<button id="fb-login">Login & Permissions</button>