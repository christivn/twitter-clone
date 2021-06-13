let page = 1;
cargarComentarios(page);

function cargarComentarios(page){
    conexionComentarios=new XMLHttpRequest();
    conexionComentarios.addEventListener('readystatechange',callBackComentarios);
    conexionComentarios.open('GET',"http://christivn.es/api/tweetComments.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id+"&page="+page);
    conexionComentarios.send();


    function callBackComentarios() {
        if(conexionComentarios.readyState==4 && conexionComentarios.status==200) {
            if(conexionComentarios.responseText.length>0){
                let data=JSON.parse(conexionComentarios.responseText);

                let spinner=document.getElementById("spinner2").style.display="none";

                if(page!=1){
                    let ver_mas=document.getElementById("ver-mas").style.visibility="visible";
                }

                let lista=document.getElementById("lista-comentarios");

                for(let i=0;i<data.length;i++){

                    let date = data[i].date;
                    let partes_date = date.split(" ");
                    let fecha = partes_date[0].split("-");
                    let hora = partes_date[1].split(":");

                    let date_tweet = new Date(fecha[0]+"-"+fecha[1]+"-"+fecha[2]+" "+hora[0]+":"+hora[1]+":"+hora[2]);
                    var ahora = Date.now();
                    let segundos = Math.round((ahora - date_tweet.getTime()) / 1000);

                    let fecha_tweet = "";
                    if(segundos<60){
                        fecha_tweet=segundos+" segundos";
                    } else {
                        let minutos=Math.round(segundos/60);
                        if(minutos<60){
                            if(minutos==1){
                                fecha_tweet=minutos+" minuto";
                            } else {
                                fecha_tweet=minutos+" minutos";
                            }
                        } else {
                            let horas=Math.round(minutos/60);
                            if(horas<24){
                                if(horas==1){
                                    fecha_tweet=horas+" hora";
                                } else {
                                    fecha_tweet=horas+" horas";
                                }
                            } else {
                                let dias=Math.round(horas/24);
                                if(dias==1){
                                    fecha_tweet=dias+" dia";
                                } else {
                                    fecha_tweet=dias+" dias";
                                }
                            }
                        }
                    }

                    let avatar_img="/img/default.png";
                    if(imageExists("http://christivn.es/api/img/"+data[i].user_id+"_avatar.jpg")){
                        avatar_img="http://christivn.es/api/img/"+data[i].user_id+"_avatar.jpg";
                    }

                    let tweet = `
                    <div class="tweet">
                        <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                            <img src="`+avatar_img+`">
                        </div>

                        <div class="contenido-tweet">
                            <span  onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                            <p style="margin-top:6px;">`+data[i].content+`</p>
                        </div>
                    </div>
                    `;
                    lista.innerHTML+=tweet;

                }
            } else {
                document.getElementById("ver-mas").style.visibility="hidden";
                document.getElementById("spinner2").style.display="none";
            }
        }
    }
}

document.getElementById("ver-mas").addEventListener("click", function(){ page+=1; cargarComentarios(page);}, false);


//===========================================================================================================================================

let input = document.getElementById("comentario");

input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      
      conexionEscribirComentario=new XMLHttpRequest();
      conexionEscribirComentario.addEventListener('readystatechange',callBackEscribirComentario);
      conexionEscribirComentario.open('GET',"http://christivn.es/api/comment.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id+"&content="+input.value);
      conexionEscribirComentario.send();

      function callBackEscribirComentario() {
        if(conexionEscribirComentario.readyState == 4 && conexionEscribirComentario.status == 200) {
            location.reload();
        }
      }

    }
});


//===================================================================================

function imageExists(image_url){
    var http = new XMLHttpRequest();
    http.open('HEAD', image_url, false);
    http.send();
    return http.status != 404;
}
