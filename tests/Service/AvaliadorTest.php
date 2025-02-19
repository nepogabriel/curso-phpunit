<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    #[DataProvider('leilaoEmOrdemAleatoria')]
    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Arrumo a casa para o teste (Arrange / Given). Foi movido para o parâmetro

        $leiloeiro = new Avaliador;

        // Executo o código a ser testado (Act / When)
        $leiloeiro->avalia($leilao);

        $maiorValor = $leiloeiro->getMaiorvalor();

        // Verifico se a saída é a esperada (Assert / Then )
        self::assertEquals(2500, $maiorValor);
    }

    #[DataProvider('leilaoEmOrdemAleatoria')]
    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Arrumo a casa para o teste (Arrange / Given). Foi movido para o parâmetro

        $leiloeiro = new Avaliador;

        // Executo o código a ser testado (Act / When)
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        // Verifico se a saída é a esperada (Assert / Then )
        self::assertEquals(1700, $menorValor);
    }

    // /**
    //  * @dataProvider leilaoEmOrdemAleatoria
    //  * @dataProvider leilaoEmOrdemCrescente
    //  * @dataProvider leilaoEmOrdemDecrescente
    //  */
    #[DataProvider('leilaoEmOrdemAleatoria')]
    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        $maiores = $leiloeiro->getMaioreslances();

        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }

    public static function leilaoEmOrdemCrescente(): array
    {
        // Arrumo a casa para o teste (Arrange / Given)
        $leilao = new Leilao('Vw Polo Preto 2007 de Cria');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            [$leilao]
        ];
    }

    public static function leilaoEmOrdemDecrescente(): array
    {
        // Arrumo a casa para o teste (Arrange / Given)
        $leilao = new Leilao('Vw Polo Preto 2007 de Cria');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));        
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            [$leilao]
        ];
    }

    public static function leilaoEmOrdemAleatoria(): array
    {
        // Arrumo a casa para o teste (Arrange / Given)
        $leilao = new Leilao('Fiat Uno');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500)); 
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            [$leilao]
        ];
    }
}