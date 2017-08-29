
<?php

$titulodisciplina = "Direito Civil";

$titulo = " | Exame OAB 2º Fase | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 21;

$questoes = 68;

$pecas = 22;

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
        array('1', 'RECURSO DE APELAÇÃO', 2, 'II, XIX', 'top-part' ),
        array('2', 'RECURSO DE AGRAVO DE INSTRUMENTO COM ANTECIPAÇÃO DE TUTELA RECURSAL',  2, 'XIV, XX', 'top-part' ),
        array('3', 'EMBARGOS DE TERCEIRO', 2, 'X, XVIII' , 'top-part'),
        array('4', 'AÇÃO INDENIZATÓRIA POR DANOS MORAIS E MATERIAIS', 1, 'III', 'low-part' ),
        array('5', 'AÇÃO DE ALIMENTO com pedido de fixação initio litis de ALIMENTOS PROVISÓRIOS', 1, 'IV', 'low-part' ),
        array('6', 'AÇÃO DE CONHECIMENTO COM PEDIDO DE ANTECIPAÇÃO DE TUTELA', 1, 'V', 'low-part' ),
        array('7', 'AÇÃO CAUTELAR PREPARATÓRIA COM PEDIDO DE LIMINAR', 1, 'V', 'low-part' ),
        array('8', 'AÇÃO CAUTELAR DE BUSCA E APREENSÃO DE PESSOA', 1, 'VI', 'low-part' ),
        array('9', 'AÇÃO ORDINÁRIA COM PEDIDO DE TUTELA ANTECIPADA', 1, 'VI', 'low-part' ),
        array('10', 'AÇÃO DE USUCAPIÃO ESPECIAL URBANO', 1, 'VIII', 'low-part' ),
        array('11', 'AÇÃO DE ALIMENTOS GRAVÍDICOS', 1, 'IX', 'low-part' ),
        array('12', 'AÇÃO DE IMISSÃO NA POSSE', 1, 'XI', 'low-part' ),
        array('13', 'AÇÃO DE INTERDIÇÃO COM PEDIDO DE ANTECIPAÇÃO DE TUTELA', 1, 'XII', 'low-part' ),
        array('14', 'AÇÃO DE OBRIGAÇÃO DE FAZER COM PEDIDO DE TUTELA ANTECIPADA', 1, 'XIII', 'low-part' ),
        array('15', 'RECURSO ESPECIAL', 1, 'XV', 'low-part' ),
        array('16', 'CONTESTAÇÃO', 1, 'XVI', 'low-part' ),
        array('17', 'AÇÃO DE CONSIGNAÇÃO EM PAGAMENTO', 1, 'XVII', 'low-part' ),
        array('18', 'AÇÃO PAULIANA', 1, 'XX (PORTO VELHO)', 'low-part' ),
        array('19', 'AÇÃO DECLARATÓRIA DE INEXISTÊNCIA DE DÉBITO C/C OBRIGAÇÃO DE FAZER E INDENIZAÇÃO POR DANOS MORAIS', 1, 'VII', 'low-part' )
      );

$temasPecasIncidencias = array(
        array('1', 'Lei 8.078/1990 – Código de Defesa do Consumidor', 4, 'VII, XIII, XV, XIX', 'top-part' ),
        array('2', 'Teoria da Responsabilidade civil', 3 , 'II, III, XVI', 'top-part' ),
        array('3', 'Teoria Geral das Obrigações', 2 , 'II, XVII', 'low-part' ),
        array('4', 'Direitos Reais', 2 , 'X, XI', 'low-part' ),
        array('5', 'Fatos, Atos e Negócios Jurídicos: formação, validade, eficácia e elementos', 2, ' III, XX (Porto Velho)', 'low-part' ),
        array('6', 'Alimentos', 2 , 'IX, XX', 'low-part' ),
        array('7', 'Sucessão legítima', 1 , 'III', 'low-part' ),
        array('8', 'Prescrição e Decadência', 1 , 'II', 'low-part' ),
        array('9', 'Posse', 1 , 'X', 'low-part' ),
        array('10', 'Leis Civis Especiais', 1, 'VIII', 'low-part' ),
);

$temasQuestoesIncidencias = array(
        array('1', 'Lei 8.078/1990 – Código de Defesa do Consumidor',  9 , 'II, IV, VIII, X, XI, XIV, XV, XVII, XIX', 'top-part' ),
        array('2', 'Teoria Geral das Obrigações',  7 , 'II, III, V, IX, XIV, XV, XX (Porto Velho)', 'top-part' ),
        array('3', 'Direitos Reais',  7 , 'IV, VIII, XII, XVI, XVIII, XX, XX (Porto Velho)', 'top-part' ),
        array('4', 'Pessoa natural e Direitos da personalidade',  7 , 'V, IX, XIII, XVI, XIX, XX, XX (Porto Velho)', 'top-part' ),
        array('5', 'Contratos em espécie',  6 , 'VIII, XI, XIII, XIV, XIX, XX', 'top-part' ),
        array('6', 'Dissolução do Casamento e da União Estável',  5 , 'III, IV, X, XVII, XX (Porto Velho)', 'low-part' ),
        array('7', 'Fatos, Atos e Negócios Jurídicos: formação, validade, eficácia e elementos',  3 , 'VI, IX, XIII', 'low-part' ),
        array('8', 'Sucessão legítima',  3 , 'VII, XVIII, XX', 'low-part' ),
        array('9', 'Sucessão testamentária e disposições de última vontade',  3 , 'II, XVI, XVIII', 'low-part' ),
        array('10', 'Regimes de Bens e outros Direitos Patrimoniais nas relações familiares',  3 , 'VI, XVIII, XX (Porto Velho)', 'low-part' ),
        array('11', 'Alimentos',  2 , 'XI, XIV', 'low-part' ),
        array('12', 'Prescrição e Decadência',  2 , 'VI, VII', 'low-part' ),
        array('13', 'Parentesco',  2 , 'X, XII', 'low-part' ),
        array('14', 'Bens',  2 , 'XVIII, XIX', 'low-part' ),
        array('15', 'Teoria do Contrato',  2 , 'XIX, XX (Porto Velho)', 'low-part' ),
        array('16', 'Teoria da Responsabilidade civil',  1 , 'XVIII', 'low-part' ),
        array('17', 'Posse',  1 , 'XVII', 'low-part' ),
        array('18', 'Direito Civil e Constituição',  1 , 'XVII', 'low-part' ),
        array('19', 'Casamento, União Estável e Monoparentalidade',  1 , 'XVI', 'low-part' ),
        array('20', 'Modalidades de Responsabilidade civil e reparação',  1 , 'XVIII', 'low-part' ),
);


?>

@include( 'frontend.studentarea.analysis.body_2_fase' )
