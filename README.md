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
