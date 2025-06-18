<?php

namespace Tests\Models;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $maria = new Usuario('Maria');

        $leilao = new Leilao('Fiat 147 0KM');
        $leilao->recebeLance(new Lance($maria, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));

        $this->assertCount(1, $leilao->getLances());
        $this->assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = new Leilao('Brasília Amarela');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));

        $leilao->recebeLance(new Lance($joao, 6000));

        $this->assertCount(10, $leilao->getLances());
        $this->assertEquals(5500, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

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