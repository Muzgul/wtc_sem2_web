
export default function() {
    // JS for profile.php
    var inputs = document.getElementsByTagName("input");
    var newValue = function (element){
        const input = element.srcElement;
        console.log(input.value);
        console.log(input.id);
        var request = new XMLHttpRequest();
        request.open('POST', '../php/upload.php', true);    
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var resp = request.responseText;
                console.log(resp);
            }
        };
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("method=update&table=user&field=" + input.id + "&value=" + input.value);
    };
    for (let i = 0; i < inputs.length; i++) {
        const element = inputs[i];
        element.addEventListener("change", newValue , false);
    }
}