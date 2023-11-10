<?php

function obterIntervalo($jogo) 
{
    $verifica = false;

    while (!$verifica) 
    {
        switch ($jogo) 
        {
            case "Mega-Sena":
                echo "Mega-Sena\n";
                $verifica = true;
                return array(6, 20, 60);
            case "Quina":
                echo "Quina\n";
                $verifica = true;
                return array(5, 15, 80);
            case "Lotomania":
                echo "Lotomania\n";
                $verifica = true;
                return array(50, 50, 100);
            case "Lotofácil":
                echo "Lotofácil\n";
                $verifica = true;
                return array(15, 18, 25);
            default:
                echo "Jogo inválido\n";
                $verifica = false;
        }
    }
}

function obterDezenasValidas($jogo) 
{
    list($minDezenas, $maxDezenas, $maxNumero) = obterIntervalo($jogo);
    return array($minDezenas, $maxDezenas, range(1, $maxNumero));
}

function gerarAposta($jogo, $numApostas, $numDezenas) 
{
    list($minDezenas, $maxDezenas, $dezenasValidas) = obterDezenasValidas($jogo);

    $apostas = array();
    for ($i = 0; $i < $numApostas; $i++) 
    {
        shuffle($dezenasValidas);
        $aposta = array_slice($dezenasValidas, 0, $numDezenas);
        sort($aposta);
        $apostas[] = $aposta;
    }

    return $apostas;
}

function calcularCusto($jogo, $numApostas) 
{
    list($minDezenas, $maxDezenas, $_) = obterIntervalo($jogo);
    return $numApostas * $minDezenas;
}

try 
{
    $jogo = readline("Selecione um jogo (Mega-Sena, Quina, Lotomania ou Lotofácil): ");
    $numApostas = intval(readline("Quantas apostas você deseja gerar? "));
    $numDezenas = intval(readline("Quantas dezenas por aposta? "));

    list($minDezenas, $maxDezenas, $dezenasValidas) = obterDezenasValidas($jogo);

    if ($numDezenas < $minDezenas || $numDezenas > $maxDezenas) 
    {
        throw new Exception("O número de dezenas deve estar entre $minDezenas e $maxDezenas");
    }

    $apostas = gerarAposta($jogo, $numApostas, $numDezenas);

    echo "\nApostas geradas:\n";
    foreach ($apostas as $i => $aposta) 
    {
        echo "Aposta " . ($i + 1) . ": " . implode(", ", $aposta) . "\n";
    }

    $custoTotal = calcularCusto($jogo, $numApostas);
    echo "\nTotal gasto em reais: R$" . number_format($custoTotal, 2) . "\n";

} 
catch (Exception $e) 
{
    echo "Erro: " . $e->getMessage() . "\n";
}
