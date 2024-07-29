<?php

return [
    'channels' => [
        'backupDB' => [
            'driver' => 'single',
            'path' => storage_path('logs/backupDB.log'),
            'level' => 'info',
        ]
    ]
];