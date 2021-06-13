let page = 1;
cargarTweets(page);

function cargarTweets(page){
    conexion=new XMLHttpRequest();
    conexion.addEventListener('readystatechange',callBack);
    conexion.open('GET',"http://christivn.es/api/exploreFeed.php?api_key="+getCookie("api_key")+"&page="+page);
    conexion.send();

    function callBack() {
        if(conexion.readyState == 4 && conexion.status == 200) {
            if(conexion.responseText.length>0){
                let data=JSON.parse(conexion.responseText);

                let spinner=document.getElementById("spinner").style.display="none";

                if(page!=1){
                    let ver_mas=document.getElementById("ver-mas").style.visibility="visible";
                }

                let lista=document.getElementById("lista-tweets");

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

                    let img="";
                    if(data[i].img_url.length!=0){
                        img=`<div id="`+data[i].tweet_id+`_img" class="imagen_tweet" style="background-color: #cccccc;width:90%;height:450px;margin-bottom:1rem;border-radius:5px;background-repeat: no-repeat;background-size: cover;"></div>`;
                    }

                    let fav_color="";
                    let fav_svg="";
                    if(data[i].you_fav){
                        fav_color="#e0245e";
                        fav_svg=`<svg class="fav_svg_`+data[i].tweet_id+`" style="fill:#E0245E;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"></path></g></svg>`;
                    } else {
                        fav_svg=`<svg class="fav_svg_`+data[i].tweet_id+`" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path></g></svg>`;
                    }


                    let rt_color="";
                    let rt_svg="";
                    if(data[i].you_rt){
                        rt_color="#17BF63";
                        rt_svg=`<svg class="rt_svg_`+data[i].tweet_id+`" style="fill:#17BF63;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"></path></g></svg>`;
                    } else {
                        rt_svg=`<svg class="rt_svg_`+data[i].tweet_id+`" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"></path></g></svg>`;
                    }


                    let tweet = `
                    <div class="tweet" id="`+data[i].tweet_id+`">
                        <div class="foto-perfil" onclick="window.location.href = 'profile?id=`+data[i].user_id+`';">
                            <img src="`+data[i].avatar_url+`">
                        </div>

                        <div class="contenido-tweet">
                            <span  onclick="window.location.href = 'profile?id=`+data[i].user_id+`';"><b>`+data[i].name_twitter+`</b> @`+data[i].nick+` ·  `+fecha_tweet+`</span>
                            <p style="margin-top:6px;">`+data[i].content+`</p>

                            `+img+`

                            <div>
                                <div id="comentarios" onclick="comments('`+data[i].tweet_id+`')">
                                    <svg viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"></path></g></svg>
                                    <span>`+data[i].comments+`</span>
                                </div>

                                <div id="rt" class="rt_click rt_`+data[i].you_rt+`" style="color:`+rt_color+`;" onclick="rt('`+data[i].tweet_id+`')">
                                    `+rt_svg+`
                                    <span class="rt_`+data[i].tweet_id+`">`+data[i].rt+`</span>
                                </div>

                                <div id="fav" class="fav_click fav_`+data[i].you_fav+`" style="color:`+fav_color+`;" onclick="fav('`+data[i].tweet_id+`')">
                                    `+fav_svg+`
                                    <span class="fav_`+data[i].tweet_id+`">`+data[i].fav+`</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    lista.innerHTML+=tweet;

                    if(img!=""){
                        document.getElementById(data[i].tweet_id+"_img").style.backgroundImage="url('"+data[i].img_url+"')";
                    }
                }
            } else {
                let ver_mas=document.getElementById("ver-mas").style.visibility="hidden";
            }
        }
    }
}


document.getElementById("ver-mas").addEventListener("click", function(){ page+=1; cargarTweets(page);}, false);
