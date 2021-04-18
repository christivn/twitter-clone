let input = document.getElementById("barra-busqueda");

input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      
      conexionBuscar=new XMLHttpRequest();
      conexionBuscar.addEventListener('readystatechange',callBackBuscar);
      conexionBuscar.open('GET',"http://127.0.0.1/backend/search.php?api_key="+getCookie("api_key")+"&name_twitter="+input.value);
      conexionBuscar.send();

      function callBackBuscar() {
        if(conexionBuscar.readyState == 4 && conexionBuscar.status == 200) {
            if(conexionBuscar.responseText.length>0){
                let data=JSON.parse(conexionBuscar.responseText);
                window.location.href = "profile.html?id="+data[0].id;
            }
        }
      }

    }
  });

