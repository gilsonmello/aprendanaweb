
<?php

$titulodisciplina = "Direito do Trabalho";

$titulo = " | Exame OAB 2º Fase | " . $titulodisciplina;

$logo = "analise-360-oab-2.png";

$provas = 21;

$questoes = 82;

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
        array('1', 'CONTESTAÇÃO', 8, 'II, IV, V, VI, VIII, XI, XVII, XVIII', 'top-part' ),
        array('2', 'RECURSO ORDINÁRIO', 7 , 'III, VII, IX, XV, XVI, XIX, XX (PORTO VELHO)', 'top-part' ),
        array('3', 'PETIÇÃO INICIAL', 4, 'XII, XIV, XX', 'low-part' ),
        array('4', 'EMBARGOS À EXECUÇÃO', 1, 'XIII', 'low-part' )
      );

$temasPecasIncidencias = array(
        array('1', 'Jornada de trabalho e horário de trabalho.',	10, 'II, III, IV, VI, VII, VIII, IX, XVIII, XIX, XX', 'top-part' ),
        array('2', 'Prescrição e decadência no Direito do Trabalho.',	8, 'II, III, VI,VII, VIII, XI, XV, XVIII', 'top-part' ),
        array('3', 'Descanso anual: férias.',	6, 'II, IV, VI, VIII, X, XVIII', 'top-part' ),
        array('4', 'Adicionais.', 5, 'VI, VIII, XVI, XVII, XVIII', 'top-part' ),
        array('5', 'Trabalho extraordinário.', 5, 'VIII, IX, XIV, XVII, XVIII', 'top-part' ),
        array('6', 'O Fundo de Garantia do Tempo de Serviço.', 4, 'VI, IX, X, XVI', 'top-part' ),
        array('7', 'Multa do art. 477 da CLT.', 4, 'III, XI, XVI, XVII', 'top-part' ),
        array('8', 'Aviso prévio.', 4, 'X; XI; XVIII, XX', 'top-part' ),
        array('9', 'Repousos intrajornada e interjornada.', 4, 'XI, XVIII, XIX, XX', 'top-part' ),
        array('10', 'Pré-contratações: requisitos para configuração, efeitos, direitos decorrentes, hipótese de perdas e danos.', 3, 'XIV, XV, XVI', 'low-part' ),
        array('11', 'Equiparação salarial.', 3, 'II, IV, XVII', 'low-part' ),
        array('12', 'Estabilidade e garantias provisórias de emprego: conceito, caracterização e distinções.', 2, 'VII; XVIII', 'low-part' ),
        array('13', 'Transferência de local de trabalho.', 2, 'V, XVII', 'low-part' ),
        array('14', 'Periculosidade e insalubridade.', 2, 'III, VII', 'low-part' ),
        array('15', 'Trabalho noturno.', 2, 'VI, XVIII', 'low-part' ),
        array('16', 'Efeitos conexos do contrato: direitos intelectuais; invenções do empregado; direitos autorais e propriedade intelectual; indenizações por dano moral e material.', 2, 'VIII; XII', 'low-part' ),
        array('17', '13º salário.', 2, 'VIII, X', 'low-part' ),
        array('18', 'Alteração do contrato de emprego.', 2, 'VIII, IX', 'low-part' ),
        array('19', 'Interrupção e suspensão do contrato de trabalho: conceito, caracterização, distinções.', 1, 'IV', 'low-part' ),
        array('20', 'Princípios do Direito do Trabalho.', 1, 'IX', 'low-part' ),
        array('21', 'Efeitos da dispensa arbitrária ou sem justa causa: readmissão e reintegração.', 1, 'IV', 'low-part' ),
        array('22', 'Salário in natura e utilidades não salariais.', 1, 'XX', 'low-part' ),
        array('23', 'Instrumentos normativos negociados: acordo coletivo e convenção coletiva de trabalho.', 1, 'II', 'low-part' ),
        array('24', 'Princípios constitucionais do Direito do Trabalho.', 1, 'IX', 'low-part' ),
        array('25', 'Contrato de emprego: denominação, conceito, classificação, caracterização.', 1, 'XX', 'low-part' ),
        array('26', 'Parcelas não-salariais.', 1, 'XI', 'low-part' ),
        array('27', 'O princípio da igualdade de salário.', 1, 'VI', 'low-part' ),
        array('28', 'Acidente do trabalho: conceito, classificação, espécies de danos indenizáveis.', 1, 'XIX', 'low-part' ),
        array('29', 'Justa causa.', 1, 'VII', 'low-part' ),
        array('30', 'Obrigações decorrentes da cessação do contrato de emprego.', 1, 'X', 'low-part' ),
        array('31', 'Contrato de experiência e período de experiência.', 1, 'XX', 'low-part' ),
        array('32', 'Salário e indenização.', 1, 'XX (Porto Velho)', 'low-part' ),
        array('33', 'Horas in itinere.', 1, 'XX (Porto Velho)', 'low-part' ),
);

