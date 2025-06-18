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
    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    #[DataProvider('leilaoEmOrdemAleatoria')]
    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Arrumo a casa para o teste (Arrange / Given). Foi movido para o parâmetro

        // Executo o código a ser testado (Act / When)
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorvalor();

        // Verifico se a saída é a esperada (Assert / Then )
        self::assertEquals(2500, $maiorValor);
    }

    #[DataProvider('leilaoEmOrdemAleatoria')]
    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Arrumo a casa para o teste (Arrange / Given). Foi movido para o parâmetro

        // Executo o código a ser testado (Act / When)
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

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
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioreslances();

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
            'ordem-crescente' => [$leilao]
        ];
    }

    public function testLeilaoVazioNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar leilão vazio.');

        $leilao = new Leilao('Fusca Azul');
        $this->leiloeiro->avalia($leilao);
    }

    
    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Leilão já finalizado.');

        $leilao = new Leilao('Fiat 147');
        $leilao->recebeLance(new Lance(New Usuario('Maria'), 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
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
            'ordem-decrescente' => [$leilao]
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
            'ordem-aleatoria' => [$leilao]
        ];
    }
}