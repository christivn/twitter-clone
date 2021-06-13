let page = 1;
cargarSeguidores(page);

function cargarSeguidores(page){
    conexionSeguidores=new XMLHttpRequest();
    conexionSeguidores.addEventListener('readystatechange',callBackSeguidores);
    conexionSeguidores.open('GET',"http://christivn.es/api/followings.php?api_key="+getCookie("api_key")+"&id="+findGetParameter("id")+"&page="+page);
    conexionSeguidores.send();

    function callBackSeguidores() {
        if(conexionSeguidores.readyState == 4 && conexionSeguidores.status == 200) {
            if(conexionSeguidores.responseText.length>0){
                let data=JSON.parse(conexionSeguidores.responseText);

                let spinner=document.getElementById("spinner").style.display="none";
                
                if(page!=1){
                    let ver_mas=document.getElementById("ver-mas").style.visibility="visible";
                }

                let lista = document.getElementById("lista-seguidores");

                for(let i=0;i<data.length;i++){
                    let avatar_img="img/default.png";
                    if(imageExists("http://christivn.es/api/img/"+data[i].id+"_avatar.jpg")){
                        avatar_img="http://christivn.es/api/img/"+data[i].id+"_avatar.jpg";
                    }

                    let tweet = `
                    <div class="tweet" id="`+data[i].id+`">
                        <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].id+`'">
                            <img src="`+avatar_img+`">
                        </div>

                        <div class="contenido-tweet" style="padding-top: 1.5%;">
                            <span style="font-size:17px;" onclick="window.location.href = 'profile?id=`+data[i].id+`'"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+`</span>
                            <a id="boton" onclick="window.location.href = 'profile?id=`+data[i].id+`'" style="cursor: pointer;width: 15%;float: right;margin-top:-15px;font-size: 15px;" class="boton-secundario seguir">Ver perfil</a>
                        </div>
                    </div>
                    `;
                    lista.innerHTML+=tweet;
                }

            } else {
                document.getElementById("ver-mas").style.visibility="hidden";
                document.getElementById("spinner").style.display="none";

                let lista = document.getElementById("lista-seguidores");
                if(lista.innerHTML==""){
                    lista.innerHTML+="<center style='margin-top:20px;'>Este usuario no sigue a nadie</center>";
                }
            }
        }
    }
}

document.getElementById("ver-mas").addEventListener("click", function(){ page+=1; cargarSeguidores(page);}, false);


//==============================================================================================================
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

function imageExists(image_url){
    var http = new XMLHttpRequest();
    http.open('HEAD', image_url, false);
    http.send();
    return http.status != 404;
}