<?php
require 'facebook-php-sdk-master/src/facebook.php';

$facebook = new Facebook(array(
	'appId' => '686151734741786',
	'secret' => 'ef0e68e6269212e9802382bde2e8246d'
));

$user = $facebook->getUser();

if ($user) {
	$permissions = $facebook->api('/me/permissions');
	if ( isset($permissions['data'][0]['user_groups']) 
		&& isset($permissions['data'][0]['publish_stream'])) {
		$groups = $facebook->api('/me/groups');
		$post = array(
			'message' => 'Selamat Tengahari',
			'link' => '',
			'picture' => '',
			'name' => '',
			'caption' => '',
			'description' => ''
		);

		foreach($groups['data'] as $group) {
			$posturl = $group['id']."/feed";
			$postresult = $facebook->api($posturl, 'POST', $post);
			sleep(1);
		}

	}else {
		header("Location: ".$facebook->getLoginUrl(array('scope' => 'user_groups,publish_stream')) );
		exit;
	}

}else {
	header("Location: ".$facebook->getLoginUrl(array('scope' => 'user_groups,publish_stream')) );
	exit;
}

?>
