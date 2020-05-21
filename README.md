## Setting Up

1. Run in cmd ```composer install```
2. Run in cmd ```npm run production```
3. Create database "Partup" on you database server.
4. Create file .env 
``` 
APP_NAME=Partup
APP_ENV=local
APP_KEY=base64:vPOREvWxbSBnwwd6WpKMlGlEvMOJEw1chfkaG9CrH5Q=
APP_DEBUG=true
APP_URL=http://localhost/

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST={{}}
DB_PORT={{}}
DB_DATABASE={{}}
DB_USERNAME={{}}
DB_PASSWORD={{}}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST={{}}
MAIL_PORT={{}}
MAIL_USERNAME={{}}
MAIL_PASSWORD={{}}
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```
5. Change .env file ```{{}}``` with mail, database login data. 
6. Run in cmd ```php artisan migrate```
7. Run in cmd ```php artisan serve```

