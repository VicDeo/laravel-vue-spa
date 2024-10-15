Get all tasks 
```
curl -i -X GET -H"Content-Type: application/json"  http://localhost:80/api/v1/tasks
```

Create a task
```
curl -i -X POST -H"Content-Type: application/json"  http://localhost:80/api/v1/tasks --data '{"name":"New name"}'
```

Update a task
```
curl -i -X PUT -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/v1/tasks/11 --data '{"name":"New content"}'
```

Complete a task
```
curl -i -X PATCH -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/v1/tasks/11/complete --data '{"is_completed":false}'
```

Delete a task
```
curl -i -X DELETE -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/v1/tasks/15  
```

Login
```
TOKEN=`curl -is -c cookies.txt -X GET "http://localhost:80/sanctum/csrf-cookie" | grep XSRF-TOKEN | cut -d ';' -f 1 | cut -d'=' -f2 | sed 's/\%3D/=/'`

curl -i -X POST -b cookies.txt -c cookies.txt -H"X-XSRF-TOKEN: $TOKEN" -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/auth/login -d '{"email":"crist.reba@example.com", "password":"password"}'
```

Logout
```
curl -i -b cookies.txt  -X POST -H"X-XSRF-TOKEN: $TOKEN" http://localhost:80/auth/logout
```

Register
```
TOKEN=`curl -is -c cookies.txt -X GET "http://localhost:80/sanctum/csrf-cookie" | grep XSRF-TOKEN | cut -d ';' -f 1 | cut -d'=' -f2 | sed 's/\%3D/=/'`

curl -i -X POST -b cookies.txt -c cookies.txt -H"X-XSRF-TOKEN: $TOKEN" -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/auth/register -d '{"name":"John Deer", "email":"omg@omfg.com", "password":"password", "password_confirmation":"password"}'
```

Show current user
```
curl -i -X GET -b cookies.txt  -H"Accept: application/json" -H"Referer: localhost" http://localhost:80/api/user
```

Get all tasks for the current user
```
TOKEN=`curl  -X POST -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/auth/login -d '{"email":"blick.kellen@example.net", "password":"password"}' | jq ".token" | tr -d '"'`

curl -i -X GET  -H"Authorization: Bearer $TOKEN" -H"Accept: application/json"  http://localhost:80/api/v2/tasks
```

### Token
Login
```
curl -i -X POST  -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/auth/login -d '{"email":"crist.reba@example.com", "password":"password"}'
```

Show current user
```
$TOKEN is a token value sent by server with Login response
TOKEN=`curl  -X POST -H"Content-Type: application/json" -H"Accept: application/json"  http://localhost:80/api/auth/login -d '{"email":"crist.reba@example.com", "password":"password"}' | jq ".token"`

curl -i -X GET -H"Authorization: Bearer $TOKEN" -H"Accept: application/json"  http://localhost:80/api/user
```

Logout
```
curl -X POST -H"Authorization: Bearer $TOKEN" -H"Accept: application/json" http://localhost:80/api/auth/logout
```

Register
```
curl -i -X POST -H"Authorization: Bearer $TOKEN" -H"Accept: application/json"  http://localhost:80/api/auth/register -d '{"name":"John Deer", "email":"omg@omfg.com", "password":"password", "password_confirmation":"password"}'
```
