
<?php
$titulodisciplina = "Direito Administrativo";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 139;

$questoesNaDisciplina = 113;

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
$temasMaisFrequentesBaseInferior = 9 - 2;

$temasMaisFrequentes = array(
    array('ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR', 18),
    array('AGENTES PÚBLICOS', 17),
    array('CONTRATOS ADMINISTRATIVOS', 13),
    array('INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA', 12),
    array('CONTROLE DA ADMINISTRAÇÃO', 9),
);

$temas = array(
    array('1. PRINCÍPIOS, FONTES E INTERPRETAÇÃO'),
    array('2. ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR'),
    array('3. PODERES DA ADMINISTRAÇÃO'),
    array('4. ATOS ADMINISTRATIVOS'),
    array('5. CONTRATOS ADMINISTRATIVOS'),
    array('6. LICITAÇÕES'),
    array('7. SERVIÇOS PÚBLICOS'),
    array('8. AGENTES PÚBLICOS'),
    array('10. INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA'),
    array('12. CONTROLE DA ADMINISTRAÇÃO'),
    array('13. IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92'),
    array('14. RESPONSABILIDADE CIVIL DO ESTADO'),
    array('15. PROCESSO ADMINISTRATIVO'),
    array('16. BENS PÚBLICOS'),
);


$temasJaExigidos = array(
    array('PRINCÍPIOS, FONTES E INTERPRETAÇÃO', 'XVII'),
    array('ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR', 'II, III, IV, V, VI, VII, VIII, IX, XI, XII, XIII, XIV, XV, XVII, XVIII, XX (Salvador), XXI'),
    array('PODERES DA ADMINISTRAÇÃO', 'II, X, XI, XIII, XIV, XIX, '),
    array('ATOS ADMINISTRATIVOS', 'IV, V, VII, XII, XIX'),
    array('CONTRATOS ADMINISTRATIVOS', 'II, III, IX, XI, XIX'),
    array('LICITAÇÕES', 'III, X, XI, XII, XIII, XV, XVIII, XVI, XVIII'),
    array('SERVIÇOS PÚBLICOS', 'II, IV, VIII, IX, XIII, XIV, XVI, XVIII, XVI, XIX, XX, XXI'),
    array('AGENTES PÚBLICOS', 'II, III, V, VI, IX, X, XI, XII, XIV, XV, XVII, XVIII, XIX, XX (SALVADOR), XX, XXI'),
    array('INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA', 'II, III, VII, VIII, IX, X, XI, XII, XIII, XVII, XX'),
    array('CONTROLE DA ADMINISTRAÇÃO', 'III, VI, VIII, IX, X, XV, XVI, XIX'),
    array('IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92', 'V, XVI, XXVIII, XIII, XIV, XX, XX (SALVADOR)'),
    array('RESPONSABILIDADE CIVIL DO ESTADO', 'III, IV, V, VI, VIII, XIX, XX (SALVADOR), XXI'),
    array('PROCESSO ADMINISTRATIVO', 'II, III, XII, XVI, XVII, XX'),
    array('BENS PÚBLICOS', 'V, VI, VII, XVI, XVII'),
);

$temasNuncaExigidos = array(
);

$temasIncidencias = array(
    array('1', 'ORGANIZAÇÃO ADMINISTRATIVA E TERCEIRO SETOR', 24, 'top-part'),
    array('2', 'AGENTES PÚBLICOS', 21, 'top-part'),
    array('3', 'SERVIÇOS PÚBLICOS', 14, 'top-part'),
    array('4', 'INTERVENÇÃO ESTATAL NA PROPRIEDADE PRIVADA', 12, 'top-part'),
    array('5', 'LICITAÇÕES', 10, 'top-part'),
    array('6', 'CONTROLE DA ADMINISTRAÇÃO', 9, 'top-part'),
    array('7', 'IMPROBIDADE ADMINISTRATIVA: LEI 8.429/92', 8, 'top-part'),
    array('8', 'PODERES DA ADMINISTRAÇÃO', 8, 'top-part'),
    array('9', 'RESPONSABILIDADE CIVIL DO ESTADO', 8, 'low-part'),
    array('10', 'PROCESSO ADMINISTRATIVO', 7, 'low-part'),
    array('11', 'CONTRATOS ADMINISTRATIVOS', 7, 'top-part'),
    array('12', 'BENS PÚBLICOS', 5, 'low-part'),
    array('13', 'ATOS ADMINISTRATIVOS', 5, 'top-part'),
    array('14', 'PRINCÍPIOS, FONTES E INTERPRETAÇÃO', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, Direito Administrativo compõe o terceiro grupo de disciplinas mais importantes da prova, pois foi contemplado com 06 questões no último exame, o que corresponde à 15% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será apresentada uma análise 360º da referida disciplina na primeira fase, visando oferecer dados concretos ao candidato, para que o mesmo possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar uma lista com temas passíveis de cobrança na 1ª fase.</p>
                    <p>Para Direito Administrativo foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Organização Administrativa e Terceiro Setor”, “Agentes Públicos” “Contratos Administrativos” e “Intervenção do Estado na Propriedade Privada” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
