<?php

use WebWork\Features\Route;
use WebWork\Features\Mail;


Route::get('/', function () {

    return view('index');
});

Route::get('/discord', function () {
    redirect('https://discord.gg/U2NF5sBdUX');
});

Route::get('/tictactoe', function () {
    return view('tictactoe');
});

Route::post('/send-email', function () {
    $imie = $_POST['name'];
    $nazwisko = $_POST['surname'];
    $email = $_POST['email'];
    $wiadomosc = $_POST['message'];
    Mail::send('kaudekbog@gmail.com', 'Temat wiadomości', "$imie $nazwisko o mailu $email wyslal: \n $wiadomosc");  
});

Route::get('/cpp', function () {
    return view('cpp');
});

