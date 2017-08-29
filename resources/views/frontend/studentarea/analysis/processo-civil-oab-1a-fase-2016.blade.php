
<?php
$titulodisciplina = "Direito Processual Civil";

$titulo = " | Exame OAB 1º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 137;

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

$temasMaisFrequentesBaseSuperior = 17 + 1;
$temasMaisFrequentesBaseInferior = 10 - 2;

$temasMaisFrequentes = array(
    array('PROCEDIMENTOS ESPECIAIS', 17),
    array('TEORIA GERAL DA EXECUÇÃO', 13),
    array('TEORIA GERAL DO RECURSO. REMESSA NECESSÁRIA E RECURSOS EM ESPÉCIE. RECURSOS PARA O SUPREMO TRIBUNAL FEDERAL E PARA O SUPERIOR TRIBUNAL DE JUSTIÇA', 11),
    array('SUJEITOS DO PROCESSO: JUIZ. PARTES E PROCURADORES', 11),
    array('SENTENÇA E COISA JULGADA', 10),
);

$temas = array(
    array('1.       JURISDIÇÃO'),
    array('2.       PRINCÍPIOS GERAIS DO DIREITO PROCESSUAL CIVIL'),
    array('3.       AÇÃO'),
    array('4.       LITISCONSÓRCIO'),
    array('5.       INTERVENÇÃO DE TERCEIROS'),
    array('6.       MINISTÉRIO PÚBLICO'),
    array('7.       COMPETÊNCIA'),
    array('8.      SUJEITOS DO PROCESSO: JUIZ. PARTES E PROCURADORES'),
    array('9.       ATOS PROCESSUAIS: TEORIA GERAL E ESPÉCIES. NULIDADES'),
    array('10.   FORMAÇÃO, SUSPENSÃO E EXTINÇÃO DO PROCESSO'),
    array('11.   PROCESSO DE CONHECIMENTO. PETIÇÃO INICIAL. VALOR DA CAUSA'),
    array('12.   RESPOSTA DO RÉU'),
    array('13.   JULGAMENTO CONFORME O ESTADO DO PROCESSO'),
    array('14.   TUTELA DE URGÊNCIA'),
    array('15.   JUIZADOS ESPECIAIS CÍVEIS'),
    array('16.   TEORIA GERAL DAS PROVAS'),
    array('17.   SENTENÇA E COISA JULGADA'),
    array('18.   TEORIA GERAL DOS RECURSOS. REMESSA NECESSÁRIA E RECURSOS EM ESPÉCIE.RECURSOS PARA O SUPREMO TRIBUNAL FEDERAL E PARA O SUPERIOR TRIBUNAL DE JUSTIÇA'),
    array('19.  INCIDENTE E AÇÕES: AÇÃO RESCISÓRIA'),
    array('20.   TEORIA GERAL DA EXECUÇÃO'),
    array('21.   TEORIA GERAL DO PROCESSO CAUTELAR'),
    array('22.   PROCEDIMENTOS ESPECIAIS'),
    array('23.   AÇÃO DE ALIMENTOS'),
    array('24.   AUDIÊNCIA DE INSTRUÇÃO E JULGAMENTO (AIJ).'),
    array('25. DO PROCESSO ELETRÔNICO'),
    array('26. AÇÕES CONSTITUCIONAIS: AÇÃO CIVIL PÚBLICA'),
    array('27. LITIGÂNCIA DE MÁ FÉ'),
    array('28.AUDIENCIA DE CONCILIAÇÃO E MEDIAÇÃO'),
    array('29. GRATUIDADE DA JUSTIÇA'),
);


