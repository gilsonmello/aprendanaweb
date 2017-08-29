
<?php
$titulodisciplina = "Direito do Trabalho";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 131;

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

$temasMaisFrequentesBaseSuperior = 21 + 1;
$temasMaisFrequentesBaseInferior = 12 - 2;

$temasMaisFrequentes = array(
    array('REMUNERAÇÃO', 24),
    array('CONTRATO INDIVIDUAL DE TRABALHO', 21),
    array('JORNADA DE TRABALHO', 20),
    array('AVISO PRÉVIO E EXTINÇÃO DO CONTRATO', 18),
    array('ESTABILIDADE E GARANTIA PROVISÓRIA', 13),
);

$temas = array(
    array('1.	FONTES DO DIREITO DO TRABALHO'),
    array('2.	PRINCÍPIOS DO DIREITO DO TRABALHO'),
    array('3.	DIREITOS CONSTITUCIONAIS DOS TRABALHADORES'),
    array('4.	RENÚNCIA E TRANSAÇÃO NO DIREITO DO TRABALHO'),
    array('5.	COMISSÃO DE CONCILIAÇÃO PRÉVIA'),
    array('6.	TERCEIRIZAÇÃO'),
    array('7.	SUJEITOS DA RELAÇÃO DE TRABALHO'),
    array('8.	CONTRATO INDIVIDUAL DE TRABALHO'),
    array('9.	JORNADA DE TRABALHO'),
    array('10.	REMUNERAÇÃO'),
    array('11.	AVISO PRÉVIO E EXTINÇÃO DO CONTRATO DE TRABALHO'),
    array('12.	ESTABILIDADE E GARANTIA PROVISÓRIA'),
    array('13.	PRESCRIÇÃO'),
    array('14.	DIREITO COLETIVO DO TRABALHO'),
);


$temasJaExigidos = array(
    array('PRINCÍPIOS DO DIREITO DO TRABALHO', 'IV, XX (Salvador)'),
    array('DIREITOS CONSTITUCIONAIS DOS TRABALHADORES', 'X, XXI'),
    array('RENÚNCIA E TRANSAÇÃO NO DIREITO DO TRABALHO', 'III'),
    array('TERCEIRIZAÇÃO', 'III, IV, XIII, XV'),
    array('SUJEITOS DA RELAÇÃO DE TRABALHO', 'II, IV, V, VII, VIII, IX, X, XII, XIII, XI, XIX, XX (Salvador)'),
    array('CONTRATO INDIVIDUAL DE TRABALHO', 'II, III, IV, VIII,IX, X, XI, XII, XIII, XIV, XV, XIV, XVI, XVII, XVIII, XIX, XX, XXI'),
    array('JORNADA DE TRABALHO', 'II, III, IV, V, VI, VII, IX, X, XI, XII, XIV, XVI, XVII, XIX, XX, XX (Salvador),XXI'),
    array('REMUNERAÇÃO', 'II, III, V, VI, VII, XI, XII, XIII, XV, XVI, XVII, XVIII, XX, XX (Salvador),XXI'),
    array('AVISO-PRÉVIO E EXTINÇÃO DO CONTRATO DE TRABALHO', 'II, III, IV, V, VI, VII, VIII, IX, X, XII, XIV, XV, XVI, XVII, XX, XXI'),
    array('ESTABILIDADE E GARANTIA DE EMPREGO', 'III, IV, VIII, X, XI, XII, XIII, XIV, XV, XIX, XX'),
    array('PRESCRIÇÃO', 'XX'),
    array('DIREITO COLETIVO DO TRABALHO', 'II, IX, XIII, XVIII, XXI'),
);

$temasNuncaExigidos = array(
    array('FONTES DO DIREITO DO TRABALHO'),
);

$temasIncidencias = array(
    array('1', 'CONTRATO INDIVIDUAL DE TRABALHO', 25, 'top-part'),
    array('2', 'JORNADA DE TRABALHO', 23, 'top-part'),
    array('3', 'AVISO PRÉVIO E EXTINÇÃO DO CONTRATO', 23, 'top-part'),
    array('4', 'REMUNERAÇÃO', 22, 'top-part'),
    array('5', 'SUJEITOS DA RELAÇÃO DE TRABALHO', 13, 'top-part'),
    array('6', 'ESTABILIDADE E GARANTIA PROVISÓRIA', 9, 'top-part'),
    array('7', 'DIREITO COLETIVO DO TRABALHO', 5, 'top-part'),
    array('8', 'TERCEIRIZAÇÃO', 4, 'top-part'),
    array('9', 'PRINCÍPIOS DO DIREITO DO TRABLHO', 2, 'low-part'),
    array('10', 'DIREITOS CONSTITUCIONAIS DOS TRABALHADORES', 2, 'top-part'),
    array('11', 'COMISSÃO DE CONCILIAÇÃO PRÉVIA', 1, 'top-part'),
    array('12', 'RENÚNCIA E TRANSAÇÃO NO DIREITO DO TRABALHO', 1, 'low-part'),
    array('13', 'NORMAS DE PROTEÇÃO AO TRABALHO', 1, 'top-part'),
    array('14', 'PRESCRIÇÃO', 1, 'top-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina de Direito do Trabalho compõe o terceiro grupo de disciplinas de maior relevância para a prova, pois foi contemplada com 06 questões no último exame, o que</p> corresponde à 15% da pontuação necessária para a aprovação do examinando na 1ª Fase.
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito do Trabalho foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Remuneração”, “Contrato individual de trabalho” e “Jornada de trabalho” correspondem a mais de 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
