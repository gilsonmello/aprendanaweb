
<?php
$titulodisciplina = "Direito do Consumidor";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 54;

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

$temasMaisFrequentesBaseSuperior = 13 + 1;
$temasMaisFrequentesBaseInferior = 3 - 2;

$temasMaisFrequentes = array(
    array('RESPONSABILIDADE CIVIL NAS RELAÇÕES DE CONSUMO', 13),
    array('PROTEÇÃO CONTRATUAL', 9),
    array('PRÁTICAS COMERCIAIS', 5),
    array('CLÁUSULAS ABUSIVAS', 5),
    array('PRINCÍPIOS DO CÓDIDO DE DEFESA DO CONSUMIDOR', 3),
);

$temas = array(
    array('1.	REGULAMENTAÇÃO DAS RELAÇÕES DE CONSUMO'),
    array('2.	PRINCÍPIOS DO CÓDIGO DE DEFESA DO CONSUMIDOR'),
    array('3.	RELAÇÃO JURÍDICA DE CONSUMO'),
    array('4.	RESPONSABILIDADE CIVIL NAS RELAÇÕES DE CONSUMO'),
    array('5.	EXCLUDENTES DE RESPONSABILIDADE'),
    array('6.	DANOS MORAIS NAS RELAÇÕES DE CONSUMO'),
    array('7.	PRESCRIÇÃO E DECADÊNCIA NO CÓDIGO DE DEFESA DO CONSUMIDOR'),
    array('8.	DESCONSIDERAÇÃO DA PERSONALIDADE JURÍDICA'),
    array('9.	PRÁTICAS COMERCIAIS ABUSIVAS'),
    array('10.	A PUBLICIDADE NAS RELAÇÕES DE CONSUMO'),
    array('11.	BANCO DE DADOS E CADASTROS DE CONSUMIDORES'),
    array('12.	PROTEÇÃO CONTRATUAL'),
    array('13.	DA DEFESA DO CONSUMIDOR EM JUÍZO'),
);


$temasJaExigidos = array(
    array('REGULAMENTAÇÃO DAS RELAÇÕES DE CONSUMO', 'XII, XX'),
    array('PRINCÍPIOS DO CÓDIGO DE DEFESA DO CONSUMIDOR', 'III, IV, XII'),
    array('RESPONSABILIDADE CIVIL NAS RELAÇÕES DE CONSUMO', 'III, VIII, X, XI, XVI, XIX, V, XVIII, XIII, XIV, XV'),
    array('PRESCRIÇÃO E DECADÊNCIA NO CÓDIGO DE DEFESA DO CONSUMIDOR', 'III, VI'),
    array('RELAÇÃO JURÍDICA DE CONSUMO', 'XVIII, XX (Salvador)'),
    array('PRÁTICAS COMERCIAIS ABUSIVAS', 'VI, XIII, XXI'),
    array('A PUBLICIDADE NAS RELAÇÕES DE CONSUMO', 'II, IX, XX (SALVADOR), XXI'),
    array('PROTEÇÃO CONTRATUAL E CLÁUSULAS ABUSIVAS', 'V, VII, VIII, XIX, XX (SALVADOR)'),
    array('DA DEFESA DO CONSUMIDOR EM JUÍZO', 'II, X, XX'),
    array('BANCO DE DADOS E CADASTROS DE CONSUMIDORES', 'XV, XX'),
    array('DIREITOS BÁSICOS DO CONSUMIDOR', 'XIV, IV'),
);

$temasNuncaExigidos = array(
    array('EXCLUDENTES DE RESPONSABILIDADE'),
    array('DESCONSIDERAÇÃO DA PERSONALIDADE JURÍDICA'),
);

$temasIncidencias = array(
    array('1', 'RESPONSABILIDADE CIVIL NAS RELAÇÕES DE CONSUMO', 13, 'top-part'),
    array('2', 'PROTEÇÃO CONTRATUAL E CLÁUSULAS ABUSIVAS', 6, 'top-part'),
    array('3', 'A PUBLICIDADE NAS RELAÇÕES DE CONSUMO', 3, 'top-part'),
    array('4', 'PRINCÍPIOS DO CÓDIDO DE DEFESA DO CONSUMIDOR', 3, 'top-part'),
    array('5', 'DA DEFESA DO CONSUMIDOR EM JUÍZO', 3, 'top-part'),
    array('6', 'PRÁTICAS COMERCIAIS ABUSIVAS', 5, 'top-part'),
    array('7', 'REGULAMENTAÇÃO DAS RELAÇÕES DE CONSUMO', 3, 'top-part'),
    array('8', 'DIREITOS BÁSICOS DO CONSUMIDOR', 1, 'low-part'),
    array('9', 'PRESCRIÇÃO E DECADÊNCIA NO CÓDIDO DE DEFESA DO CONSUMIDOR', 2, 'top-part'),
    array('10', 'BANCO DE DADOS E CADASTROS DE CONSUMIDORES', 2, 'low-part'),
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
                    <p>De acordo com a tabela exposta, Direito do Consumidor compõe o grupo de disciplinas que foram contempladas com 02 questões no último Exame, o que corresponde a 5% da pontuação necessária para a aprovação do examinando na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito do Consumidor foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo examinando para que este possa avançar para a 2ª Fase. É importante observar que os temas “Responsabilidade Civil nas relações de consumo” e “Proteção contratual” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demonstra uma especial necessidade de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do examinando a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente exigidos nas provas, conduzindo-o à aprovação no Exame de Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
