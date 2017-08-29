
<?php
$titulodisciplina = "Direito Constitucional";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 152;

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

$temasMaisFrequentesBaseSuperior = 52 + 1;
$temasMaisFrequentesBaseInferior = 11 - 2;

$temasMaisFrequentes = array(
    array('ORGANIZAÇÃO DOS PODERES', 52),
    array('CONTROLE DE CONSTITUCIONALIDADE', 22),
    array('AÇÕES CONSTITUCIONAIS', 16),
    array('ORGANIZAÇÃO POLÍTICO ADMINISTRATIVA DO ESTADO', 15),
    array('DOS DIREITOS E GARANTIAS FUNDAMENTAIS', 11),
);

$temas = array(
    array('1.	TEORIA DA CONSTITUIÇÃO'),
    array('2.	PODER CONSTITUINTE'),
    array('3.	CONTROLE DE CONSTITUCIONALIDADE'),
    array('4.	DOS DIREITOS E GARANTIAS FUNDAMENTAIS'),
    array('5.	DIREITOS SOCIAIS'),
    array('6.	AÇÕES CONSTITUCIONAIS'),
    array('7.	DIREITO DE NACIONALIDADE'),
    array('8.	DIREITOS POLÍTICOS'),
    array('9.	ORGANIZAÇÃO POLÍTICO ADMINISTRATIVA DO ESTADO'),
    array('10.	PODER LEGISLATIVO'),
    array('11.	PODER EXECUTIVO'),
    array('12.	PODER JUDICIÁRIO'),
    array('13.	DA TRIBUTAÇÃO E DO ORÇAMENTO'),
    array('14.	DA ORDEM ECONÔMICA E FINANCEIRA'),
    array('15.	DA ORDEM SOCIAL'),
    array('16.	DA DEFESA DO ESTADO E DAS INSTITUIÇÕES DEMOCRÁTICAS'),
);


$temasJaExigidos = array(
    array('PODER CONSTITUINTE', 'XVII'),
    array('DIREITOS E GARANTIAS INDIVIDUAIS E COLETIVOS', 'III, IV, VI, XI, XII, XIV, XV, XVII, XVIII, XIX, XXI'),
    array('DIREITO DE NACIONALIDADE', 'V, VI, VII, XII, XV, XX (Salvador)'),
    array('DIREITOS POLÍTICOS', 'III, IV, VI, IX, X, XVI, XVIII, XIX, XX (Salvador)'),
    array('AÇÕES CONSTITUCIONAIS', 'V, IX, X, XI, XIV, XV, XX (Salvador)'),
    array('CONTROLE DE CONSTITUCIONALIDADE', 'II, III, IV, V, VI, VII, VIII, IX, X, XI, XII, XIV, XV, XVI, XVII, XVIII, XX, XX (Salvador),XXI'),
    array('ORGANIZAÇÃO POLÍTICO ADMINISTRATIVA DO ESTADO', 'II, III, IV, V, VII, VIII, IX, X, XII, XIV, XVI, XVIII, XIX, XX (Salvador),XXI'),
    array('PODER LEGISLATIVO', 'II, III, IV, V, VI, VII, VIII, IX, X, XII, XIV, XV, XVI, XIX, XX, XX (Salvador), XXI'),
    array('PODER JUDICIÁRIO', 'II, III, VI, VII, VIII, X, XI, XII, XV, XVII, XIX, XX, XX (Salvador)'),
    array('PODER EXECUTIVO', 'II, IV, V, VII, XV, XVII, XX'),
    array('DA ORDEM SOCIAL', 'IX, XI, XII'),
    array('DA DEFESA DO ESTADO E DAS INSTITUIÇÕES DEMOCRÁTICAS', 'XIV, XX'),
    array('TEORIA DA CONSTITUIÇÃO', 'XVI, XVII, XIX, XX (Salvador), XXI'),
    array('PODER CONSTITUINTE', 'XVII'),
    array('DIREITOS SOCIAIS', 'XXI'),
);

$temasNuncaExigidos = array(
    
);

$temasIncidencias = array(
    array('1', 'PODER LEGISLATIVO', 24, 'top-part'),
    array('2', 'CONTROLE DE CONSTITUCIONALIDADE', 22, 'top-part'),
    array('1', 'PODER JUDICIÁRIO', 19, 'top-part'),
    array('4', 'ORGANIZAÇÃO POLÍTICO ADMINISTRATIVA DO ESTADO', 17, 'top-part'),
    array('3', 'AÇÕES CONSTITUCIONAIS', 16, 'top-part'),
    array('5', 'DOS DIREITOS E GARANTIAS FUNDAMENTAIS', 12, 'top-part'),
    array('6', 'DIREITOS POLÍTICOS', 9, 'top-part'),
    array('6', 'PODER EXECUTIVO', 8, 'top-part'),
    array('9', 'TEORIA DA CONSTITUIÇÃO', 4, 'top-part'),
    array('7', 'DIREITO DE NACIONALIDADE', 6, 'top-part'),
    array('8', 'DA ORDEM SOCIAL', 4, 'top-part'),
    array('10', 'DA ORDEM ECONÔMICA E FINANCEIRA', 2, 'top-part'),
    array('11', 'DA DEFESA DO ESTADO E DAS INSTITUIÇÕES DEMOCRÁTICAS', 2, 'low-part'),
    array('12', 'DA TRIBUTAÇÃO E DO ORÇAMENTO', 1, 'low-part'),
    array('13', 'PODER CONSTITUINTE', 1, 'low-part'),
    array('13', 'DIREITOS SOCIAIS', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina de Direito Constitucional compõe o segundo grupo de disciplinas de maior relevância da prova, pois foi contemplada com 07 questões no último exame, o que corresponde à 17,5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Constitucional foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Organização dos Poderes”e “Controle de Constitucionalidade” correspondem a mais de 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
