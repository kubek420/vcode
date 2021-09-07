<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            <?= $status ?><?= ($text ? ' '.$text : '') ?>
        </title>

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

            body {
                margin: 0;
                background: #fff;
                color: #161617;
                font-family: 'Inter', 'Segoe UI', sans-serif;
                line-height: 1.8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            h1 {
                font-weight: 400;
                font-size: 22px;
            }

            strong {
                margin-right: 5px;
            }
        </style>
    </head>

    <body>
        <main>
            <h1>
                <strong>
                    <?= $status ?>
                </strong>

                <?= ($text ? ' '.$text : '') ?>
            </h1>
        </main>
    </body>
</html>
