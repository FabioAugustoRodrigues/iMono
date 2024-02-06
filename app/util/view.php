<?php

function view($filename) {
    $viewsDir = 'app/views/';
    $phpFilePath = $viewsDir . $filename . '.php';
    $tmlFilePath = $viewsDir . $filename . '.tml';

    if (file_exists($phpFilePath)) {
        include $phpFilePath;
    } elseif (file_exists($tmlFilePath)) {
        include $tmlFilePath;
    } else {
        echo 'Erro: View não encontrada.';
    }
}