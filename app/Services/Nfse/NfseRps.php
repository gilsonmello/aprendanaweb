<?php

/**
 * Value Object class for RPS
 *
 * @package   NFePHPaulista
 * @author Reinaldo Nolasco Sanches <reinaldo@mandic.com.br>
 * @copyright Copyright (c) 2010, Reinaldo Nolasco Sanches
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class NfseRps
{
    public $CCM; // CCM do prestador
    public $serie;
    public $numero;

    /* RPS � Recibo Provis�rio de Servi�os
     * RPS-M � Recibo Provis�rio de Servi�os proveniente de Nota Fiscal Conjugada (Mista)
     * RPS-C � Cupom */
    public $type = 'RPS';

    public $dataEmissao;

    /* N � Normal
     * C � Cancelada
     * E � Extraviada */
    public $status = 'N';

    /* T - Tributa��o no munic�pio de S�o Paulo
     * F - Tributa��o fora do munic�pio de S�o Paulo
     * I �- Isento
     * J - ISS Suspenso por Decis�o Judicial */
    public $tributacao = 'I'; // I have problem with F and J options

    public $valorServicos = 0;
    public $valorDeducoes = 0;

    public $codigoServico;
    public $aliquotaServicos; //Al�quota dos Servi�os

    public $comISSRetido = false; // ISS retido

    public $contractorRPS; // new ContractorRPS

    public $discriminacao;   // Discrimina��o dos servi�os
}

/**
 * Value Object class for Contractor
 *
 * @author Reinaldo Nolasco Sanches <reinaldo@mandic.com>
 */
class ContractorRPS
{
    public $cnpjTomador; // CPF/CNPJ
    public $ccmTomador; // CCM

    public $type = 'C'; // C = Corporate (CNPJ), F = Personal (CPF)

    public $name;

    public $tipoEndereco;
    public $endereco;
    public $enderecoNumero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;

    public $email;
    public $email2;
}