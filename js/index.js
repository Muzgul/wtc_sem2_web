import { fetchPage } from './nav.js';
import imageJS from './image.js';

export default function() {
    // JS for index.php
    var pages = document.getElementsByClassName("page");
    var page_num = 0;
    var page_max = Array.from(pages).length;
    var images = document.getElementsByClassName("image");
    Array.from(images).forEach(element => {
        element.addEventListener("click", function(e){
            fetchPage('../php/image.php?image=' + element.firstChild.id, "#content", imageJS);    
        });
    });

    var hideAll = function(current){
        Array.from(pages).forEach(element => {
            element.style.display = "none";
        });
        Array.from(pages)[page_num].style.display = "inline-block";
    }
    var nextPage = function(e) {
        page_num++;
        if (page_num > page_max - 1)
            page_num = page_max - 1;
        hideAll(page_num);
    };
    var prevPage = function() {
        page_num--;
        if (page_num < 0)
            page_num = 0;
        hideAll(page_num);
    };
    if (pages.length > 0){
        hideAll(page_num);
        document.getElementById("page_next").addEventListener("click", nextPage);
        document.getElementById("page_prev").addEventListener("click", prevPage);
    }
}