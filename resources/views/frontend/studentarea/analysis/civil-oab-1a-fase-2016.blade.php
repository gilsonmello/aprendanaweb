
<?php
$titulodisciplina = "Direito Civil";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 155;

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

$temasMaisFrequentesBaseSuperior = 24 + 1;
$temasMaisFrequentesBaseInferior = 9 - 2;

$temasMaisFrequentes = array(
    array('TEORIA GERAL DAS OBRIGAÇÕES', 24),
    array('DIREITOS REAIS', 22),
    array('CONTRATOS EM ESPÉCIE', 20),
    array('PESSOA NATURAL E DIREITOS DA PERSONALIDADE', 13),
    array('FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS', 9),
);

$temas = array(
    array('1.       DIREITO CIVIL E CONSTITUIÇÃO'),
    array('2.       PESSOA NATURAL E DIREITOS DA PERSONALIDADE'),
    array('3.       PESSOA JURÍDICA'),
    array('4.       BENS'),
    array('5.       FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS'),
    array('6.       PRESCRIÇÃO E DECADÊNCIA'),
    array('7.       TEORIA GERAL DAS OBRIGAÇÕES'),
    array('8.       ATOS UNILATERAIS'),
    array('9.       TEORIA DO CONTRATO'),
    array('10.   CONTRATOS EM ESPÉCIE'),
    array('11.   TEORIA GERAL DA RESPONSABILIDADE CIVIL'),
    array('13.   POSSE'),
    array('14.   DIREITOS REAIS'),
    array('15.   CASAMENTO, UNIÃO ESTÁVEL E MONOPARENTALIDADE'),
    array('16.   DISSOLUÇÃO DO CASAMENTO E DA UNIÃO ESTÁVEL'),
    array('17.   PARENTESCO'),
    array('18.   PODER FAMILIAR'),
    array('19.   REGIME DE BENS E OUTROS DIREITOS PATRIMONIAIS NAS RELAÇÕES FAMILIARES'),
    array('20.   ALIMENTOS'),
    array('21.   SUCESSÃO LEGÍTIMA'),
    array('22.   SUCESSÃO TESTAMENTÁRIA E DISPOSIÇÕES DE ÚLTIMA VONTADE'),
    array('23. DA TUTELA, DA CURATELA E DA TOMADA DE DECISÃO APOIADA'),
    array('24. DA SUCESSÃO EM GERAL'),);


$temasJaExigidos = array(
    array('TEORIA GERAL DAS OBRIGAÇÕES', 'XX, XIII, XVIII, XIX, XIV, II, V, III, VIII, IX, XII, XVI, XVII, IV, XI, XXI'),
    array('DIREITOS REAIS', 'XII, II, III, IV, V, VI, VIII, IX, XIII, XIV, XVII, XIX, XX'),
    array('CONTRATOS EM ESPÉCIE', 'XIX, XVIII, IV, XI, XX, VI, III, V, VII, IX, X, XIII, XVII, XVI, XXI'),
    array('SUCESSÃO LEGÍTIMA', 'XX, XIV, III, VI, VIII, IX, XVII, XVI, V, II'),
    array('PESSOA NATURAL E DIREITOS DA PERSONALIDADE', 'XX, XII, VII, IV, VI, X,XII, XIV, XVI'),
    array('FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS', 'XX, XIII, VII, IV, VI, VIII, X, XIV, XXI'),
    array('TEORIA GERAL DA RESPONSABILIDADE CIVIL', 'V, VI, VII, IX, XII, XVI, XIII, XX, XXI'),
    array('REGIME DE BENS E OUTROS DIREITOS PATRIMONIAIS NAS RELAÇÕES FAMILIARES', 'X, III, II, XVIII, XV, XX'),
    array('ALIMENTOS', 'XX, III, IX, XI, XVII'),
    array('TEORIA DO CONTRATO', 'III, XI, VIII, IX, XII, XV'),
    array('SUCESSÃO TESTAMENTÁRIA E DISPOSIÇÕES DE ÚLTIMA VONTADE', 'II, XX, XV, X, XIX'),
    array('PRESCRIÇÃO E DECADÊNCIA', 'XVII, II, V'),
    array('CASAMENTO, UNIÃO ESTÁVEL E MONOPARENTALIDADE', 'III, V, VI'),
    array('POSSE', 'VII, XV, XVI'),
    array('DA SUCESSÃO EM GERAL', 'VII, XX, XIV'),
    array('PARENTESCO', 'VII, XIX'),
    array('DA TUTELA, DA CURATELA E DA TOMADA DE DECISÃO APOIADA', 'VIII, XIV'),
    array('INVENTÁRIO E PARTILHA', 'V'),
    array('LINDB (LEI DE INTRODUÇÃO ÀS NORMAS DO DIREITO BRASILEIRO)', 'IV'),
    array('BENS', 'X'),
    array('DISSOLUÇÃO DO CASAMENTO E DA UNIÃO ESTÁVEL', 'XXI'),
    array('PODER FAMILIAR', 'XXI'),
);

