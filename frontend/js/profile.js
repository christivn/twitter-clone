let id = "";
if(findGetParameter("id")==null){
    id = getCookie("id");
} else {
    id = findGetParameter("id");
}

conexion=new XMLHttpRequest();
conexion.addEventListener('readystatechange',callBack);
conexion.open('GET',"http://127.0.0.1/backend/profile.php?api_key="+getCookie("api_key")+"&id="+id);
conexion.send();

function callBack() {
    if(conexion.readyState == 4 && conexion.status == 200) {
        let data=JSON.parse(conexion.responseText);

        if(data.code=="200"){
            document.getElementById("nav-nombre").textContent=data.name_twitter;
            document.getElementById("nav-foto-perfil").src=data.avatar_url;
            document.getElementById("nav-arroba").textContent="@"+data.nick;

            document.getElementById("nombre").textContent=data.name_twitter;
            document.getElementById("arroba").textContent="@"+data.nick;
            document.getElementById("bio").textContent=data.bio;
            document.getElementById("nombre-perfil").textContent=data.name_twitter;
            document.getElementById("foto-perfil").src=data.avatar_url;
            document.getElementById("banner").src=data.banner_url;

            document.getElementById("followers").textContent=data.followers;
            document.getElementById("following").textContent=data.following;

            let boton = document.getElementById("boton");
            if(data.edit){
                boton.textContent="Ajustes";
                boton.classList.remove('boton-secundario');
                boton.classList.add('boton-principal');
                boton.href="settings.html";
            } else {
                if(data.my_follow){
                    boton.textContent="Siguiendo";
                    boton.classList.remove('boton-secundario');
                    boton.classList.remove('seguir');
                    boton.classList.add('boton-principal');
                    boton.classList.add('siguiendo');
                }
            }
        }
    }
}



//=================================================================================================
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

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