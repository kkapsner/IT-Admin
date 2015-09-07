(function(){
	function requestIP(name, foundIP, error){
		kkjs.ajax.advanced({
			method: "GET",
			url: "https://bigmac.e14.ph.tum.de/utils/ipList/singleNameRequest.php?name=" + name,
			onerror: error,
			onfunctionerror: error,
			onload: function(ip){
				if (ip !== "unknown"){
					foundIP(ip);
				}
				else {
					error(404);
				}
			}
		});
	}
	
	kkjs.css.$(".ipPlugin").forEach(function(ipPlugin){
		var pluginSection = ipPlugin.parentNode;
		while (!kkjs.css.className.has(pluginSection, "Plugins")){
			pluginSection = pluginSection.parentNode;
		}
		var waitingNode = kkjs.node.create({
			tag: "em",
			childNodes: "receiving IP status",
			parentNode: ipPlugin
		});
		var refreshNode = kkjs.node.create({
			tag: "span",
			className: "link",
			childNodes: "refresh",
			parentNode: ipPlugin,
			events: {
				click: function(){
					refreshIp();
				}
			}
		});
		var ipDependentNodes = kkjs.css.$("*[data-ip-dependencies]", {node: pluginSection});
		var hideByIp = kkjs.css.$(".hidesByIp", {node: pluginSection});
		var hideWithoutIp = kkjs.css.$(".hidesWithoutIp", {node: pluginSection});
		var name = kkjs.dataset.get(ipPlugin, "pcName");
		
		
		function refreshIp(foundIp, notFoundIp){
			kkjs.css.set(hideByIp, "display", "none");
			kkjs.css.set(hideWithoutIp, "display", "none");
			kkjs.css.set(waitingNode, "display", "");
			kkjs.css.set(refreshNode, "display", "none");
			
			requestIP(name, function(ip){
				ipDependentNodes.forEach(function(dependent){
					try {
						var dependencies = JSON.parse(kkjs.dataset.get(dependent, "ipDependencies"));
						if (dependencies){
							Object.keys(dependencies).forEach(function(attr){
								dependent[attr] = dependencies[attr].replace(/\{ip\}/g, ip);
							});
						}
					}
					catch (e){
					}
				});
				kkjs.css.set(hideWithoutIp, "display", "");
				kkjs.css.set(waitingNode, "display", "none");
				kkjs.css.set(refreshNode, "display", "");
				foundIp? foundIp(ip): "";
			}, function(){
				kkjs.css.set(hideByIp, "display", "");
				kkjs.css.set(waitingNode, "display", "none");
				kkjs.css.set(refreshNode, "display", "");
				notFoundIp? notFoundIp(): "";
			})
		}
		refreshIp();
		
		var wol = kkjs.css.$(".wolPlugin", {node: pluginSection});
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
					refreshIp(function(){
						window.clearInterval(interval);
						wol.setStatus("Computer showed up.");
					}, function(){
						dots += ".";
						if (dots.length > 3){
							dots = dots.substring(0, 1);
						}
						wol.setStatus("Magic packet sent. Waiting for computer to show up" + dots);
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

			wol.setStatus("Sending magic packet.");
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
		});
	});
}());

