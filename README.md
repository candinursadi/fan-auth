### First Step

Follow this commands:
Migrate the tables
``` 
php artisan migrate
``` 
Insert the seeds
```
php artisan db:seed
```

### Login to get Access Token

| Service Name  | Endpoint |
| ------------- | ------------- |
| login | {{baseUrl}}/login  |

**Request (POST) :**
``` 
{
    "email" : "xskiles@example.net",
    "password" : "1111"
}
```

**Response Success :**
``` 
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MywibmFtYSI6Ikx1Y3kgU3Ryb21hbiIsImVtYWlsIjoieHNraWxlc0BleGFtcGxlLm5ldCIsIm5wcCI6IjcxNzUiLCJucHBfc3VwZXJ2aXNvciI6IjI5MTIiLCJleHAiOjE2NzA0NDIwNzN9.f901cVWINPVPqzqFksQA_TOS8GTCHta_wQCNYYvgUzY",
    "token_type": "bearer"
}
```

### Check In/Out Presence

| Service Name  | Endpoint |
| ------------- | ------------- |
| check-in-out | {{baseUrl}}/api/presence  |

**Request (POST) :**
``` 
Authorization: Bearer {access_token}
Content-Type: application/json

{
    "type" : "IN",
    "waktu" : "2022-12-07 08:35:00"
}
```

**Response Success :**
``` 
{
    "message": "Success"
}
```

### Get User

| Service Name  | Endpoint |
| ------------- | ------------- |
| get-user | {{baseUrl}}/api/user  |

**Request (GET) :**
``` 
GET /api/user?start_date=2022-12-07&end_date=2022-12-08&page=1&per_page=2 HTTP/1.1
Authorization: Bearer {access_token}
```

**Response Success :**
``` 
{
    "message": "Success get data",
    "data": [
        {
            "id_user": 3,
            "nama_user": "Lucy Stroman",
            "tanggal": "2022-12-07",
            "waktu_masuk": "09:12:00",
            "waktu_keluar": "09:15:00",
            "status_masuk": "APPROVE",
            "status_keluar": "REJECT"
        },
        {
            "id_user": 3,
            "nama_user": "Lucy Stroman",
            "tanggal": "2022-12-08",
            "waktu_masuk": "09:15:00",
            "waktu_keluar": "09:35:00",
            "status_masuk": "REJECT",
            "status_keluar": "APPROVE"
        }
    ]
}
```
