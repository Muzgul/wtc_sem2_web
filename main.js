import indexJS from "./js/index.js";
import adminJS from "./js/admin.js";
import { fetchPage } from "./js/nav.js";

    // Preprocess
    
    fetchPage('php/structure/header.php', '#header');
    fetchPage('php/structure/footer.php', '#footer');

    var user = fetchPage('php/session.php');
    if (user == "admin"){
        // Load admin page
        fetchPage('/php/admin.php', '#content', adminJS);
    }
    if (user == "" || user == null){
        // Load guest page
        // alert("No login!");
        fetchPage('/php/index.php', '#content', indexJS);
    }else{
        // Load normal page
        fetchPage('/php/index.php', '#content', indexJS);
    }
