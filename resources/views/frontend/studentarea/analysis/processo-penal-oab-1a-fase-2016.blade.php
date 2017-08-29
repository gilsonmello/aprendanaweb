
<?php

$titulodisciplina = "Direito Processual Penal";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 146;

$questoesNaDisciplina = 0;

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

$temasMaisFrequentesBaseSuperior = 22 + 1;
$temasMaisFrequentesBaseInferior = 11 - 2;

$temasMaisFrequentes = array(
        array('PROCEDIMENTOS DO CPP', 22 ),
        array('RECURSOS', 20 ),
        array('PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE', 18 ),
        array('INQUÉRITO POLICIAL E AÇÃO PENAL', 14 ),
        array('JURISDIÇÃO E COMPETÊNCIA', 11 ),
      );

$temas = array(
        array('1.	PRINCÍPIOS CONSTITUCIONAIS E PROCESSUAIS PENAIS'),
        array('2.	INQUÉRITO POLICIAL E AÇÃO PENAL'),
        array('3.	DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO'),
        array('4.	AÇÃO CIVIL EX DELICTO '),
        array('5.	 JURISDIÇÃO E COMPETÊNCIA'),
        array('6.	QUESTÕES E PROCESSOS INCIDENTES'),
        array('7.	DIREITO PROBATÓRIO'),
        array('8.	DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA'),
        array('9.	ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES'),
        array('10.	ATOS JUDICIAIS – DESPACHO, DECISÃO E SENTENÇA'),
        array('11.	DA PRISÃO E DEMAIS MEDIDAS CAUTELARES'),
        array('12.	LIBERDADE PROVISÓRIA'),
        array('13.	PROCEDIMENTOS DO CPP'),
        array('14.	PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE'),
        array('15.	NULIDADES '),
        array('16.	RECURSOS'),
        array('17.	AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO'),
);


$temasJaExigidos = array(
    array('PROCEDIMENTOS DO CPP', 'II, III, VI, VII, VIII, X, XI, XIII, XIX, XIV, XV, XVI, XVII, XX, XX (Salvador)'),
    array('RECURSOS', 'II, V, VI, VII VIII, IX, X, XI, XIIXV, XVI, XVII, XVIII, XIX, XX (Salvador)'),
    array('INQUÉRITO POLICIAL E AÇÃO PENAL', 'IV, V, VI, VII, X, XII, XIV, XVI, XVII, XVIII, XIV, XX'),
    array('JURISDIÇÃO E COMPETÊNCIA', ' V, IV, VII, XV, XIII, XVI, XVII'),
    array('PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE', 'II, III, IV, VIII, IX, XII, XIII, XVIII, XIX'),
    array('QUESTÕES E PROCESSOS INCIDENTES', 'IV, XVIII, X, XIV, XIX, XX (Salvador)'),
    array('PRINCÍPIOS CONSTITUCIONAIS E PROCESSUAIS PENAIS', 'VII, X, XI, XII'),
    array('DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO', 'XVIII, IV, XVII, XX'),
    array('DIREITO PROBATÓRIO', 'II, III,  V, XVII'),
    array('ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES', 'IV, XX (Salvador)'),
    array('ATOS JUDICIAIS – DESPACHO, DECISÃO E SENTENÇA', 'VI, XVIII'),
    array('DA PRISÃO E DEMAIS MEDIDAS CAUTELARES', 'III, IX, XVI, XX'),
    array('NULIDADES', 'III, V, XII'),
    array('AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO', 'XIV'),
    array('DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA', 'IV'),
    array('AÇÃO CIVIL EX DELICTO', 'II'),
    array('LIBERDADE PROVISÓRIA ', 'VIII, XX'),
);

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
        array('1', 'PROCEDIMENTOS DO CPP', 22, 'top-part' ),
        array('2', 'RECURSOS', 20, 'top-part' ),
        array('3', 'PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE', 18, 'top-part' ),
        array('4', 'INQUÉRITO POLICIAL E AÇÃO PENAL', 14, 'top-part' ),
        array('5', 'JURISDIÇÃO E COMPETÊNCIA', 11, 'top-part' ),
        array('6', 'QUESTÕES E PROCESSOS INCIDENTES', 8, 'top-part' ),
        array('7', 'PRINCÍPIOS CONSTITUCIONAIS E PROCESSUAIS PENAIS', 8, 'top-part' ),
        array('8', 'NULIDADES', 6, 'top-part' ),
        array('9', 'DIREITO PROBATÓRIO', 5, 'top-part' ),
        array('10', 'DA PRISÃO E DEMAIS MEDIDAS CAUTELARES ', 4, 'top-part' ),
        array('11', 'DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO', 4, 'low-part' ),
        array('12', 'ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES', 3, 'low-part' ),
        array('13', 'DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA', 2, 'low-part' ),
        array('14', 'ATOS JUDICIAIS – DESPACHO, DECISÃO E SENTENÇA', 1, 'low-part' ),
        array('15', 'AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO', 1, 'low-part' ),
        array('16', 'AÇÃO CIVIL EX DELICTO ', 1, 'low-part' ),
        array('17', 'LIBERDADE PROVISÓRIA', 1, 'low-part' ),
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
                    <p>De acordo com a tabela exposta, Direito Processual Penal compõe o quarto grupo de disciplinas de maior relevância para a prova, pois foi contemplado com 05 questões no último exame, o que corresponde a 12,5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa.</p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Processual Penal foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Procedimento do CPP”, “Recursos” e “Procedimentos especiais na legislação extravagante” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";

?>

@include( 'frontend.studentarea.analysis.body' )
