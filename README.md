# User API

## Setup
- Create database then import /database/interview_assigment.sql
- From project directory run `php -S localhost:9999`

## Endpoints

**User detail**

`[GET] /users/:id`

**Update user profile**

`[PUT] /users/:id`

## Run/test

There are 2 users in system.

**True cases**
- Open in Postman: `http://localhost:9999/login` to loggin as user `1`
- Open in Postman: [GET] `http://localhost:9999/users/1` to get user `1` profile 

  => Should success
- Open in Postman: [PUT] `http://localhost:9999/users/1` (raw JSON) to update user `1` profile.

    Example data: ```{"name": "updated name", "address": "updated address"}```
    
    => Should success
    
**False case**
- Open in Postman: `http://localhost:9999/logout` to logout user
- Open in Postman: [GET] `http://localhost:9999/users/1` to get user `1` profile 

  => Should response 401 Unauthenticated
- Open in Postman: `http://localhost:9999/login` to loggin as user `1` again
- Open in Postman: [GET] `http://localhost:9999/users/2` to get user `2` profile 

  => Should response 403 Unauthorized
- Open in Postman: [PUT] `http://localhost:9999/users/2` (raw JSON) to update user `2` profile.

    Example data: ```{"name": "updated name", "address": "updated address"}```
    
    => Should response 403 Unauthorized
