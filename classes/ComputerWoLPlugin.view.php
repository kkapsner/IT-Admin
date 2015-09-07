<?php

if ($args->{"MAC-address"} && $args->wakeOnLAN === "on"){
	echo $this->html($this->getName()) . ": <span class=\"wolPlugin\">" .
		' <span class="link hidesByIp">(<a  target="_blank" href="https://bigmac.e14.ph.tum.de/utils/services/wakeByMAC.php?mac=' . 
		urldecode($args->{"MAC-address"}) . 
		'">send magic packet to wake up</a>)</span>'
		. '<span class="hidesWithoutIp">Computer online</span>'
		. '<span class="status"></span></span>';
}
else {
	echo "wake on LAN not available";
}
?>
