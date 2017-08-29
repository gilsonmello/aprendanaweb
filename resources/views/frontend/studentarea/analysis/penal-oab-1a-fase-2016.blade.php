
<?php
$titulodisciplina = "Direito Penal";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 254;

$questoesNaDisciplina = 0;

$questoesPorProva = 80;

$questoesParaAprovacao = 40;

$disciplinas = array(
    array('ÉTICA', 10, 'top-part', 80),
    array('DIREITO CONSTITUCIONAL', 7, 'top-part', 60),
    array('DIREITO CIVIL', 7, 'top-part', 60),
    array('DIREITO ADMINISTRATIVO', 6, 'top-part', 60),
    array('DIREITO PENAL', 6, 'top-part', 60),
    array('DIREITO DO TRABALHO', 6, 'top-part', 60),
    array('DIREITO PROCESSUAL CIVIL', 6, 'top-part', 60),
    array('DIREITO PROCESSUAL PENAL', 5, 'top-part', 60),
    array('DIREITO PROCESSUAL DO TRABALHO', 5, 'top-part', 60),
    array('DIREITO EMPRESARIAL', 5, 'top-part', 60),
    array('DIREITO TRIBUTÁRIO', 4, 'top-part', 60),
    array('DIREITOS HUMANOS', 3, 'low-part', 60),
    array('DIREITO DO CONSUMIDOR', 2, 'low-part', 60),
    array('DIREITO DA CRIANÇA E DO ADOLESCENTE', 2, 'low-part', 60),
    array('DIREITO INTERNACIONAL', 2, 'low-part', 60),
    array('DIREITO AMBIENTAL', 2, 'low-part', 60),
    array('FILOSOFIA DO DIREITO', 2, 'low-part', 60),
);


$temasMaisFrequentesBaseSuperior = 53 + 1;
$temasMaisFrequentesBaseInferior = 12 - 2;

$temasMaisFrequentes = array(
    array('CRIME EM ESPECIE', 53),
    array('TEORIA GERAL DO DELITO', 30),
    array('TIPO PENAL DOLOSO', 14),
    array('PENAS E SEUS CRITERIOS DE APLICAÇÃO', 13),
    array('CONCURSO DE CRIMES', 12),
);


$temas = array(
    array('1.	INQUÉRITO POLICIAL E AÇÃO PENAL'),
    array('2.	DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO'),
    array('3.	PRINCÍPIOS CONSTITUICIONAIS E PROCESSUAIS PENAIS'),
    array('4.	AÇÃO CIVIL EX DELICTO'),
    array('5.	JURISDIÇÃO E COMPETÊNCIA'),
    array('6.	QUESTÕES E PROCESSOS INCIDENTAIS'),
    array('7.	DIREITO PROBATÓRIO'),
    array('8.	DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA'),
    array('9.	DA PRISÃO E DEMAIS MEDIDAS CAUTELARES'),
    array('10.	LIBERDADE PROVISÓRIA'),
    array('11.	PROCEDIMENTOS DO CPP '),
    array('12.	ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES'),
    array('13.	ATOS JUDICIAIS - DESPACHO, DECISÃO E SENTENÇA'),
    array('14.	PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE'),
    array('15.	NULIDADES'),
    array('16.	RECURSOS'),
    array('17.	AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO'),
);


$temasJaExigidos = array(
    array('INQUÉRITO POLICIAL E AÇÃO PENAL', 'IV, V, VI, VII, IX, X, XII, XIV, XVI, XVII, XVIII, XIX'),
    array('DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO', 'X e XVII'),
    array('PRINCÍPIOS CONSTITUICIONAIS E PROCESSUAIS PENAIS ', 'II, XI, XII e XIX'),
    array('AÇÃO CIVIL EX DELICTO ', 'II'),
    array('JURISDIÇÃO E COMPETÊNCIA ', 'IV, V, VII, XIII, XIV, XVI, XVII, XX (Salvador), XXI'),
    array('QUESTÕES E PROCESSOS INCIDENTAIS ', 'IV, XVI, XVIII e XX (Unificado), XXI'),
    array('DIREITO PROBATÓRIO ', 'II, V, XV, XVIII e  XIX'),
    array('DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA', 'XIII'),
    array('DA PRISÃO E DEMAIS MEDIDAS CAUTELARES', 'III, VIII, IX, X, XIV, XV, XVI,  XX, XXI'),
    array('PROCEDIMENTOS DO CPP', 'II, III, VII, VIII, X, XI, XIII, XV e XX (Unificado e Salvador)'),
    array('ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES', 'IV, XIII, XVIII, XX (Salvador), XXI'),
    array('ATOS JUDICIAIS - DESPACHO, DECISÃO E SENTENÇA', 'III e XV'),
    array('PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE ', 'VII, IX, XI, XIII, XV, XVIII e XIX'),
    array('NULIDADES', 'III, V, VI e VII'),
    array('RECURSOS', 'II, III, V, VI, VII, VIII, IX, X, XI, XII, XVI e XX (Unificado e Salvador)'),
    array('AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO ', 'XIV e XX (Unificado)'),
);

$temasNuncaExigidos = array(
    array('LIBERDADE PROVISÓRIA'),
);

$temasIncidencias = array(
    array('1', 'RECURSOS', 17, 'top-part'),
    array('2', 'INQUÉRITO POLICIAL E AÇÃO PENAL', 16, 'top-part'),
    array('3', 'PROCEDIMENTOS DO CPP', 13, 'top-part'),
    array('4', 'JURISDIÇÃO E COMPETÊNCIA', 12, 'top-part'),
    array('5', 'DA PRISÃO E DEMAIS MEDIDAS CAUTELARES', 10, 'top-part'),
    array('6', 'PROCEDIMENTOS ESPECIAIS NA LEGISLAÇÃO EXTRAVAGANTE', 8, 'top-part'),
    array('7', 'DIREITO PROBATÓRIO ', 6, 'top-part'),
    array('8', 'QUESTÕES E PROCESSOS INCIDENTAIS ', 6, 'top-part'),
    array('9', 'ATOS DE COMUNICAÇÃO NO PROCESSO - DAS CITAÇÕES E INTIMAÇÕES', 6, 'top-part'),
    array('10', 'PRINCÍPIOS CONSTITUICIONAIS E PROCESSUAIS PENAIS ', 4, 'top-part'),
    array('11', 'NULIDADES', 4, 'top-part'),
    array('11', 'AÇÕES AUTÔNOMAS DE IMPUGNAÇÃO ', 2, 'top-part'),
    array('13', 'DENÚNCIA, QUEIXA-CRIME E REPRESENTAÇÃO', 2, 'top-part'),
    array('14', 'ATOS JUDICIAIS - DESPACHO, DECISÃO E SENTENÇA', 2, 'top-part'),
    array('15', 'DO JUIZ, DO MINISTÉRIO PÚBLICO, DO ACUSADO E DEFENSOR, DOS ASSISTENTES E AUXILIARES DA JUSTIÇA', 1, 'top-part'),
    array('16', 'AÇÃO CIVIL EX DELICTO', 1, 'top-part'),
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
                    <p>De acordo com a tabela exposta, Direito Penal compõe o terceiro grupo de disciplinas mais importantes da prova, pois foi contemplada com 06 questões no último exame, o que corresponde à 15% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa.</p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Penal foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Crimes em espécie” e “Teoria geral do delito” correspondem a um quarto do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
