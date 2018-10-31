export default function(){

    var video = document.querySelector("#videoElement");
    if (navigator.mediaDevices.getUserMedia) {   
        navigator.mediaDevices.getUserMedia({video: true})
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err0r) {
                console.log("Something went wrong!" + err0r);
            });
    }

    document.getElementById("btnCapture").addEventListener("click", function() {
        var canvas = document.createElement("canvas");
        var video = document.querySelector("#videoElement");
        canvas.width = video.videoWidth * 0.5;
        canvas.height = video.videoHeight * 0.5;
        canvas.getContext('2d')
              .drawImage(video, 0, 0, canvas.width, canvas.height);
 
        var img = document.getElementById("snap");
        img.src = canvas.toDataURL("image/png");
        video.pause();
        video.poster = canvas.toDataURL();

        var image = canvas.toDataURL("image/png");
        var ajax = new XMLHttpRequest();
        ajax.open("POST",'../php/save.php', false);
        ajax.setRequestHeader('Content-Type', 'application/upload');

        ajax.send(image);
    });

    document.getElementById("btnReset").addEventListener("click", function(){
        var video = document.querySelector("#videoElement");
        video.play();
    });

    // document.getElementById("btnSave").addEventListener("click", function(){
    //     var img = document.getElementById("snap");
    //     var image = img.toDataURL("image/png");
    //     var ajax = new XMLHttpRequest();
    //     ajax.open("POST",'../php/save.php', false);
    //     ajax.setRequestHeader('Content-Type', 'application/upload');
    //     ajax.onload = function() {
    //         if (ajax.status >= 200 && ajax.status < 400) {
    //             var resp = ajax.responseText;
    //             alert(resp);
    //         }
    //     };
    //     ajax.send(image);
    // });

    var overlay = document.getElementsByClassName("overlay");

    Array.from(overlay).forEach(element => {
        element.addEventListener("click", function(element){
            document.getElementById("cover").src = element.target.src;
        });
    });
}