## Install

Add config tu env.php

```bash
    'queue' => [
        'amqp' => [
            'host' => 'localhost',
            'port' => '5672',
            'user' => 'admin',
            'password' => 'admin@123',
            'virtualhost' => '/'
        ]
    ],
```