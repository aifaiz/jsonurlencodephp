<?php

$html = '<form action="" method="post">';
$html .= '<textarea name="textAreaField" id="textAreaField" rows="10" cols="150">';
$html .= '[%7b%22TxnType%22%3a%22PAY%22%2c%22Method%22%3a%22OB%22%2c%22MerchantID%22%3a%22WTIRNN%22%2c%22MerchantPymtID%22%3a%22181208102604370%22%2c
%22MerchantOrdID%22%3a%227032%22%2c%22MerchantTxnAmt%22%3a%2261.70%22%2c%22MerchantCurrCode%22%3a%22MYR%22%2c%22PTxnID%22%3a
%22WTIRNN00000181208102604370%22%2c%22PTxnStatus%22%3a%220%22%2c%22PTxnMsg%22%3a%22CPayment 
%2520Successful%22%2c%22AcqBank%22%3a%22FPXD%22%2c%22BankRefNo%22%3a%22181211121212081826420496%22%2c
%22Sign%22%3a%223bb1e62bbabc7778bdd6b09580e7dc918fb8da940849996b6ea3a73f5adb21ce7537b2c52e46fb4bedd0026a96154b84453841e2e3ced0910ad550618f7d2192%22%7d]';
$html .= '</textarea><br />';
$html .= '<input type="submit" value="Submit" name="SubmitButton">';
$html .= '</form>';
$html .= 'step 1: ambil input. masuk dalam variable $posted<br />';
$html .= 'step 2: proses $decoded = urldecode($posted);<br />';
$html .= 'step 3: echo $decoded;<br />';
$html .= 'step 4: convert ke json $json = json_decode($decoded);<br />';
$html .= 'step 5: echo $json;<br /><br />';
echo $html;

$someJSONtxt = '[{"TxnType":"PAY","Method":"OB","MerchantID":"WTIRNN","MerchantPymtID":"181208102604370", "MerchantOrdID":"7032","MerchantTxnAmt":"61.70","MerchantCurrCode":"MYR","PTxnID": "WTIRNN00000181208102604370","PTxnStatus":"0","PTxnMsg":"CPayment%20Successful","AcqBank":"FPXD","BankRefNo":"181211121212081826420496", "Sign":"3bb1e62bbabc7778bdd6b09580e7dc918fb8da940849996b6ea3a73f5adb21ce7537b2c52e46fb4bedd0026a96154b84453841e2e3ced0910ad550618f7d2192"}]';
$urlencodeJSON = urlencode($someJSONtxt);
$urldecodeJSON = urldecode($urlencodeJSON);
$someJSON = json_decode($urldecodeJSON);

// https://stackoverflow.com/questions/33691352/json-encode-not-working-with-urldecode
// https://stackoverflow.com/questions/24312715/json-encode-returns-null-json-last-error-msg-gives-control-character-error-po

if(isset($_POST['SubmitButton'])){
	$posted = $_POST['textAreaField'];
	$decoded = urldecode($posted);
	$pregRep = preg_replace('/[[:cntrl:]]/', '', $decoded);
	//echo "post: <br/>" . $decoded.'<br/><br/>';
	$json = json_decode($pregRep, true);
	echo json_last_error_msg();
	echo'<br><br>';
	//echo "result: <br/>" . $json;
	
	echo'<div style="clear:both;overflow:hidden;">';
		echo'<div style="float:left;width:45%;padding:10px;word-break:break-word;">';
			echo'<h3>JSON Tersedia</h3>';
			echo $urldecodeJSON;
			echo'<br><br>';
			echo'<pre style="word-break:break-word;">'.print_r($someJSON,1).'</pre>';
		echo'</div><!-- 1 -->';
		echo'<div style="float:left;width:45%;padding:10px;word-break:break-word;">';
			echo'<h3>JSON Posted</h3>';
			echo $pregRep;
			echo'<br><br>';
			echo'<pre>'.print_r($json,1).'</pre>';
		echo'</div><!-- 2 -->';
	echo'</div>';
	
	$arrGiven = (array) $someJSON[0];
	$arrPosted = (array) $json[0];
	
	foreach($arrGiven as $k=>$given):
		if($arrGiven[$k] == $arrPosted[$k]):
			echo 'SAME WITH POSTED<br>';
			echo 'GKEY: '.$k.' | GVal: '.$arrGiven[$k].'<br>';
			echo 'GKEY: '.$k.' | GVal: '.$arrPosted[$k].'<br><br>';
		else:
			echo 'NOT SAME WITH POSTED<br>';
			echo 'GKEY: '.$k.' | GVal: '.$arrGiven[$k].'<br>';
			echo 'GKEY: '.$k.' | GVal: '.$arrPosted[$k].'<br><br>';
		endif;
	endforeach;
	exit;
};