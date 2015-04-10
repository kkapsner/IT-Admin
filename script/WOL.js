(function(){
	var ip = kkjs.$("ipPlugin");
	ip = {
		baseNode: ip,
		name: kkjs.dataset.get(ip, "pcName")
	};
	var wol = kkjs.$("wolPlugin");
	wol = {
		baseNode: wol,
		link: kkjs.css.$(".link", {node: wol})[0],
		status: kkjs.css.$(".status", {node: wol})[0],
		setStatus: function(txt){
			if (txt){
				this.link.style.display = "none";
				this.status.innerHTML = txt.encodeHTMLEntities();
			}
			else {
				this.link.style.display = "";
				this.status.innerHTML = "";
			}
		}
	};
	
	if (!wol.link){
		return;
	}
	
	function checkIp(){
		var dots = ".";
		wol.setStatus("Magic packet sent. Waiting for computer to show up" + dots);
		var interval = window.setInterval(
			function(){
				dots += ".";
				if (dots.length > 3){
					dots = dots.substring(0, 1);
				}
				wol.setStatus("Magic packet sent. Waiting for computer to show up" + dots);

				kkjs.ajax.advanced({
					url: "//bigmac.e14.ph.tum.de/utils/ipList/singleNameRequest.php?name=" + ip.name,
					onload: function(txt){
						if (txt !== "unknown"){
							window.clearInterval(interval);
							wol.setStatus("Computer showed up.");
							ip.baseNode.innerHTML =
								"(<a " +
									"target=\"_blank\" " +
									"href=\"//bigmac.e14.ph.tum.de/utils/ipList/createRDP.php?name=" + ip.name + "\"" +
								">open remote desktop</a>)"
						}
					}
				});
			},
			5000
		);
		window.setTimeout(
			function(){
				window.clearInterval(interval);
				wol.setStatus("Wake on LAN failed...");
				wol.link.style.display = "";
			},
			5*60*1000
		);
	}
	
	kkjs.event.add(kkjs.css.$("a", {node: wol.link}), "click", function(ev){
		ev.preventDefault();
		
		kkjs.ajax.advanced({
			url: this.href,
			onload: function(){
				wol.setStatus("Magic packet sent.");
				checkIp();
			},
			onerror: function(){
				wol.setStatus("Server not available.");
			}
		});
		wol.setStatus("Sending magic packet.");
		
	});
}());

