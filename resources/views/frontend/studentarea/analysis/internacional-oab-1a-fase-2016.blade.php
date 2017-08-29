
<?php

$titulodisciplina = "Direito Internacional";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 91;

$questoesNaDisciplina = 33;

$questoesPorProva = 80;

$questoesParaAprovacao = 40;

$disciplinas = array(
        array('ÉTICA', 10, 'top-part', 80),
        array('DIREITO CONSTITUCIONAL', 7, 'top-part', 60),
        array('DIREITO CIVIL', 	7, 'top-part', 60),
        array('DIREITO ADMINISTRATIVO', 6, 'top-part', 60),
        array('DIREITO PENAL', 6, 'top-part', 60),
        array('DIREITO DO TRABALHO',  	6, 'top-part', 60),
        array('DIREITO PROCESSUAL CIVIL', 	6, 'top-part', 60),
        array('DIREITO PROCESSUAL PENAL', 	5, 'top-part', 60),
        array('DIREITO PROCESSUAL DO TRABALHO', 	5, 'top-part', 60),
        array('DIREITO EMPRESARIAL',  	5, 'top-part', 60),
        array('DIREITO TRIBUTÁRIO', 	4, 'top-part', 60),
        array('DIREITOS HUMANOS', 	3, 'low-part', 60),
        array('DIREITO DO CONSUMIDOR', 	2, 'low-part', 60),
        array('DIREITO DA CRIANÇA E DO ADOLESCENTE', 	2, 'low-part', 60),
        array('DIREITO INTERNACIONAL',  	2, 'low-part', 60),
        array('DIREITO AMBIENTAL',  	2, 'low-part', 60),
        array('FILOSOFIA DO DIREITO', 	2, 'low-part', 60),

);

$temasMaisFrequentesBaseSuperior = 13 + 1;
$temasMaisFrequentesBaseInferior = 6 - 2;

$temasMaisFrequentes = array(
        array('DIREITO PROCESSUAL CIVIL INTERNACIONAL', 13 ),
        array('CONDIÇÃO JURÍDICA DO ESTRANGEIRO', 9 ),
        array('JURISDIÇÃO E COMPETÊNCIA', 8 ),
        array('DIREITO CIVIL INTERNACIONAL', 7 ),
        array('EXTRADIÇÃO, EXPULSÃO E DEPORTAÇÃO', 7 ),
      );

$temas = array(
        array('1.	INTRODUÇÃO AO DIREITO INTERNACIONAL'),
        array('2.	FONTES DO DIREITO INTERNACIONAL PÚBLICO'),
        array('3.	SUJEITOS DO DIREITO INTERNACIONAL PÚBLICO'),
        array('4.	O ESTADO'),
        array('5.	ORGANIZAÇÕES INTERNACIONAIS'),
        array('6.	DIREITO DOS TRATADOS'),
        array('7.	DIREITO DIPLOMÁTICO E CONSULAR'),
        array('8.	RESPONSABILIDADE INTERNACIONAL'),
        array('9.	DIREITO INTERNACIONAL ECONÔMICO'),
        array('10.	DIREITO DA INTEGRAÇÃO E DIREITO COMUNITÁRIO'),
        array('11.	DOMÍNIO PÚBLICO INTERNACIONAL E DIREITO INTERNACIONAL DO MAR'),
        array('12.	PROTEÇÃO INTERNACIONAL DOS DIREITOS HUMANOS'),
        array('13.	CARTA DA ONU'),
        array('14.	FUNDAMENTOS DO DIREITO INTERNACIONAL PRIVADO'),
        array('15.	NACIONALIDADE'),
        array('16.	CONDIÇÃO JURÍDICA DO ESTRANGEIRO'),
        array('17.	CONFLITO DE LEIS'),
        array('18.	DIREITO PROCESSUAL CIVIL INTERNACIONAL'),
        array('19.	DIREITO INTERNACIONAL DO TRABALHO'),
        array('20.	APLICAÇÃO DA LEI ESTRANGEIRA'),
        array('21.	DIREITO CIVIL INTERNACIONAL'),
        array('22.	JURISDIÇÃO E COMPETÊNCIA'),
        array('23.	EXTRADIÇÃO, EXPULSÃO E DEPORTAÇÃO'),
        array('24.	UNIÃO ESTÁVEL E CASAMENTO'),
        array('25.	DOMICÍLIO'),
);


