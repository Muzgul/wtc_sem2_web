import { fetchPage } from './nav.js';
import snapJS from './snap.js';
import indexJS from './index.js';
import profileJS from './profile.js';

export default function() {
    // JS for footer.php
    
    document.getElementById("profile").addEventListener("click", function (){
        fetchPage('../php/profile.php', '#content', profileJS);
    });
    
    document.getElementById("feed").addEventListener("click", function (){
        fetchPage('../php/index.php', '#content', indexJS);
    });
    
    document.getElementById("cam").addEventListener("click", function (){
        fetchPage('../php/snap.php', '#content', snapJS);
    });
}