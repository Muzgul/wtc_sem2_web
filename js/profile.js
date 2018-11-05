
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
        if (input.type = "checkbox")
            request.send("method=update&table=user&field=" + input.id + "&value=" + (input.checked ? 1 : 0));
        else
            request.send("method=update&table=user&field=" + input.id + "&value=" + input.value);
    };
    for (let i = 0; i < inputs.length; i++) {
        const element = inputs[i];
        element.addEventListener("change", newValue , false);
    }
}