$temasJaExigidos = array(
    array('FONTES DO DIREITO INTERNACIONAL', 'IV, XII'),
    array('O ESTADO', 'IV,  VII,XI,XII,  XIV  XVI'),
    array('ORGANIZAÇÕES INTERNACIONAIS', ' IV, XI XVI'),
    array('APLICAÇÃO DA LEI ESTRANGEIRA	EXAME','VI,  X, XVII, XX'),
    array('DIREITO INTERNACIONAL DO TRABALHO', 'V, VIII'),
    array('DIREITO CIVIL INTERNACIONAL', ' V, VI, IX, XV, XVII'),
    array('JURISDIÇÃO E COMPETÊNCIA ', 'II, III, VII, XII, XX, XX (Salvador), XXI'),
    array('EXTRADIÇÃO, EXPULSÃO E DEPORTAÇÃO  ', 'III, VIII, XIII, XIV, XV, XX (Salvador)'),
    array('SUJEITOS DO DIREITO INTERNACIONAL PÚBLICO', 'IV, XIV'),
    array('UNIÃO ESTÁVEL E CASAMENTO', ' V, XX'),
    array('DOMICÍLIO', 'V, XX, XX (Salvador)'),
    array('PROTEÇÃO INTERNACIONAL DOS DIREITOS HUMANOS', 'IX'),
    array('CARTA DA ONU', ' IX'),
    array('DOMÍNIO PÚBLICO INTERNACIONAL E DIREITO INTERNACIONAL DO MAR', 'VII'),
    array('NACIONALIDADE', ' X, XVII, XX (Salvador)'),
    array('CONDIÇÃO JURÍDICA DO ESTRANGEIRO', 'IV, VIII, XIII, XIV, XV, XVII, XX (Salvador)'),
    array('CONFLITO DE LEIS', ' II, III, VII, XII'),
    array('DIREITO PROCESSUAL CIVIL INTERNACIONAL', 'II,III, VII, XI,  XII, XVII, XVIII, XIX, XX, XX (Salvador)'),
    array('DIREITO INTERNACIONAL ECONÔMICO',' XIII'),
    array('FUNDAMENTOS DO DIREITO INTERNACIONAL PRIVADO', 'II, XV, XVIII'),
    array('RESPONSABILIDADE INTERNACIONAL', 'XIV'),
    array('DIREITO DIPLOMÁTICO E CONSULAR', 'XVI, XI'),
);

$temasNuncaExigidos = array(
    array('DIREITO DOS TRATADOS'),
    array('INTRODUÇÃO AO DIREITO INTERNACIONAL'),
    array('DIREITO DA INTEGRAÇÃO E DIREITO DOMUNITÁRIO'),
);

