<?php

namespace Tests\Models;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    #[DataProvider('gerarLances')]
    public function testLeilaoDeveReceberLances(int $quantidadeLances, Leilao $leilao, array $valores)
    {
        $this->assertCount($quantidadeLances, $leilao->getLances());

        foreach ($valores as $index => $valor) {
            $this->assertEquals($valor, $leilao->getLances()[$index]->getValor());
        }
    }

    public static function gerarLances(): array
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilaoCom2Lances = new Leilao('Fiat 147 0KM');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lances = new Leilao('Golf 2001 115KM');
        $leilaoCom1Lances->recebeLance(new Lance($maria, 5000));

        return [
            'leilao_com_2_lances' => [2, $leilaoCom2Lances, [1000, 2000]],
            'leilao_com_1_lances' => [1, $leilaoCom1Lances, [5000]],
        ];
    }
}