$temasNuncaExigidos = array(
    array('PESSOA JURÍDICA'),
    array('DIREITO CIVIL E CONSTIUIÇÃO'),
);

$temasIncidencias = array(
    array('1', 'TEORIA GERAL DAS OBRIGAÇÕES', 23, 'top-part'),
    array('2', 'DIREITOS REAIS', 21, 'top-part'),
    array('3', 'CONTRATOS EM ESPÉCIE', 17, 'top-part'),
    array('4', 'PESSOA NATURAL E DIREITOS DA PERSONALIDADE ', 11, 'top-part'),
    array('5', 'SUCESSÃO LEGÍTIMA ', 11, 'top-part'),
    array('6', 'FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS', 11, 'top-part'),
    array('7', 'TEORIA GERAL DA RESPONSABILIDADE CIVIL', 10, 'top-part'),
    array('8', 'TEORIA DO CONTRATO', 7, 'top-part'),
    array('9', 'REGIME DE BENS E OUTROS DIREITOS PATRIMONIAIS NAS RELAÇÕES FAMILIARES', 7, 'low-part'),
    array('10', 'ALIMENTOS', 7, 'top-part'),
    array('11', 'SUCESSÃO TESTAMENTÁRIA E DISPOSIÇÕES DE ÚLTIMA VONTADE', 6, 'top-part'),
    array('12', 'PRESCRIÇÃO E DECADÊNCIA', 3, 'top-part'),
    array('13', 'POSSE', 3, 'low-part'),
    array('14', 'CASAMENTO, UNIÃO ESTÁVEL E MONOPARENTALIDADE', 3, 'low-part'),
    array('15', 'DA SUCESSÃO EM GERAL', 3, 'low-part'),
    array('16', 'PARENTESCO', 2, 'low-part'),
    array('17', 'DA TUTELA, DA CURATELA E DA TOMADA DE DECISÃO APOIADA', 2, 'low-part'),
    array('18', 'DOS BENS', 1, 'low-part'),
    array('19', 'INVENTÁRIO E PARTILHA', 1, 'low-part'),
    array('20', 'LINDB', 1, 'low-part'),
    array('21', 'DISSOLUÇÃO DO CASAMENTO E DA UNIÃO ESTÁVEL', 1, 'low-part'),
    array('22', 'PODER FAMILIAR', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina Direito Civil compõe o segundo grupo de disciplinas mais importantes da prova, pois foi contemplada com 07 questões no último exame, o que corresponde à 17,5% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na 1ª Fase, visando oferecer dados concretos ao examinando, para que este possa elaborar o seu plano de estudos de forma segura e precisa.</p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, relativo à 2ª Fase do Exame, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar os temas passíveis de cobrança na 1ª Fase.</p>
                    <p>Para Direito Civil foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Teoria geral das obrigações”, “Direito das coisas” e “Contratos em espécie” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
