<?php

function abertura()
{
    echo "Olá, somos a rede central administradora de jogos!!!\n";
    $verifica = strtolower(trim(readline("Deseja jogar?\n")));
    if ($verifica == "sim") 
    {
        escolher_jogo();
    }
}

function escolher_jogo()
{
    echo "1- Mega Sena.\n";
    echo "2- Quina.\n";
    echo "3- Lotomania.\n";
    echo "4- Lotofácil.\n";
    
    $opcao = intval(readline("Escolha: "));
    
    switch ($opcao) 
    {
        case 1:
        echo "Mega-Sena\n";
        echo "Intervalo: 6 a 20 dezenas, números de 1 a 60\n";
        jogar("Mega-Sena", 6, 20, 60);
        break;
        case 2:
        echo "Quina\n";
        echo "Intervalo: 5 a 15 dezenas, números de 1 a 80\n";
        jogar("Quina", 5, 15, 80);
        break;
        case 3:
        echo "Lotomania\n";
        echo "Intervalo: 50 dezenas fixas, números de 1 a 100\n";
        jogar("Lotomania", 50, 50, 100);
        break;
        case 4:
        echo "Lotofácil\n";
        echo "Intervalo: 15 a 18 dezenas, números de 1 a 25\n";
        jogar("Lotofácil", 15, 18, 25);
        break;
        default:
        clear();
        echo "Jogo inválido\n";
        escolher_jogo();
        break;
    }
}

function jogar($nome_jogo, $min_dezenas, $max_dezenas, $max_numero)
{
    $num_apostas = intval(readline("Quantas apostas você deseja gerar? "));
    $num_dezenas = intval(readline("Quantas dezenas por aposta? "));
    
    $jogoVencedor = gerarJogoVencedor($min_dezenas, $max_dezenas, $max_numero);
    
    obterIntervalo($nome_jogo, $min_dezenas, $max_dezenas);
    
    $apostas = gerarAposta($min_dezenas, $max_dezenas, $num_apostas, $num_dezenas, $max_numero, $nome_jogo, $jogoVencedor);
    
    echo "\nApostas geradas para $nome_jogo:\n";
    foreach ($apostas as $i => $aposta) 
    {
        echo "Aposta " . ($i + 1) . ": " . implode(", ", $aposta) . " - Acertos: " . contarAcertos($aposta, $jogoVencedor) . "\n";
    }
    
    $mediaAcertos = calcularMediaAcertos($apostas, $jogoVencedor);
    $custoTotal = calcularCusto($min_dezenas, $num_apostas);
    
    echo "\nTotal gasto em reais para $nome_jogo: R$" . number_format($custoTotal, 2) . "\n";
    echo "Média de acertos por jogo: $mediaAcertos\n";
    
    if (jogarNovamente()) 
    {
        escolher_jogo();
    } 
    else 
    {
        echo "Obrigado por jogar! Até a próxima.\n";
    }
}

function jogarNovamente()
{
    $resposta = strtolower(trim(readline("Deseja jogar novamente? (sim/não)\n")));
    return $resposta == "sim";
    clear()
}

function gerarJogoVencedor($minDezenas, $maxDezenas, $maxNumero)
{
    $jogoVencedor = array();
    
    while (count($jogoVencedor) < $minDezenas) 
    {
        $novaDezena = rand(1, $maxNumero);
            if (!in_array($novaDezena, $jogoVencedor)) 
        {
            $jogoVencedor[] = $novaDezena;
        }
    }
    
    sort($jogoVencedor);
    return $jogoVencedor;
}

function contarAcertos($aposta, $jogoVencedor)
{
    return count(array_intersect($aposta, $jogoVencedor));
}

function calcularMediaAcertos($apostas, $jogoVencedor)
{
    $totalAcertos = 0;
    foreach ($apostas as $aposta) 
    {
        $totalAcertos += contarAcertos($aposta, $jogoVencedor);
    }
    
    $numApostas = count($apostas);
    return $numApostas > 0 ? round($totalAcertos / $numApostas, 2) : 0;
}

function calcularCusto($minDezenas, $numApostas)
{
    return $numApostas * $minDezenas;
}

function obterIntervalo($nome_jogo, $min_dezenas, $max_dezenas)
{
    echo "Você pode escolher entre $min_dezenas e $max_dezenas dezenas para $nome_jogo.\n";
}

function gerarAposta($minDezenas, $maxDezenas, $numApostas, $numDezenas, $maxNumero, $nomeJogo, $jogoVencedor)
{
    $apostas = array();
    for ($i = 0; $i < $numApostas; $i++) 
    {
        $dezenasValidas = range(1, $maxNumero);
        $aposta = array();
        
        while (count($aposta) < $numDezenas) 
        {
            shuffle($dezenasValidas);
            $novaDezena = array_shift($dezenasValidas);
            if (!in_array($novaDezena, $aposta)) 
            {
                $aposta[] = $novaDezena;
            }
        }
        
        sort($aposta);
        $apostas[] = $aposta;
    }
    
    return $apostas;
}

function clear()
{
    // Mensagem de limpeza de tela em vez de usar system
    echo "\033[2J\033[1;1H"; // ANSI escape code for clearing the screen
}

abertura();
