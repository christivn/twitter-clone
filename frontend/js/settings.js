
function guardarAjustes(){
    let avatar_url = document.getElementById("avatar").value;
    let banner_url = document.getElementById("banner").value;
    let name_twitter = document.getElementById("name").value;
    let bio = document.getElementById("bio").value;

    conexionSettings=new XMLHttpRequest();
    conexionSettings.addEventListener('readystatechange',callBackSettings);
    conexionSettings.open('GET',"http://127.0.0.1/backend/settings.php?api_key="+getCookie("api_key")+"&avatar_url="+avatar_url+"&banner_url="+banner_url+"&name="+name_twitter+"&bio="+bio);
    conexionSettings.send();

    function callBackSettings() {
        if(conexionSettings.readyState == 4 && conexionSettings.status == 200) {
            document.getElementById("guardar").style.display="none";
            document.getElementById("spinner").style.display="block";
        }
    }
}