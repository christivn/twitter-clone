# register.php

Realiza el registro de usuarios.

**Metodo** : `GET & POST`

**Clave de API requerida** : NO

## Parametros

```
nick : string
pass : string
bio : string (opcional)
```

## Respuesta

**Ejemplo**
```json
{
    "code": 200,
    "msg":"Se ha completado la peticion correctamente"
}
```

```json
{
    "code": 400,
    "msg":"El usuario ya existe"
}
```