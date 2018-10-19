function fetchPage(page, id = null, callback = function(){}){
    var request = new XMLHttpRequest();
    if (id != null)
        request.open('GET', page, true);
    else
        request.open('GET', page, false);

    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = request.responseText;
            if (id != null)
                document.querySelector(id).innerHTML = resp;
            callback ();
        }
    };
    request.send();
    if (id == null)
        return request.responseText;
}

export { fetchPage };