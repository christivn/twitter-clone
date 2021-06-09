# feed.php

Devuelve los ultimos 20 tweets ordenados por fecha de personas a las que sigues y los RT que se hacen

**Metodo** : `GET & POST`

**Clave de API requerida** : SI

## Parametros

```
api_key : string
page : string
```

**Ejemplo**
```json
[
    {
    "user_id": "4",
    "nick": "christivn",
    "name_twitter": "𝔠𝔥𝔯𝔦𝔰𝔱𝔦𝔞𝔫",
    "tweet_id": "6V8iwYTVinJsN0Ju",
    "date": "2021-04-24 02:59:33",
    "content": "TWEET TEST",
    "img_url": "",
    "type_feed": "rt",
    "rt_name": "Kaki",
    "fav": 0,
    "rt": 1,
    "comments": 0,
    "you_fav": false,
    "you_rt": false
    },
    {
    "user_id": "31",
    "nick": "manuel",
    "name_twitter": "Manuel",
    "tweet_id": "VeLZtzmXIEUCjmUC",
    "date": "2021-04-19 01:03:31",
    "content": "Mi primer tweet :D",
    "img_url": "",
    "type_feed": "follow",
    "rt_name": null,
    "fav": 1,
    "rt": 0,
    "comments": 0,
    "you_fav": true,
    "you_rt": false
    },
    {
    "user_id": "4",
    "nick": "christivn",
    "name_twitter": "𝔠𝔥𝔯𝔦𝔰𝔱𝔦𝔞𝔫",
    "tweet_id": "R2wKK5j5tWjQm3GG",
    "date": "2021-04-19 00:52:42",
    "content": "Testeo de foto",
    "img_url": "https://librosostenibilidad.files.wordpress.com/2017/03/paisaje-cultura-sostenibilidad.jpg",
    "type_feed": "rt",
    "rt_name": "Kaki",
    "fav": 0,
    "rt": 1,
    "comments": 0,
    "you_fav": false,
    "you_rt": false
    }
]
```