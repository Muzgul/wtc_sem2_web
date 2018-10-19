import { fetchPage } from './nav.js';
import snapJS from './snap.js';

export default function() {
    // JS for index.php
    document.getElementById("btnPicture").addEventListener("click", function(){
        fetchPage('../php/snap.php', '#content', snapJS);
    });
}