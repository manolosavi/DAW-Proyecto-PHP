function checkAvailability() {
    input = document.getElementsByName("user")[0];
    value = input.value;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.responseText != "valid") {
                document.getElementById("response").innerHTML = xmlhttp.responseText;
            }
            else{
                document.getElementsById("response").innerHTML = "";
            }
        }
    };
    xmlhttp.open("GET", "controller.php?username="  +  value, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();

}