
<?php
$titulodisciplina = "Direito Tributário";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 101;

$questoesNaDisciplina = 85;

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

$temasMaisFrequentesBaseSuperior = 11 + 1;
$temasMaisFrequentesBaseInferior = 8 - 2;

$temasMaisFrequentes = array(
    array('PRINCÍPIOS DO DIREITO TRIBUTÁRIO', 11),
    array('EXTINÇÃO DO CRÉDITO TRIBUTÁRIO', 11),
    array('SISTEMA CONSTITUCIONAL TRIBUTÁRIO', 10),
    array('IMPOSTOS ESTADUAIS', 8),
    array('VIGÊNCIA E APLICAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA', 8),
);

$temas = array(
    array('2.	TRIBUTO'),
    array('3.	PRINCÍPIOS DO DIREITO TRIBUTÁRIO'),
    array('4.	SISTEMA CONSTITUCIONAL TRIBUTÁRIO'),
    array('5.	IMUNIDADE TRIBUTÁRIA'),
    array('6.	VIGÊNCIA E APLICAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA'),
    array('7.	INTERPRETAÇÃO E INTEGRAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA'),
    array('8.	OBRIGAÇÃO TRIBUTÁRIA'),
    array('8.	SUJEIÇÃO PASSIVA'),
    array('12.	EXTINÇÃO DO CRÉDITO TRIBUTÁRIO'),
    array('13.	EXCLUSÃO DO CRÉDITO TRIBUTÁRIO'),
    array('14.	GARANTIAS E PREFERÊNIAS DO CRÉDITO TRIBUTÁRIO'),
    array('15.	ADMINISTRAÇÃO TRIBUTÁRIA'),
    array('16.	IMPOSTOS FEDERAIS'),
    array('17.	IMPOSTOS ESTADUAIS'),
    array('18.	IMPOSTOS MUNICIPAIS'),
    array('19.	PROCESSO TRIBUTÁRIO'),
);


$temasJaExigidos = array(
    array('SISTEMA CONSTITUCIONAL TRIBUTÁRIO', 'III, IV, X, XIII, XIV, XV, XIX, XX'),
    array('SUJEIÇÃO PASSIVA', 'II, III, IV, VII, X, XII, XIII, XX (Salvador)'),
    array('PRINCÍPIOS DO DIREITO TRIBUTÁRIO', 'II, III, IV, V, VII, X, XI, XII, XIII, XVIII'),
    array('PROCESSO TRIBUTÁRIO', 'IV, VI, XVI, XIX'),
    array('EXTINÇÃO DO CRÉDITO TRIBUTÁRIO', 'III, VII, VIII, IX, XVI, XXI'),
    array('IMUNIDADE TRIBUTÁRIA', 'II, III, IX, X, XI, XX'),
    array('GARANTIAS E PREFERÊNCIAS DO CRÉDITO TRIBUTÁRIO', 'II,  VI, XVI, XIX'),
    array('VIGÊNCIA E APLICAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA', 'II, V, XVIII'),
    array('IMPOSTOS ESTADUAIS', 'I III, IV, V, XII, XIX, XXI'),
    array('IMPOSTOS MUNICIPAIS', 'II, III, XX'),
    array('DIREITO TRIBUTÁRIO', 'XVIII'),
    array('TRIBUTO', 'VII, VIII, XIII, XIV, XVI'),
    array('IMPOSTOS ESTADUAIS', 'III, IV, V, XI, XII, XIX, XX'),
    array('IMPOSTOS FEDERAIS', 'VIII, IX, XVIII, XX (Salvador)'),
    array('TRIBUTO', 'VII, VIII'),
    array('IMPOSTO MUNICIPAL', 'VII, VIII'),
    array('EXCLUSÃO DO CRÉDITO TRIBUTÁRIO', 'XVI, XVIII'),
    array('OBRIGAÇÃO TRIBUTÁRIA', 'XIII, X, XIII'),
    array('INTERPRETAÇÃO E INTEGRAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA', 'II'),
    array('ADMINISTRAÇÃO TRIBUTÁRIA', 'XV, XVII'),
);

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
    array('1', 'SISTEMA CONSTITUCIONAL TRIBUTÁRIO', 14, 'top-part'),
    array('2', 'SUJEIÇÃO PASSIVA', 12, 'top-part'),
    array('3', 'PRINCÍPIOS DO DIREITO TRIBUTÁRIO', 11, 'top-part'),
    array('4', 'PROCESSO TRIBUTÁRIO', 9, 'top-part'),
    array('5', 'EXTINÇÃO DO CRÉDITO TRIBUTÁRIO', 7, 'top-part'),
    array('6', 'IMUNIDADE TRIBUTÁRIA', 7, 'top-part'),
    array('7', 'GARANTIAS E PREFERÊNCIAS DO CRÉDITO TRIBUTÁRIO', 6, 'low-part'),
    array('8', 'VIGÊNCIA E APLICAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA', 6, 'top-part'),
    array('9', 'IMPOSTOS ESTADUAIS', 5, 'top-part'),
    array('10', 'IMPOSTOS FEDERAIS', 4, 'low-part'),
    array('11', 'TRIBUTO', 3, 'top-part'),
    array('12', 'IMPOSTOS MUNICIPAIS', 3, 'low-part'),
    array('13', 'EXCLUSÃO DO CRÉDITO TRIBUTÁRIO', 3, 'low-part'),
    array('14', 'ADMINISTRAÇÃO TRIBUTÁRIA', 2, 'low-part'),
    array('15', 'OBRIGAÇÃO TRIBUTÁRIA', 1, 'low-part'),
    array('16', 'INTERPRETAÇÃO E INTEGRAÇÃO DA LEGISLAÇÃO TRIBUTÁRIA', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina Direito Tributário corresponde a 10% da pontuação necessária para a aprovação do examinando na 1ª Fase, tendo sido contemplada com 04 questões na última prova objetiva.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Tributário foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Princípios do Direito Tributário”, “Extinção do crédito tributário”, “Sistema constitucional tributário ” e “Impostos Estaduais” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
