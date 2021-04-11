let nick = "";
let password = "";

function register() {
    let errores = false;
    let error = document.getElementById("error");
    error.textContent = "";

    let usuario = document.getElementById("usuario").value;
    let bio = document.getElementById("bio").value;
    let pass = document.getElementById("pass").value;
    let repass = document.getElementById("repass").value;

    if((usuario.length<3 || usuario.length>15) && alphanumeric(usuario)==false){
        error.innerHTML += "* El nick no es válido<br>";
        errores = true;
    }

    if(bio.length>150){
        error.innerHTML += "* La biográfia debe de tener menos de 150 caracteres<br>";
        errores = true;
    }

    if(pass.length<3){
        error.innerHTML += "* La contraseña no es válida<br>";
        errores = true;
    }

    if(pass.length>9){
        error.innerHTML += "* La contraseña no es válida<br>";
        errores = true;
    }

    if(pass!=repass){
        error.innerHTML += "* Las contraseñas no coinciden<br>";
        errores = true;
    }

    if(errores==false){
        peticionRegistro(usuario,pass,bio,"");
    }
}



function peticionRegistro(usuario,pass,bio,nameic) {
    nick=usuario;
    password=pass;

    conexion=new XMLHttpRequest();
    conexion.addEventListener('readystatechange',callBackPeticionRegistro);
    conexion.open('POST',"http://127.0.0.1/backend/register.php?nick="+usuario+"&pass="+pass+"&bio="+bio+"&nameic="+nameic);
    conexion.send();
}

function callBackPeticionRegistro() {
    if(conexion.readyState == 4 && conexion.status == 200) {
        let data=JSON.parse(conexion.responseText);
        if(data.code=="400"){
            error.innerHTML += "* El usuario introducido ya existe<br>";
        } else {
            login(nick,password);
        }
    }
}



function login(nick,pass){
    conexion=new XMLHttpRequest();
    conexion.addEventListener('readystatechange',callBackPeticionLogin);
    conexion.open('GET',"http://127.0.0.1/backend/login.php?nick="+nick+"&pass="+pass);
    conexion.send();
}

function callBackPeticionLogin() {
    if(conexion.readyState == 4 && conexion.status == 200) {
        let data=JSON.parse(conexion.responseText);

        if(data.code=="200"){
            setCookie("api_key",data.api_key,9999);
            window.location.href = "feed.html";
        }
    }
}


//======================================================================================================
// Validar que solo hay letras y numeros
function alphanumeric(inputtxt) {
    var letterNumber = /^[0-9a-zA-Z]+$/;
    if(inputtxt.match(letterNumber)){
        return true;
        } else { 
        return false; 
    }
}


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