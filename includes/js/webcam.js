(function () {
	const player = document.getElementById('player');
	const canvas = document.getElementById('canvas');
	const context = canvas.getContext('2d');
	const captureButton = document.getElementById('capture');
	const sendForm = document.getElementById('sendForm1');
	
	const constraints = {
		video: true,
	};
	//load sticker
	function loadFrame(frame) {
		console.log(frame);
		var xhr = new XMLHttpRequest(); // data is exchanged between front and back end without, in secret
		xhr.open('POST', 'upload.php', true)
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				// console.log(request.responseText);
				//navigate to the the frames folder and fetch the frame
				document.getElementById('frame-ajax').innerHTML = '<img id=frame-over src="includes/filter/frame' + frame + '.png" />';
			}
		});
		xhr.send(null);	
	}

	(function() {
    var inputs = document.getElementsByClassName('radio-frame'),//get the radio button// 1 ) click rdbutton
        inputsLen = inputs.length; //get the value of the  chosen radio button

	for (var i = 0; i < inputsLen; i++)
	{
		//load  the ith ( = inpustlength) frame
		inputs[i].addEventListener('click', function(){ loadFrame(this.value); } );    // 2 ) an event is fired
    }
	})();

	context.translate(canvas.width, 0);
	context.scale(-1, 1);

	captureButton.addEventListener('click', () => {
		// Draw the video frame to the canvas.
		canvas.style.display = "block";
		player.style.display = "none";
		sendForm.style.display = "block";
		captureButton.style.display = "none";
		document.getElementById('reload').style.display = "block";
		// document.getElementsByClassName('radio-frame').style.display = "none";
		context.drawImage(player, 0, 0, canvas.width, canvas.height);
	});
	
	// Attach the video stream to the video element and autoplay.
	navigator.mediaDevices.getUserMedia(constraints)
	.then((stream) => {
		player.srcObject = stream;
	});

	// console.log(sendForm);
  
	sendForm.addEventListener('click', function() {  // click, fire
		//replace png by octet-stream
		image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
		console.log(image);
		document.getElementById('hidden_data').value = image;
	})

})();
