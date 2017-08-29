
<?php
$titulodisciplina = "DIREITO ELEITORAL";

$titulo = " | TRE 2016 - Tecnico - FCC | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 05;

$questoes = 76;

$questoesNaDisciplina = 76;

$questoesPorProva = 70;

$questoesParaAprovacao = 55;

$disciplinas = array(
    array('Código eleitoral (Lei nº 4.737/1965 e alterações posteriores). Introdução. Dos órgãos da Justiça Eleitoral. Das eleições. Disposições várias. Das garantias eleitorais. Dos recursos. Disposições penais. Disposições gerais e transitórias.', 18, 'top-part', 76),
    array('Lei dos partidos políticos (Lei nº 9.096/1995 e alterações posteriores) ', 17, 'top-part', 76),
    array('Lei das eleições (Lei nº 9.504/1997 e alterações posteriores) ', 16, 'top-part', 76),
    array('Noções de direito eleitoral. Conceito e fontes ', 2, 'top-part', 76),
    array('Lei de inelegibildiade (Lei complementar nº 64/1990 e alterações posteriores.)', 1, 'top-part', 76),
    array('Fornecimento gratuito de transporte em dias de eleição, a eleitores residentes nas zonas rurais (Lei nº 6.091/1974 e alterações posteriores).', 1, 'top-part', 76),
);

$temasMaisFrequentesBaseSuperior = 8;
$temasMaisFrequentesBaseInferior = 6;

$temasMaisFrequentes = array(
    array('Código eleitoral (Lei nº 4.737/1965 e alterações posteriores). Introdução. Dos órgãos da Justiça Eleitoral. Das eleições. Disposições várias. Das garantias eleitorais. Dos recursos. Disposições penais. Disposições gerais e transitórias.', 18),
    array('Lei dos partidos políticos (Lei nº 9.096/1995 e alterações posteriores) ', 17),
    array('Lei das eleições (Lei nº 9.504/1997 e alterações posteriores) ', 16),
);

$temas = array(
    array('1. Código eleitoral (Lei nº 4.737/1965 e alterações posteriores). Introdução. Dos órgãos da Justiça Eleitoral. Das eleições. Disposições várias. Das garantias eleitorais. Dos recursos. Disposições penais. Disposições gerais e transitórias.'),
    array('2. Lei dos partidos políticos (Lei nº 9.096/1995 e alterações posteriores)'),
    array('3. Lei das eleições (Lei nº 9.504/1997 e alterações posteriores)'),
    array('4. Noções de direito eleitoral. Conceito e fontes'),
    array('5. Lei de inelegibildiade (Lei complementar nº 64/1990 e alterações posteriores.)'),
    array('6. Fornecimento gratuito de transporte em dias de eleição, a eleitores residentes nas zonas rurais (Lei nº 6.091/1974 e alterações posteriores).'),
);

$temasJaExigidos = array(
    array('1. Código eleitoral (Lei nº 4.737/1965 e alterações posteriores). Introdução. Dos órgãos da Justiça Eleitoral. Das eleições. Disposições várias. Das garantias eleitorais. Dos recursos. Disposições penais. Disposições gerais e transitórias.', ''),
    array('2. Lei dos partidos políticos (Lei nº 9.096/1995 e alterações posteriores)', ''),
    array('3. Lei das eleições (Lei nº 9.504/1997 e alterações posteriores)', ''),
    array('4. Noções de direito eleitoral. Conceito e fontes', ''),
    array('5. Lei de inelegibildiade (Lei complementar nº 64/1990 e alterações posteriores.)', ''),
    array('6. Fornecimento gratuito de transporte em dias de eleição, a eleitores residentes nas zonas rurais (Lei nº 6.091/1974 e alterações posteriores).', ''),
);

$temasNuncaExigidos = [];

$temasIncidencias = array(
    array('1', 'Código eleitoral (Lei nº 4.737/1965 e alterações posteriores). Introdução. Dos órgãos da Justiça Eleitoral. Das eleições. Disposições várias. Das garantias eleitorais. Dos recursos. Disposições penais. Disposições gerais e transitórias.', 18, 'top-part', 76),
    array('2', 'Lei dos partidos políticos (Lei nº 9.096/1995 e alterações posteriores) ', 17, 'top-part', 76),
    array('3', 'Lei das eleições (Lei nº 9.504/1997 e alterações posteriores) ', 16, 'top-part', 76),
    array('4', 'Noções de direito eleitoral. Conceito e fontes ', 2, 'top-part', 76),
    array('5', 'Lei de inelegibildiade (Lei complementar nº 64/1990 e alterações posteriores.)', 1, 'top-part', 76),
    array('6', 'Fornecimento gratuito de transporte em dias de eleição, a eleitores residentes nas zonas rurais (Lei nº 6.091/1974 e alterações posteriores).', 1, 'top-part', 76),
);


$textVisaoGeralOAB = "
                    <p>O Tribunal Regional Eleitoral de Pernambuco abriu edital em 30 de agosto de 2016 para provimento de vagas e cadastro reserva para os cargos de Analista e Técnico judiciário. 
A banca examinadora escolhida pelo Tribunal foi a CEBRASPE, razão pela qual desenvolveu-se um estudo minucioso das últimas 05 provas aplicadas pela referida banca em concursos de TREs para os Analista Judiciário – Área Judiciária e Técnico Judiciário – área Administrativa. </p>
";


$textVisaoGeralDisciplina = "";
$textVisaoGeralConclusao = "";
?>

@include( 'frontend.studentarea.analysis.body_tre_fcc' )
