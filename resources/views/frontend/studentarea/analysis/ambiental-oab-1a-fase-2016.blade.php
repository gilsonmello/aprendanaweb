
<?php

$titulodisciplina = "Direito Ambiental";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 57;

$questoesNaDisciplina = 36;

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

$temasMaisFrequentesBaseSuperior = 8 + 1;
$temasMaisFrequentesBaseInferior = 5 - 2;

$temasMaisFrequentes = array(
        array('SISTEMA NACIONAL DE UNIDADES DE CONSERVAÇÃO DA NATUREZA', 8 ),
        array('POLÍTICA NACIONAL DO MEIO AMBIENTE', 7 ),
        array('LICENCIAMENTO AMBIENTAL', 6 ),
        array('ESTUDO DE IMPACTO AMBIENTAL', 6 ),
        array('RESPONSABILIDADE CIVIL/ADMINISTRATIVA AMBIENTAL', 5 ),
      );

$temas = array(
        array('1.	FONTES DO DIREITO AMBIENTAL'),
        array('2.	CONCEITO JURÍDICO DO MEIO AMBIENTE'),
        array('3.	PRINCÍPIOS DO DIREITO AMBIENTAL'),
        array('4.	PROTEÇÃO CONSTITUCIONAL DO MEIO AMBIENTE'),
        array('5.	REPARTIÇÃO DE COMPETÊNCIAS EM MATÉRIA AMBIETAL'),
        array('6.	POLÍTICA NACIONAL DO MEIO AMBIENTE'),
        array('7.	SISTEMA NACIONAL DO MEIO AMBIENTE'),
        array('8.	LICENCIAMENTO AMBIENTAL'),
        array('9.	ESTUDO DE IMPACTO AMBIENTAL'),
        array('10.	POLÍTICA NACIONAL DE RECURSOS HÍDRICOS'),
        array('11.	CÓDIGO FLORESTAL'),
        array('12.	SISTEMA NACIONAL DE UNIDADES DE CONSERVAÇÃO DA NATUREZA'),
        array('13.	MEIO AMBIENTE ARTIFICIAL'),
        array('14.	MEIO AMBIENTE DO TRABALHO'),
        array('15.	RESPONSABILIDADE CIVIL/ADMINISTRATIVA AMBIENTAL'),
        array('16.	RESPONSABILIDADE PENAL AMBIENTAL'),
        array('17.	TUTELA PROCESSUAL DO MEIO AMBIENTE – PROCESSO COLETIVO AMBIENTAL'),
        array('18.	TRIBUTAÇÃO AMBIENTAL'),
        array('19.	PATRIMÔNIO CULTURAL'),
);


$temasJaExigidos = array(
    array('PRINCÍPIOS DO DIREITO AMBIENTAL', 'X'),
    array('PROTEÇÃO CONSTITUCIONAL DO MEIO AMBIENTE', 'IV, XII'),
    array('REPARTIÇÃO DE COMPETÊNCIAS EM MATÉRIA AMBIETAL', 'II, VII, IX, XVII, XX (Salvador)'),
    array('LICENCIAMENTO AMBIENTAL', 'III, IV, VII, XI, XIV, XV, XXI'),
    array('ESTUDO DE IMPACTO AMBIENTAL', 'III,VII, X, XI, XVI, XVIII'),
    array('SISTEMA NACIONAL DE UNIDADES DE CONSERVAÇÃO DA NATUREZA', 'III, VI, VIII, XIII, XVII, XIX, XX (Salvador)'),
    array('RESPONSABILIDADE CIVIL/ADMINISTRATIVA AMBIENTAL', 'V, IX, X, XV, XIX'),
    array('RESPONSABILIDADE PENAL AMBIENTAL', 'II, V, VIII'),
    array('CÓDIGO FLORESTAL', 'XIV, XVI, XVIII, XXI'),
    array('POLÍTICA NACIONAL DE RECURSOS HÍDRICOS', 'XIII'),
    array('POLÍTICA NACIONAL DO MEIO AMBIENTE', 'III, IV, VII, XI, XII, XX'),
    array('SISTEMA NACIONAL DO MEIO AMBIENTE', 'IV, XV, XI, XVIII'),
    array('TRIBUTAÇÃO AMBIENTAL', 'XII'),
    array('PATRIMÔNIO CULTURAL', 'XIX'),
    array('TUTELA PROCESSUAL DO MEIO AMBIENTE – PROCESSO COLETIVO AMBIENTAL', 'XX'),
);

$temasNuncaExigidos = array(
    array('FONTES DO DIREITO AMBIENTAL'),
    array('CONCEITO JURÍDICO DO MEIO AMBIENTE'),
    array('MEIO AMBIENTE ARTIFICIAL'),
    array('MEIO AMBIENTE DO TRABALHO'),
);

$temasIncidencias = array(
        array('1', 'SISTEMA NACIONAL DE UNIDADES DE CONSERVAÇÃO DA NATUREZA', 8, 'top-part' ),
        array('2', 'POLÍTICA NACIONAL DO MEIO AMBIENTE', 7, 'top-part' ),
        array('3', 'LICENCIAMENTO AMBIENTAL', 7, 'top-part' ),
        array('4', 'ESTUDO DE IMPACTO AMBIENTAL', 6, 'top-part' ),
        array('5', 'RESPONSABILIDADE CIVIL/ADMINISTRATIVA AMBIENTAL', 5, 'top-part' ),
        array('6', 'REPARTIÇÃO DE COMPETÊNCIAS EM MATÉRIA AMBIETAL', 5, 'top-part' ),
        array('7', 'SISTEMA NACIONAL DO MEIO AMBIENTE', 4, 'top-part' ),
        array('8', 'RESPONSABILIDADE PENAL AMBIENTAL', 4, 'top-part' ),
        array('9', 'CÓDIGO FLORESTAL', 4, 'top-part' ),
        array('10', 'PROTEÇÃO CONSTITUCIONAL DO MEIO AMBIENTE', 2, 'top-part' ),
        array('11', 'TRIBUTAÇÃO AMBIENTAL', 1, 'low-part' ),
        array('12', 'PATRIMÔNIO CULTURAL', 1, 'low-part' ),
        array('13', 'PRINCÍPIOS DO DIREITO AMBIENTAL', 1, 'low-part' ),
        array('14', 'POLÍTICA NACIONAL DE RECURSOS HÍDRICOS', 1, 'low-part' ),
        array('15', 'TUTELA PROCESSUAL DO MEIO AMBIENTE – PROCESSO COLETIVO AMBIENTAL', 1, 'low-part' ),
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
                    <p>De acordo com a tabela exposta, a disciplina de Direito Ambiental compõe o grupo de disciplinas que foram contempladas com 02 questões no último Exame, o que corresponde a 5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Ambiental foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Sistema nacional de unidades de conservação”, “Licenciamento ambiental”, “Estudo de impacto ambiental” e “Política ambiental do meio ambiente” correspondem a 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";

?>

@include( 'frontend.studentarea.analysis.body' )
