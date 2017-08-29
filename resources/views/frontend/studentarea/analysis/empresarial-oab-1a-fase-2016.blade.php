
<?php
$titulodisciplina = "Direito Empresarial";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 96;

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
$temasMaisFrequentesBaseSuperior = 25 + 1;
$temasMaisFrequentesBaseInferior = 7 - 2;

$temasMaisFrequentes = array(
    array('DA SOCIEDADE', 25),
    array('DA RECUPERAÇÃO JUDICIAL, EXTRAJUDICIAL E DA FALÊNCIA DO EMPRESÁRIO E DA SOCIEDADE EMPRESÁRIA', 18),
    array('TÍTULOS DE CRÉDITOS', 18),
    array('DIREITO DE EMPRESA', 11),
    array('DOS CONTRATOS EMPRESARIAIS', 7),
);

$temas = array(
    array('1.	DO DIREITO DE EMPRESA'),
    array('2.	DA SOCIEDADE'),
    array('3.	DA LIQUIDAÇÃO DA SOCIEDADE		'),
    array('4.	DO ESTABELECIMENTO	'),
    array('5.	TÍTULOS DE CRÉDITOS'),
    array('6.	DOS INSTITUTOS COMPLEMENTARES'),
    array('7.	DAS SOCIEDADES POR AÇÕES		'),
    array('8.	DOS VALORES IMOBILIÁRIOS'),
    array('9.	DA RECUPERAÇÃO JUDICIAL, EXTRAJUDICIAL E DA FALÊNCIA DO EMPRESÁRIO E DA SOCIEDADE EMPRESÁRIA'),
    array('10.	DOS CONTRATOS EMPRESARIAIS'),
    array('11.	DO SISTEMA FINANCEIRO NACIONAL'),
    array('12.	POLÍTICA E AS INSTITUIÇÕES MONETÁRIAS, BANCÁRIAS E CREDITÍCIAS – LEI nº 4595/64'),
    array('13.	DA PROPRIEDADE INTELECTUAL E DA PROTEÇÃO DA PROPRIEDADE INTELECTUAL DE PROGRAMA DE COMPUTADOR – LEI Nº 9.609/1998. 14'),
    array('14.	DEFESA DA CONCORRÊNCIA'),
    array('15.	AÇÕES DE RITO ORDINÁRIO, SUMÁRIO E ESPECIAL'),
    array('16.	ARBITRAGEM LEI N. 9.307/1996'),
    array('17.	DA PROPRIEDADE INDUSTRIAL'),
);


$temasJaExigidos = array(
    array('DIREITO DE EMPRESA', 'II, VIII, XI, XV, XIX, XVII, XIII , V, XX, XX (Salvador)'),
    array('DA SOCIEDADE', 'II, III, IV, V, VI, VII, VIII, IX, X, XI, XII, XIV, XV, XVI, XVII, XVIII, XIX, XX, XX (Salvador), XXI'),
    array('DO ESTABELECIMENTO', 'X, XVII, XII'),
    array('TÍTULOS DE CRÉDITOS', 'III, IV, VI, VII, VIII, IX, X, XI, XII, XIII, XV, XVI, XVII, XVIII, XIX, XIV, XX, XX (Salvador), XXI'),
    array('DOS INSTITUTOS COMPLEMENTARES', 'II, XVI'),
    array('DAS SOCIEDADES POR AÇÕES', 'III, VII, VI, XXI'),
    array('DOS VALORES IMOBILIÁRIOS', 'V, XIV'),
    array('DA RECUPERAÇÃO JUDICIAL, EXTRAJUDICIAL E DA FALÊNCIA DO EMPRESÁRIO E DA SOCIEDADE EMPRESÁRIA', 'III, XIII, II, IV, V, VI, VII, VIII, IX, X, XI, XII, XIV, XV, XVII, XVIII, XIX, XX, XX(Salvador), XXI'),
    array('DOS CONTRATOS EMPRESARIAIS', 'IV, IX, X, XIV, XVI, XVIII'),
    array('DA PROPRIEDADE INTELECTUAL E DA PROTEÇÃO DA PROPRIEDADE INTELECTUAL DE PROGRAMA DE COMPUTADOR – LEI Nº 9.609/1998.', 'XVI, VI'),
    array('ARBITRAGEM – LEI Nº 9.307/1996', 'XIX'),
    array('DA PROPRIEDADE INDUSTRIAL', 'VII, XVI, XII, XIII'),
);

$temasNuncaExigidos = array(
    array('DA LIQUIDAÇÃO DA SOCIEDADE'),
    array('DO SISTEMA FINANCEIRO NACIONAL'),
    array('POLÍTICA E AS INSTITUIÇÕES MONETÁRIAS, BANCÁRIAS E CREDITÍCIAS – LEI Nº 4.595/64'),
    array('DEFESA DE CONCORRÊNCIA'),
    array('AÇÕES DE RITO ORDINÁRIO, SUMÁRIO E ESPECIAL'),
);

$temasIncidencias = array(
    array('1', 'DA SOCIEDADE', 27, 'top-part'),
    array('2', 'DA RECUPERAÇÃO JUDICIAL, EXTRAJUDICIAL E DA FALÊNCIA DO EMPRESÁRIO E DA SOCIEDADE EMPRESÁRIA', 19, 'top-part'),
    array('3', 'TÍTULOS DE CRÉDITOS', 19, 'top-part'),
    array('4', 'DIREITO DE EMPRESA', 11, 'top-part'),
    array('5', 'DOS CONTRATOS EMPRESARIAIS', 7, 'top-part'),
    array('6', 'DA PROPRIEDADE INDUSTRIAL', 4, 'top-part'),
    array('8', 'DAS SOCIEDADES POR AÇÕES', 3, 'top-part'),
    array('7', 'DO ESTABELECIMENTO', 4, 'top-part'),
    array('9', 'DOS INSTITUTOS COMPLEMENTARES', 2, 'top-part'),
    array('10', 'DA PROPRIEDADE INTELECTUAL E DA PROTEÇÃO DA PROPRIEDADE INTELECTUAL DE PROGRAMA DE COMPUTADOR – LEI Nº 9.609/1998.', 2, 'top-part'),
    array('11', 'DOS VALORES IMOBILIÁRIOS', 2, 'low-part'),
    array('12', 'ARBITRAGEM', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, Direito Empresarial compõe o quarto grupo de disciplinas mais importantes da prova, pois foi contemplado com 05 questões no último exame, o que corresponde a 12,5% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Empresarial foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “DA SOCIEDADE” e “RECUOERAÇÃO JUDICIAL” correspondem a 45,54% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
