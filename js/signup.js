
export default function (){
    document.getElementById("signup").addEventListener("submit", function(e){
        // Preprocess
            e.preventDefault();
            var form = document.getElementById("signup");
            form = new FormData(form);
            form.append('submit', 'Signup');
        // Verification of Info
            var isValid = true;
            var whyValid = "";
            if (form.get('passwd') != form.get('passwd_conf')){
                isValid = false;
                whyValid += "Passwords don't match!\n";
            }
            var regex = new RegExp("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$");
            if (!regex.test(form.get('passwd'))){
                isValid = false;
                whyValid += "Password must contain 1 Uppercase, 1 Lowercase and 1 Digit!\n";
            }
        // Submit
            if ( isValid ){
                document.getElementById("alert").innerText = "";
                var request = new XMLHttpRequest();
                request.open("POST", "../php/verif.php");
                request.onload = function (){
                    if (request.status >= 200 && request.status < 400){
                        document.getElementById("content").innerHTML = request.responseText;
                    }
                };
                request.send(form);
            }else
                document.getElementById("alert").innerText = whyValid;
    });

    document.getElementById("login").addEventListener("submit", function(e){
        // Preprocess
            e.preventDefault();
            var form = document.getElementById("login");
            form = new FormData(form);
            form.append('submit', 'Login');
        // Verification of Info
            var isValid = true;
        // Submit
            if ( isValid ){
                var request = new XMLHttpRequest();
                if (form.get('verif') == null)
                    request.open("POST", "../php/auth.php");
                else
                    request.open("POST", "../php/verif.php");
                request.onload = function (){
                    if (request.status >= 200 && request.status < 400){
                        document.getElementById("content").innerHTML = request.responseText;
                    }
                };
                request.send(form);
            }
    });

    document.getElementById("reset").addEventListener("submit", function(e){
        // Preprocess
            e.preventDefault();
            var form = document.getElementById("reset");
            form = new FormData(form);
            form.append('submit', 'sendReset');
        // Verification of Info
            var isValid = true;
        // Submit
            if ( isValid ){
                var request = new XMLHttpRequest();
                request.open("POST", "../php/auth.php");
                request.onload = function (){
                    if (request.status >= 200 && request.status < 400){
                        document.getElementById("content").innerHTML = request.responseText;
                    }
                };
                request.send(form);
            }
    });
}