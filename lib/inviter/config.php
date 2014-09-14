<?php
	$openinviter_settings=array(
		"username"=>"farman",
		"private_key"=>"8bf2109522316d488fbba4f4d7082c60",
		"cookie_path"=>".",
		"message_body"=>"You are invited to http://networkwe.com",
		"message_subject"=>" is inviting you to http://networkwe.com",
		"transport"=>"curl", //Replace "curl" with "wget" if you would like to use wget instead
		"local_debug"=>"on_error", //Available options: on_error => log only requests containing errors; always => log all requests; false => don`t log anything
		"remote_debug"=>FALSE //When set to TRUE OpenInviter sends debug information to our servers. Set it to FALSE to disable this feature
	);
	?>