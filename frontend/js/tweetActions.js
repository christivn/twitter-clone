
function fav(tweet_id){
    let tweet = document.getElementById(tweet_id);
    let count = tweet.getElementsByClassName("fav_"+tweet_id)[0];
    let svg = tweet.getElementsByClassName("fav_svg_"+tweet_id)[0];

    let fav_false = tweet.getElementsByClassName("fav_false")[0];
    let fav = tweet.getElementsByClassName("fav_click")[0];

    if(fav_false){
        let num = parseInt(count.textContent)+1;

        conexion_fav=new XMLHttpRequest();
        conexion_fav.addEventListener('readystatechange',callBackFav);
        conexion_fav.open('GET',"http://127.0.0.1/backend/fav.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id);
        conexion_fav.send();

        function callBackFav(){
            if(conexion.readyState == 4 && conexion.status == 200) {
                count.innerHTML=`<span id="fav_`+tweet_id+`" style="color:#e0245e;">`+num+`</span>`;
                svg.innerHTML=`<svg id="fav_svg_`+tweet_id+`" style="fill:#E0245E;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"></path></g></svg>`;
                fav.classList.remove("fav_false");
                fav.classList.add("fav_true");
            }
        }

    } else {
        let num = parseInt(count.textContent)-1;

        conexion_fav=new XMLHttpRequest();
        conexion_fav.addEventListener('readystatechange',callBackFav);
        conexion_fav.open('GET',"http://127.0.0.1/backend/fav_remove.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id);
        conexion_fav.send();

        function callBackFav(){
            if(conexion_fav.readyState == 4 && conexion_fav.status == 200) {
                count.innerHTML=`<span id="fav_`+tweet_id+`" style="color:#5B7083;">`+num+`</span>`;
                svg.innerHTML=`<svg id="fav_svg_`+tweet_id+`" style="fill:#5B7083;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path></g></svg>`;
                fav.classList.remove("fav_true");
                fav.classList.add("fav_false");
            }
        }
    }
}


function rt(tweet_id){
    let tweet = document.getElementById(tweet_id);
    let count = tweet.getElementsByClassName("rt_"+tweet_id)[0];
    let svg = tweet.getElementsByClassName("rt_svg_"+tweet_id)[0];

    let rt_false = tweet.getElementsByClassName("rt_false")[0];
    let rt = tweet.getElementsByClassName("rt_click")[0];

    if(rt_false){
        let num = parseInt(count.textContent)+1;

        conexion_rt=new XMLHttpRequest();
        conexion_rt.addEventListener('readystatechange',callBackRt);
        conexion_rt.open('GET',"http://127.0.0.1/backend/rt.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id);
        conexion_rt.send();

        function callBackRt(){
            if(conexion_rt.readyState == 4 && conexion_rt.status == 200) {
                count.innerHTML=`<span id="rt_`+tweet_id+`" style="color:#17BF63;">`+num+`</span>`;
                svg.innerHTML=`<svg id="rt_svg_`+tweet_id+`" style="fill:#17BF63;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"></path></g></svg>`;
                rt.classList.remove("rt_false");
                rt.classList.add("rt_true");
            }
        }

    } else {
        let num = parseInt(count.textContent)-1;

        conexion_rt=new XMLHttpRequest();
        conexion_rt.addEventListener('readystatechange',callBackRt);
        conexion_rt.open('GET',"http://127.0.0.1/backend/rt_remove.php?api_key="+getCookie("api_key")+"&tweet_id="+tweet_id);
        conexion_rt.send();

        function callBackRt(){
            if(conexion_rt.readyState == 4 && conexion_rt.status == 200) {
                count.innerHTML=`<span id="rt_`+tweet_id+`" style="color:#5B7083;">`+num+`</span>`;
                svg.innerHTML=`<svg id="rt_svg_`+tweet_id+`" style="fill:#5B7083;" viewBox="0 0 24 24" class="r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1hdv0qi"><g><path d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"></path></g></svg>`;
                rt.classList.remove("rt_true");
                rt.classList.add("rt_false");
            }
        }

    }
}


function comments(tweet_id){
    window.location.href = "tweet.html?tweet_id="+tweet_id;
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