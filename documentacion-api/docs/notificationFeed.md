# notificationFeed.php

Devuelve las notificaiones de (favs,rt,comentarios y follow) ordenados por fecha

**Metodo** : `GET & POST`

**Clave de API requerida** : SI

## Parametros

```
api_key : string
page : string
```

## Respuesta

**Ejemplo**
```json
[
    {
    "type": "fav",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "tweet_id": "GBA3Cz2E3NwFSUJR",
    "date": "2021-04-24 01:49:46"
    },
    {
    "type": "comment",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "tweet_id": "UI1TnFmK6rwiCCwS",
    "date": "2021-04-24 01:38:22"
    },
    {
    "type": "rt",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "tweet_id": "R2wKK5j5tWjQm3GG",
    "date": "2021-04-24 01:38:14"
    },
    {
    "type": "fav",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "tweet_id": "J2VwsTImUVmS31Ez",
    "date": "2021-04-24 01:38:13"
    },
    {
    "type": "follow",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "date": "2021-04-24 01:28:14"
    },
    {
    "type": "comment",
    "user_id": "23",
    "nick": "Kaki",
    "name_twitter": "Kaki",
    "tweet_id": "J2VwsTImUVmS31Ez",
    "date": "2021-04-18 23:36:28"
    }
]
```