
<?php

$titulodisciplina = "Direito da Criança e do Adolescente";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 42;

$questoesNaDisciplina = 40;

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

$temasMaisFrequentesBaseSuperior = 10 + 1;
$temasMaisFrequentesBaseInferior = 3 - 2;

$temasMaisFrequentes = array(
        array('FAMÍLIA SUBSTITUTA', 12 ),
        array('MEDIDAS SOCIOEDUCATIVAS', 5 ),
        array('DIREITO À CONVIVÊNCIA FAMILIAR', 5 ),
        array('PRÁTICA DE ATO INFRACIONAL', 4 ),
        array('PREVENÇÃO', 3 ),
      );

$temas = array(
        array('1.	DIREITOS FUNDAMENTAIS'),
        array('2.	DIREITO À CONVIVÊNCIA FAMILIAR'),
        array('3.	FAMÍLIA SUBSTITUTA'),
        array('4.	EDUCAÇÃO'),
        array('5.	PROFISSIONALIZAÇÃO E PROTEÇÃO AO TRABALHO'),
        array('6.	PREVENÇÃO'),
        array('7.	POLÍTICA DE ATENDIMENTO'),
        array('8.	MEDIDAS DE PROTEÇÃO'),
        array('9.	PRÁTICA DE ATO INFRACIONAL'),
        array('10.	MEDIDAS SOCIOEDUCATIVAS'),
        array('11.	REMISSÃO'),
        array('12.	MEDIDAS PERTINENTES AOS PAIS E RESPONSÁVEIS'),
        array('13.	CONSELHOR TUTELAR'),
        array('14.	JUSTIÇA DA INFÂNCIA E DA JUVENTUDE'),
        array('15.	APURAÇÃO DE ATO INFRACIONAL'),
        array('16.	RECURSOS'),
        array('17.	MINISTÉRIO PÚBLICO, ADVOCACIA E TUTELA DE DIREITOS'),
        array('18.	CRIMES E INFRAÇÕES ADMINISTRATIVAS'),
        array('19.	SINASE'),
        array('20.	ESTATUTO DA PRIMEIRA INFÂNCIA (Lei 13.257/16)'),
);


$temasJaExigidos = array(
    array('DIREITO À CONVIVÊNCIA FAMILIAR', 'III'),
    array('FAMÍLIA SUBSTITUTA', 'II, V, VI, IX, X, XII, XV, XVI, XVIII, XX, XX (Salvador),XXI'),
    array('EDUCAÇÃO', 'VII'),
    array('PROFISSIONALIZAÇÃO E PROTEÇÃO AO TRABALHO', 'IV'),
    array('PREVENÇÃO', 'VIII, IX, XIII'),
    array('MEDIDAS DE PROTEÇÃO', 'XI, XII'),
    array('PRÁTICA DE ATO INFRACIONAL', 'III, XVIII, XIX, XX (Salvador)'),
    array('MEDIDAS SOCIOEDUCATIVAS', 'IV, VI, VII, X, XVII'),
    array('CONSELHO TUTELAR', 'VIII, XVII'),
    array('JUSTIÇA DA INFÂNCIA E DA JUVENTUDE', 'V, XI, XVI'),
    array('CRIMES E INFRAÇÕES ADMINISTRATIVAS', 'XIV, XV'),
    array('MEDIDAS PERTINENTES AOS PAIS E RESPONSÁVEIS', 'XX, XXI'),
    array('MINISTÉRIO PÚBLICO, ADVOCACIA E TUTELA DE DIREITOS', 'XV'),
);

$temasNuncaExigidos = array(
    array('DIREITOS FUNDAMENTAIS'),
    array('POLÍTICA DE ATENDIMENTO'),
    array('REMISSÃO'),
    array('APURAÇÃO DE ATO INFRACIONAL'),
    array('RECURSOS'),
    array('SINASE'),
    array('ESTATUTO DA PRIMEIRA INFÂNCIA(Lei 13.257/16)'),
);

$temasIncidencias = array(
        array('1', 'FAMÍLIA SUBSTITUTA', 13, 'top-part' ),
        array('2', 'MEDIDAS SOCIOEDUCATIVAS', 5, 'top-part' ),
        array('3', 'DIREITO À CONVIVÊNCIA FAMILIAR', 5, 'top-part' ),
        array('4', 'PRÁTICA DE ATO INFRACIONAL', 4, 'top-part' ),
        array('5', 'PREVENÇÃO', 3, 'top-part' ),
        array('6', 'DIREITOS FUNDAMENTAIS', 2, 'top-part' ),
        array('7', 'POLÍTICA DE ATENDIMENTO', 2, 'top-part' ),
        array('8', 'CONSELHOR TUTELAR', 2, 'top-part' ),
        array('9', 'CRIMES E INFRAÇÕES ADMINISTRATIVAS', 2, 'top-part' ),
        array('10', 'EDUCAÇÃO', 1, 'top-part' ),
        array('11', 'PROFISSIONALIZAÇÃO E PROTEÇÃO AO TRABALHO', 1, 'low-part' ),
        array('12', 'MEDIDAS DE PROTEÇÃO', 1, 'low-part' ),
        array('13', 'JUSTIÇA DA INFÂNCIA E DA JUVENTUDE', 1, 'low-part' ),
        array('14', 'APURAÇÃO DE ATO INFRACIONAL', 1, 'low-part' ),
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
                    <p>De acordo com a tabela exposta,  a disciplina de Direito da Criança e do Adolescente está no grupo de disciplinas que foram contempladas com 02 questões no último Exame, o que corresponde a 5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito da Criança e do Adolescente foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Família Substituta”, “Medidas socioeducativas” e “Direito à convivência familiar” correspondem a 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";

?>

@include( 'frontend.studentarea.analysis.body' )
