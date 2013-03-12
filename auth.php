<?php
	
	/**
	 * Let me see your tokens (https://github.com/sergiovilar/Let-me-see-your-tokens)
	 * Copyright 2012-2013, Sérgio Vilar (http://sergiovilar.com.br)
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @copyright     Copyright 2012-2013, Sérgio Vilar (http://sergiovilar.com.br)
	 * @link          https://github.com/sergiovilar/Let-me-see-your-tokens
	 * @package       Let me see your tokens
	 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
	 */

	$app_id = '';
	$app_secret = '';
	$redirect = '';

	$code = $_REQUEST["code"];

   	if(empty($code)):

		$location = 'https://graph.facebook.com/oauth/authorize?
		    client_id='.$app_id.'&
		    redirect_uri='.$redirect.'&
		    scope=manage_pages,email';

		header('location:'.$location);

	else:

		 $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect)
       . "&client_secret=" . $app_secret . "&code=" . $code;

	    $response = file_get_contents($token_url);
	    
	    $response = str_replace('access_token=', '', $response);
	    $ar = explode('&', $response);

	    $token = $ar[0];

	    $graph_url = "https://graph.facebook.com/me/accounts?access_token=" 
       . $token;

     	$accounts = json_decode(file_get_contents($graph_url));

     	echo "<strong>Your token:</strong> ".$token."<br /><br />";

	    foreach($accounts->data as $conta):

	    	echo "<strong>".$conta->name.":</strong> ".$conta->access_token."<br />";

	    endforeach;

    endif;

?>