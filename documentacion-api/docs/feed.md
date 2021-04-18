# feed.php

Devuelve los ultimos 20 tweets ordenados por fecha

**Metodo** : `GET & POST`

**Clave de API requerida** : SI

## Parametros

```
api_key : string
```

**Ejemplo**
```json
[
    {
    "user_id": "4",
    "nick": "test",
    "name_twitter": "Usuario de testeo",
    "avatar_url": "https://i.imgur.com/TrmqA6a.jpeg",
    "tweet_id": "J2VwsTImUVmS31Ez",
    "date": "2021-04-18 02:41:13",
    "content": "Ejemplo de tweet con una imagen",
    "img_url": "https://concepto.de/wp-content/uploads/2015/03/paisaje-e1549600034372.jpg",
    "fav": 0,
    "rt": 0,
    "comments": 0
    },
    
    {
    "user_id": "4",
    "nick": "test",
    "name_twitter": "Usuario de testeo",
    "avatar_url": "https://i.imgur.com/TrmqA6a.jpeg",
    "tweet_id": "UI1TnFmK6rwiCCwS",
    "date": "2021-04-18 02:38:45",
    "content": "Texto de ejemplo",
    "img_url": "",
    "fav": 0,
    "rt": 0,
    "comments": 0
    }
]
```