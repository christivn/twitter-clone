let page = 1;
cargarTweets(page);

function cargarTweets(page){
    conexion=new XMLHttpRequest();
    conexion.addEventListener('readystatechange',callBack);
    conexion.open('GET',"http://christivn.es/api/notificationFeed.php?api_key="+getCookie("api_key")+"&page="+page);
    conexion.send();

    function callBack() {
        if(conexion.readyState == 4 && conexion.status == 200) {
            if(conexion.responseText.length>0){
                let data=JSON.parse(conexion.responseText);
                console.log(data);

                let spinner=document.getElementById("spinner").style.display="none";

                if(page!=1){
                    let ver_mas=document.getElementById("ver-mas").style.visibility="visible";
                }

                let lista=document.getElementById("lista");

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

                    let avatar_img="img/default.png";
                    if(imageExists("http://christivn.es/api/img/"+data[i].user_id+"_avatar.jpg")){
                        avatar_img="http://christivn.es/api/img/"+data[i].user_id+"_avatar.jpg";
                    }


                    let tweet = "";

                    if(data[i].type=="fav"){
                        tweet = `
                        <div class="tweet" id="`+data[i].tweet_id+`">
                            <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                                <img src="`+avatar_img+`">
                            </div>
                
                            <div class="contenido-tweet">
                                <span onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                                <p style="margin-top:0px;color:#E0245E;font-weight: bold;">
                                    <svg style="fill:#E0245E;width:15px;" viewBox="0 0 24 24"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"></path></g></svg>
                                    Ha `+data[i].name_twitter+` le ha gustado tu tweet: <span style="color:black;font-weight: normal;"><a href="tweet?tweet_id=`+data[i].tweet_id+`">Ver tweet</a></span>
                                </p>
                            </div>
                        </div>
                        `;
                    }

                    if(data[i].type=="rt"){
                        tweet = `
                        <div class="tweet" id="`+data[i].tweet_id+`">
                            <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                                <img src="`+avatar_img+`">
                            </div>
                
                            <div class="contenido-tweet">
                                <span onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                                <p style="margin-top:0px;color:#55CE8C;font-weight: bold;">
                                    <svg style="fill:#55CE8C;width:16px;" viewBox="0 0 24 24"><g><path d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"></path></g></svg>
                                    Ha `+data[i].name_twitter+` ha dado rt tu tweet: <span style="color:black;font-weight: normal;"><a href="tweet?tweet_id=`+data[i].tweet_id+`">Ver tweet</a></span>
                                </p>
                            </div>
                        </div>
                        `;
                    }

                    if(data[i].type=="comment"){
                        tweet = `
                        <div class="tweet" id="`+data[i].tweet_id+`">
                            <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                                <img src="`+avatar_img+`">
                            </div>
                
                            <div class="contenido-tweet">
                                <span onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                                <p style="margin-top:0px;color:#2FA9F3;font-weight: bold;">
                                    <svg style="fill:#2FA9F3;width:15px;" viewBox="0 0 24 24"><g><path d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"></path></g></svg>
                                    Ha `+data[i].name_twitter+` ha comentado en tu tweet: <span style="color:black;font-weight: normal;"><a href="tweet?tweet_id=`+data[i].tweet_id+`">Ver tweet</a></span>
                                </p>
                            </div>
                        </div>
                        `;
                    }

                    if(data[i].type=="follow"){
                        tweet = `
                        <div class="tweet">
                            <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                                <img src="`+avatar_img+`">
                            </div>
                
                            <div class="contenido-tweet">
                                <span onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                                <p style="margin-top:0px;color:#b400ff;font-weight: bold;">
                                    <svg style="fill:#b400ff;width:15px;" viewBox="0 0 24 24"><g><path d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z"></path></g></svg>
                                    Ha `+data[i].name_twitter+` ha empezado a seguirte <span style="color:black;font-weight: normal;"></span>
                                </p>
                            </div>
                        </div>
                        `;
                    }

                    lista.innerHTML+=tweet;
                }
            } else {
                let ver_mas=document.getElementById("ver-mas").style.visibility="hidden";
            }
        }
    }
}


document.getElementById("ver-mas").addEventListener("click", function(){ page+=1; cargarTweets(page);}, false);
