
<?php
$titulodisciplina = "Ética";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 222;

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


$temasMaisFrequentesBaseSuperior = 46 + 1;
$temasMaisFrequentesBaseInferior = 13 - 2;

$temasMaisFrequentes = array(
    array('DAS PRERROGATIVAS DOS ADVOGADOS', 46),
    array('DAS INFRAÇÕES E SANÇÕES DISCIPLINARES', 27),
    array('DAS INCOMPATIBILIDADES E IMPEDIMENTOS', 19),
    array('DOS HONORÁRIOS', 19),
    array('DO MANDATO JUDICIAL', 13),
);


$temas = array(
    array('1.	ADVOCACIA E ATIVIDADES PRIVATIVAS DA ADVOCACIA'),
    array('2.	DA INSCRIÇÃO NA OAB'),
    array('3.	DO ESTÁGIO PROFISSIONAL'),
    array('4.	DO MANDATO JUDICIAL'),
    array('5.	DAS PRERROGATIVAS DO ADVOGADO'),
    array('6.	DA SOCIEDADE DE ADVOGADO'),
    array('7.	ADVOGADO EMPREGADO'),
    array('8.	DOS HONORÁRIOS ADVOCATÍCIOS'),
    array('9.	DAS INCOMPATIBILIDADES E IMPEDIMENTOS'),
    array('10.	DAS INFRAÇÕES E SANÇÕES DISCIPLINARES'),
    array('11.	PROCESSO DISCIPLINAR'),
    array('12.	DA ORDEM DOS ADVOGADOS DO BRASIL E SUA ESTRUTURA'),
    array('13.	ELEIÇÃO E MANDATO NA OAB'),
    array('14.	SIGILO PROFISSIONAL'),
    array('15.	PUBLICIDADE NA ADVOCACIA'),
    array('16.	PRINCÍPIOS FUNDAMENTAIS'),);


$temasJaExigidos = array(
    array('ADVOCACIA E ATIVIDADES PRIVATIVAS DA ADVOCACIA', 'VI, VII, VIII, IX, XI, XVI, XVII'),
    array('DA INSCRIÇÃO NA OAB', 'IV, V, VI, VIII, IX, XVII, XIX'),
    array('DO ESTÁGIO PROFISSIONAL', 'IV, VII, IX, XI, XII, XIV, XVIII, XX (Salvador)'),
    array('DO MANDATO JUDICIAL', ' XI, XII, XIII, XIV, XV, XVI, XVII,  XVIII, XX (Salvador),XXI'),
    array('DAS PRERROGATIVAS DO ADVOGADO', 'II, III, IV, V, VI, VII, X, XI, XII, XIII, XIV, XVI, XVII, XVIII, XIX, XX, XX (Salvador), XXI'),
    array('DA SOCIEDADE DE ADVOGADO', 'II, IV, VII, IX, XI, XII, XV, XVIII'),
    array('ADVOGADO EMPREGADO', 'VI '),
    array('DOS HONORÁRIOS', 'II, III, IV, VI, VII, VIII, IX, X, XI, XII, XIII, XV, XVII, XVIII, XIX, XX, XX (Salvador), XXI'),
    array('DAS INCOMPATIBILIDADES E IMPEDIMENTOS', 'II, III, IV, VII, VIII, X, XII, XIII, XIV, XV, XVII, XIX, XX (Salvador) '),
    array('DAS INFRAÇÕES E SANÇÕES DISCIPLINARES', ' II, III, IV, V, VI, VII, VIII, IX, X, XII,XIV, XV, XVI, XVII, XIX,  XX, XX (Salvador)'),
    array('PROCESSO DISCIPLINAR', ' III, V, VI, IX, XI, XV, XVIII, XX, XXI'),
    array('DA ORDEM DOS ADVOGADOS DO BRASIL E SUA ESTRUTURA', 'IV, VII, VIII, IX, XII, XIII, XVI, XIX, XX, XXI'),
    array('SIGILO PROFISSIONAL', 'III, IV, V, VI, IX, XIII, XIV, XVI, XX, XXI'),
    array('PUBLICIDADE NA ADVOCACIA', 'II, III VI, VIII, XII, XIII, XIV, XVI, XVII, XX (Salvador), XXI'),
    array('PRINCÍPIOS FUNDAMENTAIS', 'III, V, X, XI, XV, XIX, XXI'),
    array('ELEIÇÕES E MANDATO NA OAB', 'XV, XIX, XX'),
);

$temasNuncaExigidos = array();

$temasIncidencias = array(
    array('1', 'DAS PRERROGATIVAS DOS ADVOGADOS', 47, 'top-part'),
    array('2', 'DAS INFRAÇÕES E SANÇÕES DISCIPLINARES', 27, 'top-part'),
    array('3', 'DOS HONORÁRIOS', 20, 'top-part'),
    array('4', 'DAS INCOMPATIBILIDADES E IMPEDIMENTOS', 19, 'top-part'),
    array('5', 'DO MANDATO JUDICIAL', 15, 'top-part'),
    array('6', 'ADVOCACIA E ATIVIDADES PRIVATIVAS DA ADVOCACIA', 12, 'top-part'),
    array('7', 'PUBLICIDADE NA ADVOCACIA', 12, 'top-part'),
    array('8', 'DA SOCIEDADE DE ADVOGADO', 10, 'top-part'),
    array('9', 'SIGILO PROFISSIONAL', 10, 'top-part'),
    array('10', 'DA ORDEM DOS ADVOGADOS DO BRASIL E SUA ESTRUTURA',10, 'top-part'),
    array('11', 'PROCESSO DISCIPLINAR', 10, 'low-part'),
    array('12', 'PRINCIPIOS FUNDAMENTAIS', 10, 'low-part'),
    array('13', 'DO ESTÁGIO PROFISSIONAL', 8, 'low-part'),
    array('14', 'DA INSCRIÇÃO NA OAB', 6, 'low-part'),
    array('15', 'ELEIÇÕES E MANDATO NA OAB', 5, 'low-part'),
    array('16', 'ADVOGADO EMPREGADO', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, Ética é a disciplina mais importante da prova, pois, com maior número de questões (10), corresponde à 25% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa.</p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Estatuto de Ética e Disciplina foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Das prerrogativas dos Advogados”, “Das infrações e sanções disciplinares”, “Dos honorários” e “Das incompatibilidades e impedimentos” correspondem a pouco mais de 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
