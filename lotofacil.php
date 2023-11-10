<?php

function abertura()
{
	echo "Olá, somos a rede central administradora de jogos!!!";
	$verifica = readline("Deseja jogar?");
	if ($verifica == "sim" || $verifica == "Sim")
	{
		escolher_jogo();
	}
}

function escolher_jogo()
{
	$verifica = true;
	echo "1- Mega Sena.";
	echo "2- Quina.";
	echo "3- Lotomania.";
	echo "4- Lotofácil.";
	$opcao = readline("Escolha:");
	$verifica = true;
	while ($verifica != false) 
	{
		switch ($opcao) 
		{
			case 1:
				echo "Mega Sena";
				$verifica = false;
				break;
			case 2:
				echo "Quina";
				$verifica = false;
				break;
			case 3:
				echo "Lotomania";
				$verifica = false;
				break;
			case 4:
				echo "Lotofácil";
				$verifica = false;
				break;
			default:
				echo "Jogo inválido\n";
				$verifica = true;
				break;
		}
	}
}

abertura();

?>
