<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vCode.pl - You will create your project with us.</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="shortcut icon" type="image/png" href="images/v-logo.png" />
</head>

<body>
    <menu />
    <div class="previewImg">
        <div onclick="hide()" class="x-button">
            <div></div>
            <div></div>
        </div>
        <img class="previewImage" src="" alt="">
    </div>
    <main>
        <h1><strong>vCode.pl</strong><br><p>You will create your project with us.</p></h1>
        <section id="main">
            <aside>
                <h3>Cześć<span style="color: #007ac1;">.</span></h3>
                <p>Zapewne zastanawiasz się dlaczego wybrać akurat nas, odpowiedź jest prosta.</p>
                <br>
                <p><strong>Stawiamy wielką uwagę na:</strong></p>
                <ul>
                    <li>Czytelny kod</li>
                    <li>Dbałość o szczegóły</li>
                    <li>Nowoczesny wygląd</li>
                    <li>Używanie sprawdzonych technologii</li>
                </ul>
            </aside>
        </section>
        <section id="projects">
            <article><h2>Projekty</h2></article>
            <article>
                <div class="project-item">
                    <div class="project-item--img"><img onclick="preview('demo/tictactoe/preview.png')" src="demo/tictactoe/preview.png" alt=""></div>
                    <div class="project-item--info">
                        <h2>Tic Tac Toe</h2>
                        <p>Gra w kółko i krzyżyk napisana w języku JavaScript.</p>
                        <a href="tictactoe">Sprawdź</a>
                    </div>
                </div>
                <div class="project-item">
                    <div class="project-item--img"><img onclick="preview('images/1.png')" src="images/1.png" alt=""></div>
                    <div class="project-item--info">
                        <h2>Test</h2>
                        <p>Test.</p>
                        <a href="demo/test/">Sprawdź</a>
                    </div>
                </div>
                <div class="project-item">
                    <div class="project-item--img"><img onclick="preview('images/2.png')" src="images/2.png" alt=""></div>
                    <div class="project-item--info">
                        <h2>Test</h2>
                        <p>Test.</p>
                        <a href="demo/test/">Sprawdź</a>
                    </div>
                </div>
                <div class="project-item">
                    <div class="project-item--img"><img onclick="preview('images/3.png')" src="images/3.png" alt=""></div>
                    <div class="project-item--info">
                        <h2>Test</h2>
                        <p>Test.</p>
                        <a href="demo/test/">Sprawdź</a>
                    </div>
                </div>
            </article>
        </section>
        <section id="contact">
            <contact />
        </section>
        <footer></footer>
    </main>
    <script src="scripts/menu.js"></script>
    <script src="scripts/preview.js"></script>
</body>

</html>