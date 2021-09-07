<?php

function error($error, $errfile = null, $errline = null) {
    // If config debug mode is set to false, return HTTP 500 status
    if (!config('APP_DEBUG')) {
        abort(500);
    }

    // Clean output
    if (ob_get_contents()) {
        ob_end_clean();
    }

    $requestUri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')."://".(!empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').(!empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
    $method = $_SERVER['REQUEST_METHOD'] ?? '';

    // If the file is a compiled template, replace it with original file

    if (preg_match('/storage\\\\views\\\\(.*?)\.compiled\.php/', $errfile, $matches)) {
        $errfile = $_SERVER['DOCUMENT_ROOT'].'\\app\\views\\'.$matches[1].'.php';
    }

    $lines = $errfile ? file($errfile) : false;
    $linesCount = 0;

    if (!function_exists('getLines')) {
        function getLines($file) {
            $file = new \SplFileObject($file, 'r');
            $file->setFlags(\SplFileObject::READ_AHEAD);
            $file->seek(PHP_INT_MAX);
    
            return $file->key() + 1; 
        }
    }

    // echo getLines($errfile);
    // exit;

    $codeSnippet = '';

    // if ($lines) {
    //     $codeSnippet = '<span class="line-number">'.($errline - 5).($errline - 5 < 10 ? ' ' : '').'</span>'.htmlspecialchars($lines[$errline - 6]);

    //     //for ($i = -4; $i < 8; $i++) {
    //     for ($i = ($errline - 4 >= 1 ? -4 : 1); $i < ($errline + 8 < getLines($errfile) ? getLines($errfile) : 8); $i++) {
    //         if ($i == 0) {
    //             $codeSnippet .= '<span class="line-number line-number--error">'.$errline.($errline < 10 ? ' ' : '').'</span>'.'<div class="error-line">'.htmlspecialchars($lines[$errline - 1]).'</div><br>'; // Error line
    //         } else {
    //             $codeSnippet .= '<span class="line-number">'.($errline + $i).($errline + $i < 10 ? ' ' : '').'</span>'.htmlspecialchars($lines[$errline + $i - 1]);
    //         }
    //     }
    // }

    include __DIR__.'/../utils/html/debug-error.php';

    exit;
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    error($errstr, $errfile, $errline);
});
