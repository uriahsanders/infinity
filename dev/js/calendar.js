//Setting Variables(commented out for now)
/*
function selectMonth(){
    if (date(year) = January){
        var x = 0;
        return;
    }
    else if (date(year) = February){
        var x = 1;
        return;
    }
    else if (date(year) = March){
        var x = 2;
        return;
    }
    else if (date(year) = April){
        var x = 3;
        return;
    }
    else if (date(year) = May){
        var x = 4;
        return;
    }
    else if (date(year) = June){
        var x = 5;
        return;
    }
    else if (date(year) = July){
        var x = 6;
        return;
    }
    else if (date(year) = August){
        var x = 7;
        return;
    }
    else if (date(year) = September){
        var x = 8;
        return;
    }
    else if (date(year) = October){
        var x = 9;
        return;
    }
    else if (date(year) = November){
        var x = 10;
        return;
    }
    else {
        var x = 11;
        return;
    }
}
*/
//Setting Current Variable
var x = 0;
//Right Arrow
function moveRight(){
    var x = 0;
    if (x == 11){
        break;
    }
    else{
        x++;
        return x;
        push();
    }
}
//Left Arrow
function moveLeft(){
    var x = 0;
    if (x == 0){
        break;
    }
    else{
        x--;
        return x;
        push();
    }
}
//Prerequisites
function push(){
if (x == 0){
    getJanuary();
}
else if (x == 1){
    getFebruary();
}
else if (x == 2){
    getMarch();
}
else if (x == 3){
    getApril();
}
else if (x == 4){
    getMay();
}
else if (x == 5){
    getJune();
}
else if (x == 6){
    getJuly();
}
else if (x == 7){
    getAugust();
}
else if (x == 8){
    getSeptember();
}
else if (x == 9){
    getOctober();
}
else if (x == 10){
    getNovember();
}
else{
    getDecember();
}
}
//AJAX for the Months
function getJanuary(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_january.txt",true);
    xmlhttp.send();
}
function getFebruary(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_february.txt",true);
    xmlhttp.send();
}
function getMarch(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_march.txt",true);
    xmlhttp.send();
}
function getApril(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_april.txt",true);
    xmlhttp.send();
}
function getMay(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_may.txt",true);
    xmlhttp.send();
}
function getJune(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_june.txt",true);
    xmlhttp.send();
}
function getJuly(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_july.txt",true);
    xmlhttp.send();
}
function getAugust(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_august.txt",true);
    xmlhttp.send();
}
function getSeptember(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_september.txt",true);
    xmlhttp.send();
}
function getOctober(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_october.txt",true);
    xmlhttp.send();
}
function getNovember(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_november.txt",true);
    xmlhttp.send();
}
function getDecember(){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("ncalendar").innerHTML=xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET","../ajax_calendar/ajax_december.txt",true);
    xmlhttp.send();
}