$temasIncidencias = array(
        array('1', 'DIREITO PROCESSUAL CIVIL INTERNACIONAL', 13, 'top-part' ),
        array('2', 'CONDIÇÃO JURÍDICA DO ESTRANGEIRO', 9, 'top-part' ),
        array('3', 'JURISDIÇÃO E COMPETÊNCIA ', 9, 'top-part' ),
        array('4', 'DIREITO CIVIL INTERNACIONAL', 7, 'top-part' ),
        array('5', 'EXTRADIÇÃO, EXPULSÃO E DEPORTAÇÃO  ', 7, 'top-part' ),
        array('6', 'O ESTADO', 6, 'top-part' ),
        array('7', 'FUNDAMENTOS DO DIREITO INTERNACIONAL PRIVADO', 5, 'top-part' ),
        array('8', 'ORGANIZAÇÕES INTERNACIONAIS', 4, 'top-part' ),
        array('9', 'CONFLITO DE LEIS', 4, 'top-part' ),
        array('10', 'NACIONALIDADE', 4, 'top-part' ),
        array('11', 'DIREITO DIPLOMÁTICO E CONSULAR', 4, 'low-part' ),
        array('12', 'APLICAÇÃO DA LEI ESTRANGEIRA', 3, 'low-part' ),
        array('13', 'DOMICÍLIO', 3, 'low-part' ),
        array('14', 'DIREITO INTERNACIONAL DO TRABALHO', 2, 'low-part' ),
        array('15', 'FONTES DO DIREITO INTERNACIONAL', 2, 'low-part' ),
        array('16', 'SUJEITOS DO DIREITO INTERNACIONAL', 2, 'low-part' ),
        array('17', 'UNIÃO ESTÁVEL E CASAMENTO', 2, 'low-part' ),
        array('18', 'CARTA DA ONU', 1, 'low-part' ),
        array('19', 'PROTEÇÃO INTERNACIONAL DOS DIREITOS HUMANOS', 1, 'low-part' ),
        array('20', 'DIREITO INTERNACIONAL ECONÔMICO', 1, 'low-part' ),
        array('21', 'RESPONSABILIDADE INTERNACIONAL', 1, 'low-part' ),
        array('22', 'DOMÍNIO PÚBLICO INTERNACIONAL E DIREITO INTERNACIONAL DO MAR', 1, 'low-part' ),
      );


$textVisaoGeralOAB = "
                    <p>O Exame de Ordem é um divisor de águas na vida do Bacharel em Direito. A partir da sua aprovação, ele deixa de ser um Bacharel para se tornar efetivamente Advogado. Por esta razão é que a aprovação no Exame de Ordem é tão almejada pelos candidatos.</p>
                    <p>O Exame de Ordem foi reconhecido pelo Supremo Tribunal Federal como instrumento de proficiência correto para aferir qualificação profissional ao Bacharel em Direito e tem por fim garantir as mínimas condições para o exercício da advocacia, sendo sua obrigatoriedade, portanto, constitucional.</p>
                    <p>Em 2010 ocorreu a unificação do Exame da OAB, passando a ser realizado simultaneamente nas 27 seccionais do país, três vezes por ano, em calendário fixado pela Diretoria do Conselho Federal da OAB.</p>
                    <p>Tão desejado quanto temido, o Exame de Ordem é bastante rigoroso na aprovação dos examinandos, buscando oferecer ao mercado profissionais qualificados para o exercício da advocacia, uma atividade indispensável à administração da justiça. Esse rigor se reflete nos altos índices de reprovação, que chegam a ultrapassar o percentual de 80%!</p>
                    <p>Aliada à rigidez excessiva, há a ausência de um conteúdo programático especificando os temas das disciplinas que serão exigidos na primeira fase do Exame, dificultando ainda mais o estudo do examinando.</p>
                    <p>Diante desse cenário urge a necessidade de um estudo direcionado, que se propõe a indicar para o examinando todos os aspectos mais relevantes do Exame, de modo que ele possa nortear seu estudo para aquilo que seja essencial à sua aprovação.</p>
                    <p>O Exame possui 17 disciplinas na 1ª Fase, que estavam dispostas da seguinte maneira na última prova (XIX Exame de Ordem):</p>
";


$textVisaoGeralDisciplina = "
                    <p>De acordo com a tabela exposta, a disciplina de Direito Internacional compõe o grupo de disciplinas que foram contempladas com 02 questões no último Exame, o que corresponde a 5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Internacional foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os cinco primeiros temas correspondem a praticamente 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";

?>

@include( 'frontend.studentarea.analysis.body' )
