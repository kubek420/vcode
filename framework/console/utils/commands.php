<?php

use WebWork\Features\DB;

switch ($argv[1]) {
    case 'server':
        output('Starting development server');

        shell_exec('php -S 127.0.0.1:3000 public/index.php');
    break;

    case 'version':
        output('v1.4.2');
    break;

    case 'database':
        if (!file_exists(__DIR__.'/../../database/users.sql')) {
            return outputError('File database/users.sql doesn\'t exist');
        }

        if (config('DB_DATABASE') == '' || !config('DB_DATABASE')) {
            return outputError('Set your database name in config.json');
        }

        $sql = file_get_contents(__DIR__.'/../../database/users.sql');

        DB::query($sql);

        DB::query('
            ALTER TABLE `users`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `users_email_unique` (`email`);
        ');

        DB::query('
            ALTER TABLE `users`
            MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
        ');

        output('Created table "users"');
    break;

    case 'controller':
        $fileName = __DIR__.'/../../app/controllers/'.$argv[2].'.php';

        if (file_exists($fileName)) {
            return outputError('Controller '.$argv[2].' already exists');
        }

        // Create folder if not exists
        if (!file_exists(__DIR__.'/../../app/controllers')) {
            mkdir(__DIR__.'/../../app/controllers', 0777, true);
        }

        file_put_contents($fileName, '<?php

namespace App\Controllers;

class '.$argv[2].' {
    
}
');

        output('Created controller '.$argv[2]);
    break;

    case 'view':
        $fileName = __DIR__.'/../../app/views/'.$argv[2].'.php';

        if (file_exists($fileName)) {
            return outputError('View '.$argv[2].' already exists');
        }

        // Create folder if not exists
        if (!file_exists(__DIR__.'/../../app/views')) {
            mkdir(__DIR__.'/../../app/views', 0777, true);
        }

        file_put_contents($fileName, '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="/styles/main.css">

        <title>'.$argv[2].'</title>
    </head>

    <body>
        <h1>Page</h1>
    </body>
</html>
');

        output('Created view '.$argv[2]);
    break;

    case 'model':
        $fileName = __DIR__.'/../../app/models/'.$argv[2].'.php';

        if (file_exists($fileName)) {
            return outputError('Model '.$argv[2].' already exists');
        }

        // Create folder if not exists
        if (!file_exists(__DIR__.'/../../app/models')) {
            mkdir(__DIR__.'/../../app/models', 0777, true);
        }

        file_put_contents($fileName, '<?php

namespace App\Models;

use WebWork\Features\Model;

class '.$argv[2].' extends Model {
    
}
');

        output('Created model '.$argv[2]);
    break;

    default:
        outputError('Unknown command \''.$argv[1].'\'');
}
