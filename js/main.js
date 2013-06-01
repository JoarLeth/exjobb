window.addEventListener('load', function () {
	var timing = {};
	var url = "/exjobb/results.php?json=true";
	var data = {};
	var isInt = function (value) { 
	    return !isNaN(parseInt(value,10)) && (parseFloat(value,10) == parseInt(value,10)); 
	}

	// Egenskaperna ligger på prototypen, så de kan inte serialiseras direkt.
	for (var p in performance.timing) {
		if (isInt(performance.timing[p])) {
		    timing[p] = performance.timing[p];
		}
	}

	data.user_agent = navigator.userAgent;
	data.experiment = "Originaldokument s02";
	data.timing = timing;

	json = JSON.stringify(data);

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url);
	xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	xhr.send(json);
}, false);