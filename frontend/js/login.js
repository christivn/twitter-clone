
function login() {
    let errores = false;
    let error = document.getElementById("error-login");
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
    conexion=new XMLHttpRequest();
    conexion.addEventListener('readystatechange',callBackPeticion);
    conexion.open('GET',"http://127.0.0.1/backend/login.php?nick="+nick+"&pass="+pass);
    conexion.send();
}

function callBackPeticion() {
    if(conexion.readyState == 4 && conexion.status == 200) {
        let data=JSON.parse(conexion.responseText);
        console.log(data);

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