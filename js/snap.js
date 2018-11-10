import { fetchPage } from './nav.js';
import signupJS from'./signup.js';

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

    var canvas = document.createElement("canvas");
    var btnSave = document.getElementById("btnSave");
    var btnCapture = document.getElementById("btnCapture");

    var capture = function() {
        canvas.width = video.offsetWidth;
        canvas.height = video.offsetHeight;
        canvas.getContext('2d')
              .drawImage(video, 0, 0, canvas.width, canvas.height);

        video.pause();
        video.poster = canvas.toDataURL();

        var image = canvas.toDataURL("image/png");
        var request = new XMLHttpRequest();
        request.open("POST",'../php/save.php', false);
        request.setRequestHeader('Content-Type', 'application/upload');
        request.send(image);
        btnSave.hidden = false;
        btnCapture.hidden = true;
    };

    var reset = function(){
        var video = document.querySelector("#videoElement");
        video.play();
        document.getElementById("cover").src = "";
        document.getElementById("cover").style.left = 0 + "px";
        document.getElementById("cover").style.top = 0 + "px";
        btnCapture.hidden = false;
        btnSave.hidden = true;
    };

    var save = function(){
        var is_logged = fetchPage("../php/session.php");
        if (!is_logged)
            fetchPage("../html/signup.html", '#content', signupJS);
        else{
            var image = document.getElementById("cover");
            var name = document.getElementById("img_name").value;
            var request = new XMLHttpRequest();
            request.open("POST",'../php/save.php', false);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    var ret = JSON.parse(resp);
                    openModal(ret);
                    reset();
                }
            };
            request.send("submit=create&image=" + image.src + "&name=" + name + "&offx=" + image.style.left + "&offy=" + image.style.top);
        }
        reset();
    };
    
    reset();
    document.getElementById("btnReset").addEventListener("click", reset);
    document.getElementById("btnCapture").addEventListener("click", capture);
    document.getElementById("btnSave").addEventListener("click", save);

    var overlay = document.getElementsByClassName("overlay");
    
    Array.from(overlay).forEach(element => {
        element.addEventListener("click", function(e){
            var targ = e.target ? e.target : e.srcElement;
            document.getElementById("cover").src = targ.src;
        });
    });

    var drag = false;
    var offsetX, offsetY, coordX, coordY;
    var container = document.getElementById("snap-container");
    var dragStart = function (e){
        console.log("mousedown");
        drag = true;
        // container = document.getElementById("videoElement");

        var targ = e.target ? e.target : e.srcElement;
        if (targ.className != "draggable")
            return false;
        e.preventDefault();
        if (!targ.style.left)
            targ.style.left = "0px";
        if (!targ.style.top)
            targ.style.top = "0px";
        
        offsetX = e.clientX;
        offsetY = e.clientY;
        coordX = parseInt(targ.style.left);
        coordY = parseInt(targ.style.top);
        
        document.onmousemove = dragBusy;
    }

    var dragEnd = function (e){
        console.log("mouseup");
        drag = false;
        document.onmousemove = {};
    }

    var dragBusy = function (e){
        if (!e)
            e = window.event;
        var targ = e.target ? e.target : e.srcElement;
        if (!drag || targ.className != "draggable")
            return false;
        e.preventDefault();
        var newX = coordX + e.clientX - offsetX;
        var newY = coordY + e.clientY - offsetY;
        newX = newX > 0 ? newX : 0;
        newY = newY > 0 ? newY : 0;
        newX = newX <= container.offsetWidth - targ.offsetWidth ? newX : container.offsetWidth - targ.offsetWidth;
        newY = newY <= container.offsetHeight - targ.offsetHeight ? newY : container.offsetHeight - targ.offsetHeight;
        targ.style.left = newX + 'px';
        targ.style.top = newY + 'px';
        return false;
    }

    document.getElementById("cover").addEventListener("mousedown", dragStart);
    document.getElementById("cover").addEventListener("mouseup", dragEnd);

    var modal = document.getElementById('myModal');
    var modalContent = document.getElementById('modal-content');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal 
    var openModal = function(ret) {
        console.log(ret.url);
        var img = document.getElementById("modalImg");
        img.src = ret.url;
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}