$temasJaExigidos = array(
    array('JURISDIÇÃO', 'XVIII'),
    array('PRINCÍPIOS GERAIS DO DIREITO PROCESSUAL CIVIL', 'III, IX'),
    array('SUJEITOS DO PROCESSO: JUIZ. PARTES E PROCURADORES', 'II, III, IV, VI, VII, X, XI, XIII, XX, XX (Salvador)'),
    array('LITISCONSÓRCIO', 'IV, V, XI, XIV'),
    array('INTERVENÇÃO DE TERCEIROS', 'VIII, IX, XX (Salvador)'),
    array('MINISTÉRIO PÚBLICO', 'XIV, XX (Salvador)'),
    array('COMPETÊNCIA', 'II, VII, VIII, XI'),
    array('ATOS PROCESSUAIS: TEORIA GERAL E ESPÉCIES. NULIDADES ', 'III, V, VI, X, XII, XX'),
    array('FORMAÇÃO, SUSPENSÃO E EXTINÇÃO DO PROCESSO', 'XIV, XV, XVII, XIX'),
    array('PROCESSO DE CONHECIMENTO. PETIÇÃO INICIAL. VALOR DA CAUSA', 'XIX, XX'),
    array('RESPOSTA DO RÉU', 'III, IV, VI, XII, XX, XX (Salvador), XXI'),
    array('JULGAMENTO CONFORME O ESTADO DO PROCESSO', 'XV'),
    array('TUTELA DE URGÊNCIA', 'XIX, XXI'),
    array('JUIZADOS ESPECIAIS CÍVEIS', 'II, III, IV, VIII, IX, X'),
    array('TEORIA GERAL DAS PROVAS', 'II, XIV, XVII'),
    array('SENTENÇA E COISA JULGADA', 'IV, V, VII, VIII, XV, XVII, XVIII'),
    array('TEORIA GERAL DOS RECURSOS. REMESSA NECESSÁRIA E RECURSOS EM ESPÉCIE. RECURSOS PARA O SUPREMO TRIBUNAL FEDERAL E PARA O SUPERIOR TRIBUNAL DE JUSTIÇA', 'III, IV, IX, XIII, XV, XVI, XVII, XIX, XX, XXI'),
    array('INCIDENTE E AÇÕES: AÇÃO RESCISÓRIA', 'VIII, IX, XVII, XVIII'),
    array('TEORIA GERAL DA EXECUÇÃO', 'II, IV, V, VII, IX, X, XI, XII, XV, XVI, XVII, XX (Salvador), XXI'),
    array('TEORIA GERAL DO PROCESSO CAUTELAR', 'II, III, V, VI, IX, XIII, XVII, XVIII, XIX'),
    array('PROCEDIMENTOS ESPECIAIS', 'II, III, IV, V, VI, IX, X, XII, XIII, XIV, XVI, XVIII, XIX, XXI'),
    array('AÇÃO DE ALIMENTOS', 'XVII'),
    array('AUDIÊNCIA DE INSTRUÇÃO E JULGAMENTO (AIJ).', 'XIII'),
    array('DO PROCESSO ELETRÔNICO', 'XVI'),
    array('AÇÕES CONSTITUCINAIS: AÇÃO CIVIL PÚBLICA', 'XII, XIV'),
    array('LITIGÂNCIA DE MÁ FÉ', 'XVI'),
    array('AUDIENCIA DE CONCILIAÇÃO E MEDIAÇÃO', 'XX'),
    array('GRATUIDADE DA JUSTIÇA', 'XX (Salvador)'),
);

$temasNuncaExigidos = array(
    array('AÇÃO'),
);

