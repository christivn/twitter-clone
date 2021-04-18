conexion_nav=new XMLHttpRequest();
conexion_nav.addEventListener('readystatechange',callBackNav);
conexion_nav.open('GET',"http://127.0.0.1/backend/profile.php?api_key="+getCookie("api_key")+"&id="+getCookie("id"));
conexion_nav.send();

function callBackNav() {
    if(conexion_nav.readyState == 4 && conexion_nav.status == 200) {
        let data=JSON.parse(conexion_nav.responseText);
        document.getElementById("nav-nombre").textContent=data.name_twitter;
        document.getElementById("nav-foto-perfil").src=data.avatar_url;
        document.getElementById("nav-arroba").textContent="@"+data.nick;
    }
}

//=================================================================================================

  function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}