
if(imageExists("/backend/img/"+getCookie("id")+"_avatar.jpg")){
    document.getElementById("foto-tweet").src="/backend/img/"+getCookie("id")+"_avatar.jpg";
}

document.getElementById("twittear").addEventListener("click", tweet, false);
document.getElementById("boton-imagen").addEventListener("click", mostarInput, false);


function tweet(){
    let content = document.getElementById("tweet").value;
    let img = document.getElementById("tweet_img").value;

    if(content.length>=1){
        conexionTweetear=new XMLHttpRequest();
        conexionTweetear.addEventListener('readystatechange',callBackTweetear);
        conexionTweetear.open('GET',"http://127.0.0.1/backend/tweet.php?api_key="+getCookie("api_key")+"&content="+content+"&img_url="+img);
        conexionTweetear.send();

        function callBackTweetear() {
            if(conexionTweetear.readyState == 4 && conexionTweetear.status == 200) {
                location.reload();
            }
        }
    }
}


function mostarInput(){
    document.getElementById("tweet_img").style.display="";
}

//=====================================================================================

function imageExists(image_url){
    var http = new XMLHttpRequest();
    http.open('HEAD', image_url, false);
    http.send();
    return http.status != 404;
}