$temasIncidencias = array(
    array('1', 'PROCEDIMENTOS ESPECIAIS', 18, 'top-part'),
    array('2', 'TEORIA GERAL DA EXECUÇÃO', 14, 'top-part'),
    array('3', 'TEORIA GERAL DO RECURSO. REMESSA NECESSÁRIA E RECURSOS EM ESPÉCIE. RECURSOS PARA O SUPREMO TRIBUNAL FEDERAL E PARA O SUPERIOR TRIBUNAL DE JUSTIÇA', 12, 'top-part'),
    array('4', 'SUJEITOS DO PROCESSO: JUIZ. PARTES', 11, 'top-part'),
    array('5', 'SENTENÇA E COISA JULGADA', 10, 'top-part'),
    array('6', 'TEORIA GERAL DO PROCESSO CAUTELAR', 9, 'top-part'),
    array('7', 'ATOS PROCESSUAIS: TEORIAL GERAL E ESPÉCIES. ', 8, 'top-part'),
    array('9', 'RESPOSTA DO RÉU', 8, 'low-part'),
    array('8', 'JUIZADOS ESPECIAIS CÍVEIS', 6, 'top-part'),
    array('10', 'COMPETÊNCIA', 4, 'top-part'),
    array('11', 'FORMAÇÃO, SUSPENSÃO E EXTINÇÃO DO PROCESSO', 4, 'top-part'),
    array('12', 'INCIDENTES E AÇÕES: AÇÃO RESCISÓRIA', 4, 'low-part'),
    array('13', 'TEORIA GERAL DAS PROVAS', 4, 'low-part'),
    array('14', 'LITISCONSÓRCIO ', 3, 'low-part'),
    array('15', 'INTERVENÇÃO DE TERCEIROS', 3, 'low-part'),
    array('16', 'AÇÕES CONSTITUCIONAIS: AÇÃO CIVIL PÚBLICA', 2, 'low-part'),
    array('17', 'PRINCÍPIOS GERAIS DO DIREITO PROCESSUAL CIVIL ', 2, 'low-part'),
    array('18', 'JURISDIÇÃO', 2, 'low-part'),
    array('19', 'MINISTÉRIO PÚBLICO', 2, 'low-part'),
    array('20', 'PROCESSO DE CONHECIMENTO. PETIÇÃO INICIAL. VALOR DA CAUSA', 2, 'low-part'),
    array('22', 'DA TUTELA URGÊNCIA', 1, 'low-part'),
    array('21', 'JULGAMENTO CONFORME O ESTADO DO PROCESSO', 1, 'low-part'),
    array('23', 'AÇÃO DE ALIMENTOS', 1, 'low-part'),
    array('24', 'AUDIÊNCIA DE INSTRUÇÃO E JULGAMENTO (AIJ).', 1, 'low-part'),
    array('25', 'LITIGÂNCIA DE MÁ FÉ', 1, 'low-part'),
    array('26', 'DO PROCESSO ELETRÔNICO', 1, 'low-part'),
    array('27', 'AUDIENCIA DE CONCILIAÇÃO E MEDIAÇÃO', 1, 'low-part'),
    array('28', 'GRATUIDADE DA JUSTIÇA', 1, 'low-part'),
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
                    <p>De acordo com a tabela exposta, a disciplina Direito Processual Civil compõe o terceiro grupo de disciplinas mais importantes da prova, pois foi contemplada com 06 questões no último exame, o que corresponde à 15% da pontuação necessária para a aprovação do candidato na 1ª Fase.</p>
                    <p>A partir deste momento será exposta uma análise 360º da referida disciplina na primeira fase, visando oferecer dados concretos ao candidato, para que o mesmo possa elaborar o seu plano de estudos de forma segura e precisa. </p>
                    <p>Com base no Edital apresentado pela FGV para a prova prático-discursiva, bem como observando algumas obras jurídicas específicas para o Exame de Ordem, buscou-se elencar uma lista com temas passíveis de cobrança na 1ª fase.</p>
                    <p>Para Direito Processual Civil foram selecionados os temas a seguir:</p>
";

$textVisaoGeralConclusao = "
                    <p>Os temas apontados no gráfico devem ser priorizados pelo candidato para que o mesmo possa avançar para a 2ª Fase. É importante observar que os temas “Procedimentos especiais”, “Teoria da execução”, “Sentença e coisa julgada” e “Teoria geral do recurso. Remessa necessária e recursos em espécie. Recursos para o supremo tribunal federal e para o superior tribunal de justiça” correspondem a quase 50% do total de incidência da prova nesta disciplina, o que demostra uma necessidade especial de aprofundamento no estudo dos referidos temas.</p>
                    <p>O Análise 360º proporciona o direcionamento do estudo do candidato a partir de uma criteriosa pesquisa científica, focando seus esforços nos temas efetivamente cobrados nas provas, conduzindo-o à aprovação no Exame da Ordem. Trata-se de um mapeamento completo oferecido exclusivamente pela Equipe do Brasil Jurídico, pensado e elaborado para você.</p>
</p>
";
?>

@include( 'frontend.studentarea.analysis.body' )
