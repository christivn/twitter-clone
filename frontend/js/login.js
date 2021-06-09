let error = document.getElementById("error-login");

function login() {
    let errores = false;
    error.textContent = "";

    let usuario = document.getElementById("login-usuario").value;
    let pass = document.getElementById("login-pass").value;

    if(usuario.length==0){
        error.innerHTML += "* El usuario no es válido<br>";
        errores = true;
    }

    if(pass.length==0){
        error.innerHTML += "* La contraseña no es válida<br>";
        errores = true;
    }

    if(errores==false){
        peticionLogin(usuario,pass);
    }
}


function peticionLogin(nick,pass){
    conexion_login=new XMLHttpRequest();
    conexion_login.addEventListener('readystatechange',callBackPeticionLogin);
    conexion_login.open('GET',"http://127.0.0.1/backend/login.php?nick="+nick+"&pass="+pass);
    conexion_login.send();
}

function callBackPeticionLogin() {
    if(conexion_login.readyState == 4 && conexion_login.status == 200) {
        let data=JSON.parse(conexion_login.responseText);

        if(data.code=="200"){
            setCookie("id",data.id,9999);
            setCookie("api_key",data.api_key,9999);
            window.location.href = "feed.html";
        } else {
            error.innerHTML += "* Usuario y contraseña incorrectos<br>";
        }
    }
}


//======================================================================================================

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


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