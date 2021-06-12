# login.php

Realiza el login del usuario y genera una nueva api_key.

**Metodo** : `GET & POST`

**Clave de API requerida** : NO

## Parametros

```
nick : string
pass : string
```

## Respuesta

**Ejemplo**
```json
{
    "code": 200,
    "id": 345,
    "api_key": "njQEZNw25rVSGLtI",
    "msg":"Se ha completado la peticion correctamente"
}
```

```json
{
    "code": 400,
    "msg":"Datos de session incorrectos"
}
```
