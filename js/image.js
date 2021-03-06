import { fetchPage } from './nav.js';
import signupJS from'./signup.js';
import indexJS from './index.js';

export default function() {
    // JS for image.php

    var creator = document.getElementById("image_creator").innerText;
    var id = document.getElementById("main_image").alt;
    var user = fetchPage("../php/session.php");

    var makeComment = function (){
        var comment = document.getElementById("comment_value").value;
        var list = document.getElementById("image_comments");
        if (comment){
            var li = document.createElement('li');
            li.innerText = comment + " - " + creator;
            list.prepend(li);
            var request = new XMLHttpRequest();
            request.open("POST",'../php/misc.php', false);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    console.log(resp);
                }
            };
            request.send('category=comment&image=' + id + '&usrname=' + user + '&value=' + comment + '&creator=' + creator);
        }
    };

    var makeLike = function(){
        var likes = document.getElementById("likes_count");
        var who_liked = document.getElementById("likes_tooltip_text");
        var who_liked_text = who_liked.innerHTML;
        if (!who_liked_text.includes(user)){
            who_liked.innerHTML = user + ", " + who_liked_text;
            likes.innerText = parseInt(likes.innerText) + 1;
            
            var request = new XMLHttpRequest();
            request.open("POST",'../php/misc.php', false);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    console.log(resp);
                }
            };
            request.send('category=like&image=' + id + '&usrname=' + user + '&value=1&creator=' + creator);
        }
    }

    var deleteImg = function (){
        if (confirm("Are you sure you want to delete this image?")){
            var request = new XMLHttpRequest();
            request.open("POST",'../php/misc.php', false);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    fetchPage("../php/index.php", "#content", indexJS);
                }
            };
            request.send('method=delete&image=' + id);
        }
    };

    if (user){
        document.getElementById("post_comment").addEventListener("click", makeComment);
        document.getElementById("post_like").addEventListener("click", makeLike);
        if (user == creator)
            document.getElementById("delete_img").addEventListener("click", deleteImg);
    }else{
        document.getElementById("post_comment").addEventListener("click", function(){
            fetchPage("../html/signup.html", '#content', signupJS);
        });
        document.getElementById("post_like").addEventListener("click", function(){
            fetchPage("../html/signup.html", '#content', signupJS);
        });
    }
}