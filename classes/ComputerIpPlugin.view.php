<?php

echo $this->html($this->getName()) . ": ";
echo "\n" . '<span class="ipPlugin" data-pc-name="' . $this->html($args->name) . '">';
echo "\n" .'<span class="hidesByIp" ' .
	'><em>computer offline</em></span>';
echo "\n" .'<span class="hidesWithoutIp" ' .
	'data-ip-dependencies="{&quot;innerHTML&quot;: &quot;{ip}&quot;}"' .
	'></span>';

echo "\n<ul class=\"hidesWithoutIp\">\n";
if (count($args->remoteUser)){
	echo ' <li><a  target="_blank" href="http://bigmac.e14.ph.tum.de/utils/ipList/createRDP.php?name=' . 
			urlencode($args->name) . 
			'">open remote desktop</a></li>' . "\n";
}
if (strpos($args->OS, "Mac OS X") === 0){
	echo ' <li><a target="_blank" data-ip-dependencies="{&quot;href&quot;: &quot;afp://{ip}&quot;}">open afp connection</a></li>' . "\n";
}
echo ' <li><a  target="_blank" data-ip-dependencies="{&quot;href&quot;: &quot;smb://' .
		(
			$args->smbUser?
				($this->html(str_replace("\\", "\\\\", $args->smbUser)) . "@"):
				""
		) . '{ip}&quot;}' . 
		'">open smb connection</a></li>' . "\n";
//	echo ' <li><a  target="_blank" data-ip-dependencies="{\\"file\\": \\"aft://{ip}\\"}">open windows share</a></li>' . "\n";
echo "</ul>\n";
echo "\n</span>\n";
?>