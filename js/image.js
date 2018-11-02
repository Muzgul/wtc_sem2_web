
export default function() {
    // JS for image.php

    var creator = document.getElementById("image_creator").innerText;
    var id = document.getElementById("main_image").alt;

    var makeComment = function (){
        var comment = document.getElementById("comment_value").value;
        var list = document.getElementById("image_comments");
        if (comment){
            var li = document.createElement('li');
            li.innerText = comment + " - " + creator;
            list.appendChild(li);
            var request = new XMLHttpRequest();
            request.open("POST",'../php/misc.php', false);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    console.log(resp);
                }
            };
            request.send('category=comment&image=' + id + '&usrname=' + creator + '&value=' + comment);
        }
    };

    var makeLike = function(){
        var request = new XMLHttpRequest();
        request.open("POST",'../php/misc.php', false);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var resp = request.responseText;
                console.log(resp);
            }
        };
        request.send('category=like&image=' + id + '&usrname=' + creator + '&value=1');
    }
    document.getElementById("post_comment").addEventListener("click", makeComment);
    document.getElementById("post_like").addEventListener("click", makeLike);
}