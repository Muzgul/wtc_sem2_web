import indexJS from "./index.js";
import adminJS from "./admin.js";
import footerJS from "./footer.js";
import { fetchPage } from "./nav.js";

    // Preprocess
    
    fetchPage('../php/structure/header.php', '#header');
    fetchPage('../php/structure/footer.php', '#footer', footerJS);

    var user = fetchPage('../php/session.php');
    if (user == "admin"){
        // Load admin page
        fetchPage('../php/admin.php', '#content', adminJS);
    }
    if (user == "" || user == null){
        // Load guest page
        fetchPage('../php/index.php', '#content', indexJS);
    }else{
        // Load normal page
        fetchPage('../php/index.php', '#content', indexJS);
    }
