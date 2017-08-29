
<?php

$titulodisciplina = "Direito Penal";

$titulo = " | Exame OAB 2º Fase | " . $titulodisciplina;

$logo = "analise-360-oab-2.png";

$provas = 21;

$questoes = 82;

$pecas = 20;

$temasMaisFrequentesBaseSuperior = 24 + 1;
$temasMaisFrequentesBaseInferior = 9 - 2;

$temasMaisFrequentes = array(
        array('TEORIA GERAL DAS OBRIGAÇÕES', 24 ),
        array('DIREITOS REAIS', 22 ),
        array('CONTRATOS EM ESPÉCIE', 20 ),
        array('PESSOA NATURAL E DIREITOS DA PERSONALIDADE', 13 ),
        array('FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS', 9 ),
      );

$pecasMaisFrequentesBaseSuperior = 24 + 1;
$pecasMaisFrequentesBaseInferior = 9 - 2;

$pecasMaisFrequentes = array(
        array('TEORIA GERAL DAS OBRIGAÇÕES', 24 ),
        array('DIREITOS REAIS', 22 ),
        array('CONTRATOS EM ESPÉCIE', 20 ),
        array('PESSOA NATURAL E DIREITOS DA PERSONALIDADE', 13 ),
        array('FATOS, ATOS E NEGÓCIOS JURÍDICOS: FORMAÇÃO, VALIDADE, EFICÁCIA E ELEMENTOS', 9 ),
);

$pecasIncidencias = array(
        array('1', 'ALEGAÇÕES FINAIS - MEMORIAIS', 6, 'IX, XIV, XVII, XVIII, XX, XX (PORTO VELHO)', 'top-part' ),
        array('2', 'APELAÇÃO',	5	, 'IV, V, VII, XII, XIII', 'top-part' ),
        array('3', 'RECURSO EM SENTIDO ESTRITO',	3, 'II, III, XI', 'top-part' ),
        array('4', 'RELAXAMENTO DE PRISÃO', 1, 'VI', 'low-part' ),
        array('5', 'RESPOSTA À ACUSAÇÃO', 1, 'VIII', 'low-part' ),
        array('6', 'REVISÃO CRIMINAL', 1, 'X', 'low-part' ),
        array('7', 'QUEIXA CRIME', 1, 'XV', 'low-part' ),
        array('8', 'AGRAVO EM EXECUÇÃO', 1, 'XVI', 'low-part' ),
        array('9', 'CONTRARRAZÕES DE APELAÇÃO', 1, 'XIX', 'low-part' ),
      );

$temasPecasIncidencias = array(
        array('1', 'Teoria Geral do Delito.  Conduta, Relação de Causalidade, Teoria da imputação objetiva, Tipo penal doloso, Tipo penal culposo, Tipicidade, Antijuridicidade, Culpabilidade, Consumação e tentativa, Desistência Voluntária, Arrependimento eficaz, Arrependimento posterior, Crime impossível, Erro de tipo, Erro de proibição,  Erro de tipo permissivo.',	10	, 'V; VIII; IX; X; XI; XII; XIV;XVII;XIX;XX', 'top-part' ),
        array('2', 'Aplicação da Lei Penal.  Lei Penal no Tempo  Lei Penal no Espaço.', 10, 'V; VIII; IX; X; XI; XII; XIV;XVII;XIX;XX', 'top-part' ),
        array('3', 'Penas e seus critérios de aplicação, Origens e Finalidades da pena, Espécies de penas, Aplicação da pena,  Concurso de crimes, Suspensão condicional da pena.',	9	, 'V; IX; X; XII; XIII; XIV; XV; XVII; XIX', 'top-part' ),
        array('4', 'Princípios penais e constitucionais.',	6, 'I;V;VI; XII; XIII; XIX', 'low-part' ),
        array('5', 'Criminologia.', 	4	, 'II; III; XII; XIV; ', 'low-part' ),
        array('6', 'Crimes em espécie.',	4	, 'XVI; XVIII;XIX;XX(Porto Velho)', 'low-part' ),
        array('7', 'Ação Penal.',	3	, 'II,VIII, IX', 'low-part' ),
        array('8', 'Causas Extintivas de Punibilidade.',	3, 'I;  XIX;  XVII', 'low-part' ),
        array('9', 'Execução Penal. Livramento condicional, Progressão e regressão de regime, Remição, Detração, Incidentes de execução.', 	2, 'X; XVI;', 'low-part' ),
);

$temasQuestoesIncidencias = array(
        array('1', 'Teoria Geral do Delito.  Conduta, Relação de Causalidade, Teoria da imputação objetiva, Tipo penal doloso, Tipo penal culposo, Tipicidade, Antijuridicidade, Culpabilidade, Consumação e tentativa, Desistência Voluntária, Arrependimento eficaz,  arrependimento posterior, Crime impossível, Erro de tipo, Erro de proibição,  Erro de tipo permissivo.',	21	, 'II; VI (3x) VII (3x); VIII (2x); IX; X; XI; XII (2x); XV; XVII, XVIII (2X) XIX (2); XX', 'top-part' ),
        array('2', 'Criminologia.', 	14	,'I; II; III (2x); IV;V (2x); VII (2x) VIII; XIX; XIII (2x); XVI', 'top-part' ),
        array('3', 'Penas e seus critérios de aplicação, Origens e Finalidades da pena,  espécies de penas, Aplicação da pena,  Concurso de crimes, Suspensão condicional da pena.',	11	, 'II; V; VIII; X; XI (2); XIII; XVI; XX (Porto Velho), XX (2x)', 'top-part' ),
        array('4', 'Crimes em espécie.', 9, 'II; X; XII; XIII; XVIII (2X), XIX; XX (Porto Velho), XX', 'top-part' ),
        array('5', 'Princípios penais e constitucionais.', 8, 'IV (2x); VII;VIII; XIX; X; XVI;XX (Porto Velho)', 'top-part' ),
        array('6', 'Execução Penal. Livramento condicional, Progressão e regressão de regime, Remição, Detração, Incidentes de execução.',	8	, 'II; X; XI; XII; XIII; XIV; XV; XX (Porto Velho)', 'top-part' ),
        array('7', 'Ação Penal.', 5, 'V (2X);XVI;XX (Porto Velho);XX', 'low-part' ),
        array('8', 'Aplicação da Lei Penal.  Lei Penal no Tempo  Lei Penal no Espaço.', 5, 'II; III;VII; XIV; XVI', 'low-part' ),
        array('9', 'Concurso de Pessoas.', 5, 'III; VI;XIX; X; XVIII', 'low-part' ),
        array('10', 'Causas Extintivas de Punibilidade.',	4	,'III; V; VIII; XV;', 'low-part' ),
        array('11', 'Leis Penais Especiais',	3	,'IV; VII; XIX', 'low-part' ),
);


?>

@include( 'frontend.studentarea.analysis.body_2_fase' )
