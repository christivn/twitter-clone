let boton = document.getElementById("boton");
boton.addEventListener("mouseover", actualizar);

function actualizar(){
    if(boton.classList.contains("seguir")){

        boton.addEventListener("click", follow);
        function follow(){
            let api_key = getCookie("api_key");
        
            let id = "";
            if(findGetParameter("id")==null){
                id = getCookie("id");
            } else {
                id = findGetParameter("id");
            }
        
            conexion=new XMLHttpRequest();
            conexion.addEventListener('readystatechange', callBackFollow);
            conexion.open('GET',"http://christivn.es/api/follow.php?api_key="+api_key+"&followed_id="+id);
            conexion.send();

            function callBackFollow() {
                if(conexion.readyState == 4 && conexion.status == 200) {
                    boton.textContent="Siguiendo";
                    boton.classList.remove('boton-secundario');
                    boton.classList.remove('boton-rojo');
                    boton.classList.remove('seguir');
                    boton.classList.add('boton-principal');
                    boton.classList.add('siguiendo');
                    boton.style.width = "20%";
                }
            }
        }

    } else {
        
        boton.addEventListener("click", unfollow);
        function unfollow(){
            let api_key = getCookie("api_key");
        
            let id = "";
            if(findGetParameter("id")==null){
                id = getCookie("id");
            } else {
                id = findGetParameter("id");
            }
        
            conexion=new XMLHttpRequest();
            conexion.addEventListener('readystatechange', callBackUnfollow);
            conexion.open('GET',"http://christivn.es/api/unfollow.php?api_key="+api_key+"&followed_id="+id);
            conexion.send();

            function callBackUnfollow() {
                if(conexion.readyState == 4 && conexion.status == 200) {
                    boton.textContent="Seguir";
                    boton.classList.remove('boton-principal');
                    boton.classList.remove('boton-rojo');
                    boton.classList.remove('siguiendo');
                    boton.classList.add('seguir');
                    boton.classList.add('boton-secundario');
                    boton.style.width = "20%";
                }
            }
        }
        
        
        
        boton.addEventListener("mouseenter", dejarSeguir);
        function dejarSeguir(){
            boton.textContent="Dejar de seguir";
            boton.classList.remove('boton-principal');
            boton.classList.remove('siguiendo');
            boton.classList.add('boton-rojo');
            boton.style.width = "30%";
        }
        
        boton.addEventListener("mouseleave", siguiendo);
        function siguiendo(){
            boton.textContent="Siguiendo";
            boton.classList.remove('seguir');
            boton.classList.remove('boton-rojo');
            boton.classList.add('boton-principal');
            boton.classList.add('siguiendo');
            boton.style.width = "20%";
        }

    }

}