<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

// Arrumo a casa para o teste (Arrange / Given)
$leilao = new Leilao('Fiat Uno');

$maria = new Usuario('Maria');
$joao = new Usuario('Joao');

$leilao->recebeLance(new Lance($maria, 4300));
$leilao->recebeLance(new Lance($joao, 5255));

$leiloeiro = new Avaliador;

// Executo o código a ser testado (Act / When)
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorvalor(); 

// Verifico se a saída é a esperada (Assert / Then )
$valorEsperado = 5255;

if ($valorEsperado == $maiorValor) {
    echo 'TESTE OK';
} else {
    echo 'TESTE FALHOU';
}
