
<?php
$titulodisciplina = "Direitos Humanos";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 19;

$questoes = 61;

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

$temasMaisFrequentesBaseSuperior = 16 + 1;
$temasMaisFrequentesBaseInferior = 6 - 2;

$temasMaisFrequentes = array(
    array('SISTEMA INTERAMERICANO DE DIREITOS HUMANOS', 16),
    array('ORDEM JURÍDICA BRASILEIRA E ALGUNS DIREITOS HUMANOS', 13),
    array('DIREITO INTERNACIONAL DOS DIREITOS HUMANOS', 10),
    array('TEORIA GERAL DOS DIREITOS HUMANOS', 6),
    array('CONSTITUIÇÃO DE 1988 E OS DIREITOS HUMANOS', 6),
);

$temas = array(
    array('1.	TEORIA GERAL DOS DIREITOS HUMANOS'),
    array('2.	CONSTITUIÇÃO DE 1988 E OS DIREITOS HUMANOS'),
    array('3.	DIREITO INTERNACIONAL DOS DIREITOS HUMANOS'),
    array('4.	SISTEMA GLOBAL/UNIVERSAL DOS DIREITOS HUMANOS'),
    array('5.	SISTEMA INTERAMERICANO DE DIREITOS HUMANOS'),
    array('6.	OUTROS SISTEMAS INTERNACIONAIS DE DIREITOS HUMANOS'),
    array('7.   ORDEM JURÍDICA BRASILEIRA E ALGUNS DIREITOS HUMANOS'),
);


$temasJaExigidos = array(
    array('TEORIA GERAL DOS DIREITOS HUMANOS', 'IV,  XI, XII, XIII, XIX'),
    array('CONSTITUIÇÃO DE 1988 E OS DIREITOS HUMANOS', 'IV, V, X, XIII, XX, XXI'),
    array('DIREITO INTERNACIONAL DOS DIREITOS HUMANOS', 'IV, VI, IX, XV, XVI, XX (Salvador)'),
    array('SISTEMA GLOBAL/UNIVERSAL DOS DIREITOS HUMANOS', 'VIII, X, XI, XIII, XVI, XX'),
    array('SISTEMA INTERAMERICANO DE DIREITOS HUMANOS', 'VI, VII, VIII, IX, X, XI, XII, XIII. XIV, XV, XVII, XVIII, XX, XX (Salvador), XXI '),
    array('ORDEM JURÍDICA BRASILEIRA E ALGUNS DIREITOS HUMANOS', 'VII, VIII, X, XII, XIII, XIV, XVI, XVII, XVIII, XIX, XXI'),
    array('OUTROS SISTEMAS INTERNACIONAIS DE DIREITOS HUMANOS', 'XV'),
);

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
    array('1', 'SISTEMA INTERAMERICANO DE DIREITOS HUMANOS', 17, 'top-part'),
    array('2', 'ORDEM JURÍDICA BRASILEIRA E ALGUNS DIREITOS HUMANOS', 14, 'top-part'),
    array('3', 'DIREITO INTERNACIONAL DOS DIREITOS HUMANOS', 10, 'top-part'),
    array('5', 'CONSTITUIÇÃO DE 1988 E OS DIREITOS HUMANOS', 6, 'top-part'),
    array('4', 'TEORIA GERAL DOS DIREITOS HUMANOS', 6, 'top-part'),
    array('6', 'SISTEMA GLOBAL/UNIVERSAL DOS DIREITOS HUMANOS', 6, 'low-part'),
    array('7', 'OUTROS SISTEMAS INTERNACIONAIS DE DIREITOS HUMANOS', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina Direitos Humanos corresponde a 7,5% da pontuação necessária para a aprovação do examinando na 1ª Fase, tendo sido contemplada com 03 questões na última prova objetiva.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direitos Humanos foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Sistema Interamericano de Direitos Humanos” e “Ordem jurídica brasileira e alguns direitos humanos” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
