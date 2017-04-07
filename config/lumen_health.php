<?php
return [
    // 是否显示异常信息
    'show_exceptions' => true,

    // checks
    // key => Class
    'checks' => [
        'db'        => 'DbCheck',
        'diskSpace' => 'DiskSpaceCheck',
        'redis'     => 'RedisCheck'
    ]
];