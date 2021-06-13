conexionSettingsLoad=new XMLHttpRequest();
conexionSettingsLoad.addEventListener('readystatechange',callBackSettingsLoad);
conexionSettingsLoad.open('GET',"http://christivn.es/api/settingsLoad.php?api_key="+getCookie("api_key"));
conexionSettingsLoad.send();

function callBackSettingsLoad() {
    if(conexionSettingsLoad.readyState == 4 && conexionSettingsLoad.status == 200) {
        if(conexionSettingsLoad.responseText.length>0){
            let data=JSON.parse(conexionSettingsLoad.responseText);

            document.getElementById("avatar").value=data[0].avatar_url;
            document.getElementById("banner").value=data[0].banner_url;
            document.getElementById("name").value=data[0].name_twitter;
            document.getElementById("nick").value="@"+data[0].nick;
            
            document.getElementById("bio").placeholder="";
            document.getElementById("bio").value=data[0].bio;
        }
    }
}