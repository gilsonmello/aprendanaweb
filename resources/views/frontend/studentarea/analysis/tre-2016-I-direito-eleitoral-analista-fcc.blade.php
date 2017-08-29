
<?php
$titulodisciplina = "DIREITO ELEITORAL";

$titulo = " | TRE 2016 - Analista - FCC | " . $titulodisciplina;

$logo = "analise-360-oab.png";

$provas = 05;

$questoes = 76;

$questoesNaDisciplina = 76;

$questoesPorProva = 70;

$questoesParaAprovacao = 40;

$disciplinas = array(
    array('Lei dos Partidos Políticos (Lei nº 9.096/1995 e alterações posteriores).', 13, 'top-part', 76),
    array('Lei de Inelegibilidade (Lei Complementar nº 64/1990 e alterações posteriores da Lei da Ficha Limpa – Lei Complementar nº 135/2010). ', 7, 'top-part', 76),
    array('Dos Órgãos da Justiça Eleitoral; ', 6, 'top-part', 76),
    array('Disposições Várias: Dos recursos; ', 5, 'top-part', 76),
    array('Código Eleitoral (Lei nº 4.737/1965 e alterações posteriores):', 4, 'top-part', 76),
    array('Lei das Eleições (Lei nº 9.504/1997 e alterações posteriores). ', 4, 'top-part', 76),
    array('Das Eleições; ', 3, 'top-part', 76),
    array('Resolução TSE nº 21.538/2003 (Alistamento e Serviços Eleitorais mediante processamento eletrônico de dados). ', 3, 'top-part', 76),
    array('Disposições Penais. ', 2, 'top-part', 76),
);

$temasMaisFrequentesBaseSuperior = 8;
$temasMaisFrequentesBaseInferior = 6;

$temasMaisFrequentes = array(
    array('Lei dos Partidos Políticos (Lei nº 9.096/1995 e alterações posteriores).', 13),
    array('Lei de Inelegibilidade (Lei Complementar nº 64/1990 e alterações posteriores da Lei da Ficha Limpa – Lei Complementar nº 135/2010). ', 7),
    array('Dos Órgãos da Justiça Eleitoral; ', 6),
    array('Disposições Várias: Dos recursos; ', 5),
);

$temas = array(
    array('Lei dos Partidos Políticos (Lei nº 9.096/1995 e alterações posteriores)'),
    array('Lei de Inelegibilidade (Lei Complementar nº 64/1990 e alterações posteriores da Lei da Ficha Limpa – Lei Complementar nº 135/2010)'),
    array('Dos Órgãos da Justiça Eleitoral'),
    array('Disposições Várias: Dos recursos'),
    array('Código Eleitoral (Lei nº 4.737/1965 e alterações posteriores)'),
    array('Lei das Eleições (Lei nº 9.504/1997 e alterações posteriores)'),
    array('Das Eleições'),
    array('Resolução TSE nº 21.538/2003 (Alistamento e Serviços Eleitorais mediante processamento eletrônico de dados)'),
    array('Disposições Penais'),
);


$temasJaExigidos = array(
    array('Lei dos Partidos Políticos (Lei nº 9.096/1995 e alterações posteriores)', ''),
    array('Lei de Inelegibilidade (Lei Complementar nº 64/1990 e alterações posteriores da Lei da Ficha Limpa – Lei Complementar nº 135/2010)', ''),
    array('Dos Órgãos da Justiça Eleitoral', ''),
    array('Disposições Várias: Dos recursos', ''),
    array('Código Eleitoral (Lei nº 4.737/1965 e alterações posteriores)', ''),
    array('Lei das Eleições (Lei nº 9.504/1997 e alterações posteriores)', ''),
    array('Das Eleições', ''),
    array('Resolução TSE nº 21.538/2003 (Alistamento e Serviços Eleitorais mediante processamento eletrônico de dados)', ''),
    array('Disposições Penais', ''),
);

$temasNuncaExigidos = [];

$temasIncidencias = array(
    array('1', 'Lei dos Partidos Políticos (Lei nº 9.096/1995 e alterações posteriores).', 13, 'top-part', 76),
    array('2', 'Lei de Inelegibilidade (Lei Complementar nº 64/1990 e alterações posteriores da Lei da Ficha Limpa – Lei Complementar nº 135/2010). ', 7, 'top-part', 76),
    array('3', 'Dos Órgãos da Justiça Eleitoral; ', 6, 'top-part', 76),
    array('4', 'Disposições Várias: Dos recursos; ', 5, 'top-part', 76),
    array('5', 'Código Eleitoral (Lei nº 4.737/1965 e alterações posteriores):', 4, 'top-part', 76),
    array('6', 'Lei das Eleições (Lei nº 9.504/1997 e alterações posteriores). ', 4, 'top-part', 76),
    array('7', 'Das Eleições; ', 3, 'top-part', 76),
    array('8', 'Resolução TSE nº 21.538/2003 (Alistamento e Serviços Eleitorais mediante processamento eletrônico de dados). ', 3, 'top-part', 76),
    array('9', 'Disposições Penais. ', 2, 'top-part', 76),
);


$textVisaoGeralOAB = "
                    <p>O Tribunal Regional Eleitoral de Pernambuco abriu edital em 30 de agosto de 2016 para provimento de vagas e cadastro reserva para os cargos de Analista e Técnico judiciário. 
A banca examinadora escolhida pelo Tribunal foi a CEBRASPE, razão pela qual desenvolveu-se um estudo minucioso das últimas 05 provas aplicadas pela referida banca em concursos de TREs para os Analista Judiciário – Área Judiciária e Técnico Judiciário – área Administrativa. </p>
";


$textVisaoGeralDisciplina = "";
$textVisaoGeralConclusao = "";
?>

@include( 'frontend.studentarea.analysis.body_tre_fcc' )
