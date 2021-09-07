<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Error</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

            *,
            *::before,
            *::after {
                padding: 0;
                box-sizing: border-box;
            }

            ::selection {
                background: #b4d5fe;
                color: #161617;
            }

            ::-webkit-scrollbar {
                width: 16px;
                height: 16px;
                display: block;
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                border: 4px solid transparent;
                display: block;
                background: #999;
                background-clip: padding-box;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            body {
                margin: 0;
                background: #1f2023;
                color: #fff;
                font-family: 'Inter', 'Segoe UI', sans-serif;
                line-height: 1.8;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                height: 100vh;
            }

            h1 {
                font-weight: 600;
                font-size: 22px;
            }

            main {
                background: #252629;
                border-radius: 6px;
                padding: 36px 50px;
                width: calc(100vw - 500px);
                margin-top: 130px;
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
            }

            p {
                margin: 6px 0;
                font-size: 14px;
            }

            strong {
                font-weight: 600;
                font-size: 16px;
            }

            code {
                white-space: pre;
                margin-top: 18px;
                cursor: text;
            }

            .error-line {
                background: #ffeeee;
                display: inline-block;
                width: calc(100% - 30px);
            }

            .line-number {
                padding: 0 8px;
                user-select: none;
            }

            .line-number span {
                color: #111;
            }

            .line-number--error {
                background: #ffd7d7;
                display: inline-block;
            }
        </style>
    </head>

    <body>
        <main>
            <h1>Error: <?= $error ?></h1>

            <p>File: <strong><?= $errfile ?? 'Unknown' ?></strong></p>
            <p>Line: <strong><?= $errline ?? 'Unknown' ?></strong></p>
            <p>URL: <strong><?= $requestUri ?? 'Unknown' ?></strong></p>
            <p>HTTP Method: <strong><?= $method ?? 'Unknown' ?></strong></p>

            <?php if ($codeSnippet): ?>
                <pre><code class="php"><?= $codeSnippet ?></code></pre>
            <?php endif; ?>
        </main>
    </body>
</html>