$temasQuestoesIncidencias = array(
        array('1', 'Jornada de trabalho e horário de trabalho.',	6, 'VI; XII; XVI; XVII; XIX,XX (Porto Velho)', 'low-part' ),
        array('2', 'Remuneração e salário: conceito, distinções.', 5, 'IV; VIII; IX; XVII; XIX', 'low-part' ),
        array('3', 'Interrupção e suspensão do contrato de trabalho: conceito, caracterização, distinções.', 4, 'IX; XI; XIV; XVIII', 'low-part' ),
        array('4', 'Prescrição e decadência no Direito do Trabalho.', 3, 'III; VII; XV', 'low-part' ),
        array('5', 'Adicionais.', 3, 'XIII; XVI; XIX', 'low-part' ),
        array('6', 'O Fundo de Garantia do Tempo de Serviço.', 3, 'XIII; XIV, XX', 'low-part' ),
        array('7', 'Princípios do Direito do Trabalho.', 3, 'III; XIII; XV', 'low-part' ),
        array('8', 'Efeitos da dispensa arbitrária ou sem justa causa: readmissão e reintegração.', 3, 'XIII; XIV; XIX', 'low-part' ),
        array('9', 'Estabilidade e garantias provisórias de emprego: conceito, caracterização e distinções.', 2, 'II; XIV', 'low-part' ),
        array('10', 'Transferência de local de trabalho.', 2, 'VI; XX', 'low-part' ),
        array('11', 'Grupo econômico.', 2, 'III; V', 'low-part' ),
        array('12', 'Responsabilidade na terceirização.', 2, 'IV; XVII', 'low-part' ),
        array('13', 'Salário in natura e utilidades não salariais.', 2, 'III; IV', 'low-part' ),
        array('14', 'Jus variandi.', 2, 'III; VI', 'low-part' ),
        array('15', 'A greve no direito brasileiro.', 2, 'III; V', 'low-part' ),
        array('16', 'Contrato de emprego: denominação, conceito, classificação, caracterização.', 2, 'XI; XX', 'low-part' ),
        array('17', 'Repouso semanal e em feriados.', 2, 'VIII;XIV', 'low-part' ),
        array('18', 'Acidente do trabalho: conceito, classificação, espécies de danos indenizáveis.', 2, 'XIV; XX', 'low-part' ),
        array('19', 'Trabalho extraordinário.', 1, 'XII', 'low-part' ),
        array('20', 'Multa do art. 477 da CLT.', 1, 'XI', 'low-part' ),
        array('21', 'Periculosidade e insalubridade.', 1, 'XIII', 'low-part' ),
        array('22', 'Trabalho noturno.', 1, 'XV', 'low-part' ),
        array('23', 'Instrumentos normativos negociados: acordo coletivo e convenção coletiva de trabalho.', 1, 'X', 'low-part' ),
        array('24', 'Repousos intrajornada e interjornada.', 1, 'XX', 'low-part' ),
        array('25', 'Direito do Trabalho: conceito, características, divisão, natureza, funções, autonomia.', 1, 'VII', 'low-part' ),
        array('26', 'Empregador: conceito, caracterização.', 1, 'V', 'low-part' ),
        array('27', 'Sucessão de empregadores.', 1, 'IV', 'low-part' ),
        array('28', 'Terceirização no Direito do Trabalho.', 1, 'IV', 'low-part' ),
        array('29', 'Nulidades: total e parcial.', 1, 'IV', 'low-part' ),
        array('30', 'Acordo de prorrogação e acordo de compensação de horas.', 1, 'VII', 'low-part' ),
        array('31', 'Função de confiança.', 1, 'X', 'low-part' ),
        array('32', 'Remuneração simples e dobrada.', 1, 'XVI', 'low-part' ),
        array('33', 'Gorjetas.', 1, 'IX', 'low-part' ),
        array('34', 'Parcelas não-salariais.', 1, 'XX (Porto Velho)', 'low-part' ),
        array('35', 'Rescisão unilateral: despedida do empregado.', 1, 'VI', 'low-part' ),
        array('36', 'Resolução por inadimplemento das obrigações do contrato.', 1, 'VII', 'low-part' ),
        array('37', 'Indenização por tempo de serviço: conceito e fundamento jurídico.', 1, 'XIV', 'low-part' ),
        array('38', 'Direitos e interesses difusos, coletivos e individuais homogêneos na esfera trabalhista.', 1, 'V', 'low-part' ),
        array('39', 'Aposentadoria.', 1, 'XVIII', 'low-part' ),
        array('40', 'Empregado doméstico: conceito, caracterização, Lei Federal 5.859/72.', 1, 'XX (Porto Velho)', 'low-part' ),
);


?>

@include( 'frontend.studentarea.analysis.body_2_fase' )
