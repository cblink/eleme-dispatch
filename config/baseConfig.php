<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'app_id' => 'app_id',
    'secret_key' => 'secret_key',
    'debug' => true,
    'cache' =>  new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir()),
];
