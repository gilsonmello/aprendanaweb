
<?php
$titulodisciplina = "Direito Processual do Trabalho";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 101;

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

$temasMaisFrequentesBaseSuperior = 18 + 1;
$temasMaisFrequentesBaseInferior = 10 - 2;

$temasMaisFrequentes = array(
    array('TEORIA GERAL DOS RECURSOS E RECURSOS EM ESPÉCIE', 18),
    array('PROVAS', 14),
    array('AUDIÊNCIA', 12),
    array('ATOS, DESPESAS, PRAZOS E NULIDADES PROCESSUAIS', 11),
    array('EXECUÇÃO TRABALHISTA', 10),
);



$temas = array(
    array('1.	FONTES E PRÍNCIPIOS DO PROCESSO DO TRABALHO'),
    array('2.	ORGANIZAÇÃO DA JUSTIÇA DO TRABALHO'),
    array('3.	MINISTÉRIO PÚBLICO DO TRABALHO'),
    array('4.	COMPETÊNCIA DA JUSTIÇA DO TRABALHO'),
    array('5.	COMISSÃO DE CONCILIAÇÃO PRÉVIA'),
    array('6.	ATOS, DESPESAS, PRAZOS E NULIDADES PROCESSUAIS'),
    array('7.	PARTES E PROCURADORES NO PROCESSO DO TRABALHO'),
    array('8.	PROVAS'),
    array('9.	AUDIÊNCIA'),
    array('10.	SENTENÇA E COISA JULGADA'),
    array('11.	PROCEDIMENTO SUMARÍSSIMO'),
    array('12.	PROCEDIMENTOS'),
    array('13.	TEORIA GERAL DOS RECURSOS E RECURSOS EM ESPÉCIE'),
    array('14.	EXECUÇÃO TRABALHISTA'),
    array('15.	PROCEDIMENTOS ESPECIAIS'),
    array('16.	PRESCRIÇÃO'),
);


$temasJaExigidos = array(
    array('FONTES E PRINCÍPIOS DO PROCESSO DO TRABALHO', 'III'),
    array('COMPETÊNCIA DA JUSTIÇA DO TRABALHO', 'V, VIII, IX, XIII, XVII, XVIII, XIX'),
    array('ATOS, DESPESAS, PRAZOS E NULIDADES PROCESSUAIS', 'II, V, VI, VIII, XIII, XV, XVI, XVIII, XX'),
    array('PARTES E PROCURADORES NO PROCESSO DO TRABALHO', 'VI, IX, XV, XVII'),
    array('PROVAS', 'III, V, VI, VII, XI, XII, XV, XIV, XVII, XIX, XX (Salvador), XXI'),
    array('AUDIÊNCIA', 'IV, VI, VIII, IX, X, XI, XIII, XIV, XV, XVIII, XIX, XX (salvador)'),
    array('SENTENÇA E COISA JULGADA', 'VI, IX, XII, XIV, XIX, XX (salvador)'),
    array('PROCEDIMENTO SUMARÍSSIMO', 'II, VII, VIII, X, XII, XVIII, XX'),
    array('TEORIA GERAL DOS RECURSOS E RECURSOS EM ESPÉCIE', 'II, IV, V, VII, X, XII, XIV, XV, XVI, XVII, XIX'),
    array('EXECUÇÃO TRABALHISTA', 'II, IV, VII, VIII, IX, X, X, XXI'),
    array('PROCEDIMENTOS', 'XIII, XVI, XXI'),
    array('PROCEDIMENTOS ESPECIAIS', 'II, III, IV, XI, XIII, XIV, XVI, XVIII, XX'),
    array('PRESCRIÇÃO', 'XX (Salvador)'),
    array('MINISTÉRIO PÚBLICO DO TRABALHO', 'III'),
);

$temasNuncaExigidos = array(
    array('ORGANIZAÇÃO DA JUSTIÇA DO TRABALHO'),
    array('PROCEDIMENTO SUMÁRIO'),
);

$temasIncidencias = array(
    array('1', 'ATOS, DESPESAS, PRAZOS E NULIDADES PROCESSUAIS', 18, 'top-part'),
    array('2', 'TEORIA GERAL DOS RECURSOS E RECURSOS EM ESPÉCIE', 15, 'top-part'),
    array('3', 'PROVAS', 13, 'top-part'),
    array('4', 'AUDIÊNCIA', 12, 'top-part'),
    array('5', 'PROCEDIMENTO ESPECIAL', 11, 'top-part'),
    array('6', 'EXECUÇÃO TRABALHISTA', 10, 'top-part'),
    array('7', 'PROCEDIMENTO SUMARÍSSIMO', 7, 'top-part'),
    array('8', 'SENTENÇA E COISA JULGADA', 6, 'top-part'),
    array('9', 'COMPETÊNCIA DA JUSTIÇA DO TRABALHO', 6, 'top-part'),
    array('10', 'PARTES E PROCURADORES NO PROCESSO DO TRABALHO', 4, 'top-part'),
    array('11', 'MINISTÉRIO PÚBLICO DO TRABALHO', 1, 'top-part'),
    array('12', 'FONTES E PRINCÍPIOS DO PROCESSO DO TRABALHO', 1, 'low-part'),
    array('13', 'PRESCRICÃO', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina Direito Processual do Trabalho compõe o quarto grupo de disciplinas mais relevantespara a prova, pois foi contemplado com 05 questões no último exame, o q</p>ue corresponde a 12,5% da pontuação necessária para a aprovação do examinando na 1ª Fase.
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa.</p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Processual do Trabalho foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Teoria geral dos recursos em espécie”, “Provas”, “Audiência” e “Execução trabalhista” correspondem a pouco mais de 50% do total de incidência da prova nesta disciplina, o que demonstra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
