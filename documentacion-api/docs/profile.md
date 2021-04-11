# profile.php

Obtiene data para renderizar el perfil de un usuario por su ID.

**Metodo** : `GET & POST`

**Clave de API requerida** : SI

## Parametros

```
api_key : string
id : string
```

## Respuesta

**Ejemplo**
```json
{
    "code": 200,
    "id": "3",
    "nick": "test",
    "name_twitter": "testeo",
    "reg_date": "2021-03-11 23:23:01",
    "edit": false,
    "follow": false,
    "followers": 125,
    "following": 98
}
```

```json
{
    "code": 400,
    "msg":"No existe usuario con ese ID"
}
```

```json
{
    "code": 400,
    "msg":"La api_key no es válida"
}
```