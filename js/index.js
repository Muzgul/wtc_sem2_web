import { fetchPage } from './nav.js';
import imageJS from './image.js';

export default function() {
    // JS for index.php

    var images = document.getElementsByClassName("image");
    Array.from(images).forEach(element => {
        element.addEventListener("click", function(e){
            console.log(e.path[0].id);
            fetchPage('../php/image.php?image=' + e.path[0].id, "#content", imageJS);    
        });
    });
}