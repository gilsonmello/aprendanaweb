
<?php
$titulodisciplina = "Filosofia do Direito";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 13;

$questoes = 22;

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

$temasMaisFrequentesBaseSuperior = 11 + 1;
$temasMaisFrequentesBaseInferior = 0;

$temasMaisFrequentes = array(
    array('FILOSOFIA CONTEMPORÂNEA', 11),
    array('FILOSOFIA MODERNA', 6),
    array('HERMENÊUTICA E LÓGICA JURÍDICA', 4),
    array('FILOSOFIA DA ANTIGUIDADE', 2),
    array('FILOSOFIA NA IDADE MÉDIA', 1),
);

$temas = array(
    array('1.	HERMENÊUTICA E LÓGICA JURÍDICA'),
    array('2.	FILOSOFIA DA ANTIGUIDADE'),
    array('3.	FILOSOFIA MODERNA'),
    array('4.	FILOSOFIA CONTEMPORÂNEA'),
);


$temasJaExigidos = array(
    array('HERMENÊUTICA E LÓGICA JURÍDICA', 'X, XIII, XV, XX'),
    array('FILOSOFIA DA ANTIGUIDADE', 'XI'),
    array('FILOSOFIA MODERNA', 'X, XI, XII, XIV, XV, XIX, XX, XXI'),
    array('FILOSOFIA CONTEMPORÂNEA', 'XII, XIII, XIV, XVI, XVII, XVIII, XIX, XX (Salvador)'),
    array('FILOSOFIA NA IDADE MÉDIA', 'XX (Salvador)'),
);

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
    array('1', 'FILOSOFIA CONTEMPORÂNEA', 11, 'top-part'),
    array('2', 'FILOSOFIA MODERNA', 8, 'top-part'),
    array('3', 'HERMENÊUTICA E LÓGICA JURÍDICA', 4, 'low-part'),
    array('4', 'FILOSOFIA DA ANTIGUIDADE', 2, 'low-part'),
    array('5', 'FILOSOFIA NA IDADE MÉDIA', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, Filosofia do Direito compõe o grupo de disciplinas que foram contempladas com 02 questões no último Exame, o que corresponde a 5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Filosofia do Direito foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Filosofia do Direito passou a ser abordada na prova da OAB a partir do X Exame Unificado, daí o número reduzido de questões até o momento.</p>
                    <p>O gráfico aponta quais os temas devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que Filosofia Contemporânea conta com 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo do referido tema.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
