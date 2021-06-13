conexionUsers=new XMLHttpRequest();
conexionUsers.addEventListener('readystatechange',callBackRandomUsers);
conexionUsers.open('GET',"http://christivn.es/api/randomUsers.php?api_key="+getCookie("api_key"));
conexionUsers.send();

function callBackRandomUsers() {
    if(conexionUsers.readyState == 4 && conexionUsers.status == 200) {
        let data=JSON.parse(conexionUsers.responseText);

        let contenido = document.getElementsByClassName("contenido");
        for(let i=0;i<contenido.length;i++){
            if(data[i]!==undefined){
                let x=data[i];
                contenido[i].getElementsByClassName("foto-perfil")[0].src=x.avatar_url;
                contenido[i].getElementsByClassName("nombre")[0].textContent=x.name_twitter;
                contenido[i].getElementsByClassName("arroba")[0].textContent="@"+x.nick;

                contenido[i].addEventListener('click', function (event) {
                    window.location.href = "profile?id="+x.id;
                }, false);
            }
        }
    }
}
