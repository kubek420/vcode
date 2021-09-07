function startGame() {
    let turn = "O";
    const resetBtn = document.querySelector('.resetBtn');
    let mozliwoscRuchu = true;
    let wygrana = false;
    let zajetePola;
    const winnerPositions = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];
    nextMove(turn);
    const pola = [...document.querySelectorAll('.pole')];
    pola.forEach(pole => pole.addEventListener('click', e => {
        if (mozliwoscRuchu) {
            playerMove(pole);
        }
    }))
    const modeBtn = document.querySelector('.mode');
    modeBtn.addEventListener('click', () => {
        modeBtn.classList.toggle('fa-sun');
        modeBtn.classList.toggle('fa-moon');
        document.body.classList.toggle('dark');
        for (let x = 0; x < 9; x++) {
            if (document.body.classList.contains('dark')) {
                pola[x].style.color = "rgb(31, 31, 31)";
            } else {
                pola[x].style.color = "rgb(252, 252, 252)";
            }
        }
    })

    function playerMove(pole) {
        if (pole.classList.contains("far") || pole.classList.contains("fas")) return;
        if (turn == "O") {
            pole.classList.add('far');
            pole.classList.add('fa-circle');
            turn = "X";
            nextMove(turn);
            check();
        } else if (turn == "X") {
            pole.classList.add('fas');
            pole.classList.add('fa-times');
            turn = "O";
            nextMove(turn);
            check();
        }
    }
    function nextMove(player) {
        if (player == "remis") {
            document.querySelector('h1').innerHTML = "REMIS";
        } else
            document.querySelector('h1').innerHTML = "Ruch gracza: " + player;
    }
    function check() {
        for (let i = 0; i < winnerPositions.length; i++) {
            const a = pola[winnerPositions[i][0]];
            const b = pola[winnerPositions[i][1]];
            const c = pola[winnerPositions[i][2]];
            if (a.classList.contains("far") && b.classList.contains("far") && c.classList.contains("far")) {
                document.querySelector('h1').innerHTML = "Wygrał: Kółko";
                mozliwoscRuchu = false;
                resetBtn.style.display = "block";
                wygrana = true;
                a.style.color = "rgb(78, 255, 131)";
                b.style.color = "rgb(78, 255, 131)";
                c.style.color = "rgb(78, 255, 131)";
            }
            if (a.classList.contains("fas") && b.classList.contains("fas") && c.classList.contains("fas")) {
                document.querySelector('h1').innerHTML = "Wygrał: Krzyżyk";
                mozliwoscRuchu = false;
                resetBtn.style.display = "block";
                wygrana = true;
                a.style.color = "rgb(78, 255, 131)";
                b.style.color = "rgb(78, 255, 131)";
                c.style.color = "rgb(78, 255, 131)";
            }
        }
        if (wygrana) return;
        zajetePola = 0;
        for (let y = 0; y < 9; y++) {
            if (pola[y].classList.contains("far") || pola[y].classList.contains("fas")) {
                zajetePola++;
            }
        }
        if (zajetePola == 9) {
            nextMove('remis');
            mozliwoscRuchu = false;
            resetBtn.style.display = "block";
        }
    }
    resetBtn.addEventListener('click', () => {
        for (let x = 0; x < 9; x++) {
            pola[x].classList.remove('far');
            pola[x].classList.remove('fas');
            pola[x].classList.remove('fa-circle');
            pola[x].classList.remove('fa-times');
            if (document.body.classList.contains('dark')) {
                pola[x].style.color = "rgb(31, 31, 31)";
            } else {
                pola[x].style.color = "rgb(252, 252, 252)";
            }
        }
        mozliwoscRuchu = true;
        wygrana = false;
        turn = "O";
        nextMove(turn);
        resetBtn.style.display = "none";
    })
}