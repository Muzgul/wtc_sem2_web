import { fetchPage } from './nav.js';
import snapJS from './snap.js';
import indexJS from './index.js';
import profileJS from './profile.js';
import signupJS from './signup.js';

export default function() {
    // JS for footer.php

    document.getElementById("profile").addEventListener("click", function (){
        var usr = fetchPage("../php/session.php");
        if (usr == ""){
            fetchPage("signup.html", '#content', signupJS);
        }else
            fetchPage('../php/profile.php', '#content', profileJS);
    });
    
    document.getElementById("feed").addEventListener("click", function (){
        fetchPage('../php/index.php', '#content', indexJS);
    });
    
    document.getElementById("cam").addEventListener("click", function (){
        fetchPage('../php/snap.php', '#content', snapJS);
    });
    document.getElementById("out").addEventListener("click", function (){
        fetchPage('../php/session.php?login=');
        fetchPage('../php/index.php', '#content', indexJS);
    });
}