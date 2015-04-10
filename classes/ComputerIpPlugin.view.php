<?php

$ip = $this->getIp($args);
echo $this->html($this->getName()) . ": ";
echo "\n" . '<span id="ipPlugin" data-pc-name="' . $this->html($args->name) . '">';
echo $this->html($ip);

if ($ip !== "unknown"){
	echo "\n<ul>\n";
	if (count($args->remoteUser)){
		echo ' <li><a  target="_blank" href="http://bigmac.e14.ph.tum.de/utils/ipList/createRDP.php?name=' . 
				urlencode($args->name) . 
				'">open remote desktop</a></li>' . "\n";
	}
	if (strpos($args->OS, "Mac OS X") === 0){
		echo ' <li><a  target="_blank" href="afp://' . $ip . 
				'">open afp connection</a></li>' . "\n";
	}
	echo ' <li><a  target="_blank" href="smb://' .
			(
				$args->smbUser?
					($args->smbUser . "@"):
					""
			) . $ip . 
			'">open smb connection</a></li>' . "\n";
//	echo ' <li><a  target="_blank" href="file://' . $ip . '/">open windows share</a></li>' . "\n";
	echo "</ul>\n";
}
echo "\n</span>\n";
?>