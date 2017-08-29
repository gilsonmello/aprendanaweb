<?php

return [
    /*
      |--------------------------------------------------------------------------
      | CRUD Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines are used in CRUD operations throughout the
      | system.
      | Regardless where it is placed, a CRUD label can be listed here so it is easily
      | found in a intuitive way.
      |
     */

    'actions' => 'Ações',
    'send_coupon' => 'Enviar cupom de desconto',
    'send_button' => 'Enviar',
    'articles' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'date' => 'Data',
        'total' => 'Total de artigos',
        'img' => 'Imagem',
        'hits' => 'Visualiz.',
    ],
    'news' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'date' => 'Data',
        'total' => 'Total de artigos',
        'img' => 'Imagem',
        'hits' => 'Visualiz.',
    ],
    'faqs' => [
        'id' => 'ID',
        'name' => 'Nome',
        'description' => 'Descrição',
    ],
    'permissions' => [
        'name' => 'Nome',
        'permission' => 'Permissão',
        'roles' => 'Papéis',
        'system' => 'Sistema?',
        'total' => 'Total de permissões',
        'users' => 'Usuários',
    ],
    'roles' => [
        'number_of_users' => 'Nº de Usuários',
        'permissions' => 'Permissões',
        'role' => 'Papel',
        'total' => 'Total de papéis',
    ],
    'sections' => [
        'id' => 'ID',
        'name' => 'Nome',
        'total' => 'Total de Seções',
    ],
    'subsections' => [
        'id' => 'ID',
        'name' => 'Nome',
        'total' => 'Total de Subseções',
    ],
    'users' => [
        'confirmed' => 'Confirmado',
        'created' => 'Criado em',
        'delete_permanently' => 'Deletar Permanentemente',
        'email' => 'E-mail',
        'id' => 'ID',
        'last_updated' => 'Atualizado em',
        'name' => 'Nome',
        'no_banned_users' => 'Não existem usuários banidos',
        'no_deactivated_users' => 'Não existem usuários desativados',
        'no_deleted_users' => 'Não existem usuários deletados',
        'other_permissions' => 'Outras Permissões',
        'restore_user' => 'Restaurar Usuário',
        'roles' => 'Papéis',
        'total' => 'Total de usuários',
        'lesson' => 'Aula',
        'max_view' => 'Max. Visualizações',
        'view' => 'Num. Visualizações',
        'actions' => 'Ações',
        'percentage' => 'Percentual',
    ],
    'userstudents' => [
        'confirmed' => 'Confirmado',
        'created' => 'Criado em',
        'delete_permanently' => 'Deletar Permanentemente',
        'email' => 'E-mail',
        'id' => 'ID',
        'last_updated' => 'Atualizado em',
        'name' => 'Nome',
        'no_banned_users' => 'Não existem alunos banidos',
        'no_deactivated_users' => 'Não existem alunos desativados',
        'no_deleted_users' => 'Não existem alunos deletados',
        'other_permissions' => 'Outras Permissões',
        'restore_user' => 'Restaurar Aluno',
        'roles' => 'Papéis',
        'total' => 'Total de alunos',
    ],
    'newsletters' => [
        'confirmed' => 'Confirmado',
        'created' => 'Criado em',
        'delete_permanently' => 'Deletar Permanentemente',
        'email' => 'E-mail',
        'id' => 'ID',
        'created_at' => 'Criado',
        'name' => 'Nome',
        'total' => 'Total de newsletters',
        'campaing' => 'Campanha'
    ],
    'coupons' => [
        'id' => 'ID',
        'name' => 'Nome',
        'code' => 'Código',
        'start_date' => 'Data inicial',
        'due_date' => 'Data de vencimento',
        'limit' => 'Limite',
        'used' => 'Usados',
        'percentage' => 'Porcentagem Desc.',
        'value' => 'Valor Desc.',
        'total' => 'Total de Cupons',
    ],
    'faqcategory' => [
        'id' => 'ID',
        'description' => 'Descrição',
        'total' => 'Total de Categorias FAQ',
    ],
    'tags' => [
        'id' => 'ID',
        'name' => 'Nome',
        'description' => 'Descrição',
        'total' => 'Total de Tags',
        'active_at' => 'Ativado em',
        'user_moderator' => 'Moderado por',
    ],
    'videos' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'date' => 'Data de Ativação',
        'total' => 'Total de vídeos',
        'url' => 'URL',
        'img' => 'Imagem',
        'hits' => 'Visualiz.',
    ],
    'teacherstatements' => [
        'user_teacher_id' => 'Professor',
        'date' => 'Data',
        'date_order' => 'Data Compra',
        'user_buyer_id' => 'Comprador',
        'order_id' => 'Compra',
        'product_name' => 'Produto',
        'value_order' => 'Valor da Compra',
        'value_discount' => 'Desconto',
        'value_order_final' => 'Valor Final',
        'value_payment_tax' => 'Taxa de Pag.',
        'value_taxes' => 'Impostos',
        'value_costs' => 'Custos',
        'value_net' => 'Valor líquido',
        'percentage_distribute' => 'Perc. Distrib.',
        'value_distribute' => 'Valor Distrib.',
        'percentage' => 'Perc. Prof.',
        'value' => 'Valor',
        'balance' => 'Saldo',
        'del' => 'Del.',
        'orders_value' => 'Total de vendas',
        'orders_count' => 'Quant. de vendas',
        'payments_value' => 'Total de pagamentos',
        'payments_count' => 'Quant. de pagamentos',
        'balance_value' => 'Saldo do período',
        'records_count' => 'Quant. Lançamentos',
        'anticipations_value' => 'Total de Antecipações',
        'anticipations_count' => 'Quant. Antecipações',
    ],
    'contentscomments' => [
        'id' => 'ID',
        'publishfor' => 'Publicado Por',
        'comment' => 'Comentário',
        'total' => 'Total de Comentários',
    ],
    'tickets' => [
        'student' => 'Aluno',
        'sector' => 'Setor',
        'message' => 'Mensagem',
        'date_dead_line_reply' => 'Prazo para Resposta',
        'updated_at' => 'Últ. Modif.',
        'is_replied' => 'Respondido',
        'is_finished' => 'Finalizado',
        'finish' => 'Confirma a finalização do atendimento?',
        'id' => 'Atendimento Id',
        'total' => 'Atendimentos',
    ],
    'ticketmessages' => [
        'user' => 'Usuário',
        'created_at' => 'Data',
        'message' => 'Mensagem',
    ],
    'sectors' => [
        'name' => 'Nome',
        'total' => 'Total de setores',
    ],
    'cities' => [
        'id' => 'Código do IBGE',
        'name' => 'Nome',
        'state' => 'Estado',
        'total' => 'Total de cidades',
    ],
    'orders' => [
        'id' => 'Id',
        'student' => 'Aluno',
        'status' => 'Status',
        'date_registration' => 'Data do Pedido',
        'date_confirmation' => 'Confirmação',
        'price' => 'Valor',
        'discount_price' => 'Valor Líquido',
        'total' => 'Pedidos',
        'finish' => 'Concluído',
        'coupon_code' => 'Código do Cupom'
    ],
    /*
      |--------------------------------------------------------------------------
      | CRUD Language Lines outside view Files
      |--------------------------------------------------------------------------
      |
      | These lines are being marked as obsolete by the localization helper
      | because they will only be found outside view files.
      |
     */
    'activate_user_button' => 'Ativar Usuário',
    'ban_user_button' => 'Banir Usuário',
    'change_password_button' => 'Alterar Senha',
    'deactivate_user_button' => 'Desativar Usuário',
    'delete_button' => 'Deletar',
    'edit_button' => 'Editar',
    'edit_button_as_text' => 'Editar como texto',
    'faqs.total' => 'FAQ Total',
    'faqs.question' => 'Pergunta',
    'faqs' => [
        'question' => 'Pergunta',
        'answer' => 'Resposta',
        'id' => 'ID',
        'category' => 'Categoria'
    ],
    'courses' => [
        'img' => 'Imagem',
        'title' => 'Título',
        'price' => 'Preço',
        'average_grade' => 'Avaliação',
        'orders_count' => 'Vendas',
        'total' => 'Cursos',
    ],
    'coursealerts' => [
        'course' => 'Curso',
        'date' => 'Data',
        'description' => 'Descrição',
        'average_grade' => 'Avaliação',
        'total' => ' item(ns) de quadro de aviso'
    ],
    'coursecalendars' => [
        'course' => 'Curso',
        'date' => 'Data',
        'description' => 'Descrição',
        'average_grade' => 'Avaliação',
        'total' => ' item(ns) de calendário'
    ],
    'asktheteachers' => [
        'question' => 'Pergunta',
        'teacher' => 'Professor',
        'date' => 'Data',
        'replyed' => 'Respondida',
        'total' => ' dúvida(s)'
    ],
    'offices' => [
        'name' => 'Nome',
        'description' => 'Descriçao',
        'total' => ' cargo(s)'
    ],
    'sources' => [
        'name' => 'Nome',
        'description' => 'Descriçao',
        'total' => ' banca(s)'
    ],
    'subjects' => [
        'name' => 'Nome',
        'description' => 'Descriçao',
        'parent' => 'Item pai',
        'children' => 'Filho',
        'total' => ' assunto(s)'
    ],
    'institutions' => [
        'name' => 'Nome',
        'description' => 'Descriçao',
        'total' => ' instituição(ões)'
    ],
    'questions' => [
        'name' => 'Enunciado',
        'total' => ' questão(ões)'
    ],
    'exams' => [
        'title' => 'Título',
        'total' => ' SAAP(s)',
        'groups_button' => 'Grupos de Questões',
        'questions_button' => 'Questões',
        'move_button' => 'Mover',
        'average_grade' => "Nota média",
        'orders_count' => "Total de Pedidos",
        'price' => "Preço",
        'conf_questions_button' => "Conferência de Questões",
    ],
    'groupquestions' => [
        'number' => 'Sequência',
        'text' => 'Enunciado',
        'total' => 'Questões',
    ],
    'groups' => [
        'title' => 'Título',
        'total' => 'Grupos de Questões',
    ],
    'packages' => [
        'title' => 'Título',
        'total' => 'Pacotes de SAAP',
    ],
    'packageexams' => [
        'title' => 'Título',
        'total' => "SAAP's",
    ],
    'packageteachers' => [
        'title' => 'Professor',
        'total' => "Professores",
    ],
    'examcourses' => [
        'total' => "Cursos",
    ],
    'partners' => [
        'name' => "Nome",
        'total' => "Conveniados",
        'days_subscribe' => "Limite (dias) para inscrição",
    ],
    'partner_managers' => [
        'create' => "Criar Gerente(s)",
    ],
    'partnerorders' => [
        'total' => "Pedidos de Conveniados",
        'external_course_id' => "ID Externo de Curso",
        'html_email' => "HTML E-mail Inscrição",
        'html_subscribe' => "HTML Página Inscrição",
        'total_enrollments' => 'Total de matrículas',
        'used_enrollments' => 'Matrículas usadas',
        'partner' => 'Conveniado',
        'course' => 'Curso',
    ],
    'studentgroups' => [
        'name' => "Nome",
        'total' => "Turmas",
    ],
    'preenrollments' => [
        'total' => "Pré-matrículas",
        'date_email' => "Data email",
        'date_deadline' => "Prazo inscrição",
        'date_activation' => "Data inscrição",
        'external_course_id' => "ID Externo de Curso",
        'html_email' => "HTML E-mail Inscrição",
        'html_subscribe' => "HTML Página Inscrição",
        'email_enrollment_button' => "Enviar email de inscrição",
        'addday_enrollment_button' => "Ampliar em um dia o prazo",
        'addweek_enrollment_button' => "Ampliar em uma semana o prazo",
        'email_button' => "Enviar email de inscrição",
    ],
    'advertisingpartners' => [
        'name' => "Nome",
        'total' => "Parceiros Comerciais",
    ],
    'add' => "Adicionar",
    'banners' => [
        'name' => "Nome",
        'total' => "Banners",
    ],
    'lessons' => [
        'img' => "Imagem",
        'price' => "Preço",
        'title' => "Título",
        'total' => "Aulas",
    ],
    'modules' => [
        'img' => "Imagem",
        'name' => "Nome",
        'price' => "Preço",
        'total' => "Módulo",
    ],
    'sliders' => [
        'name' => "Nome",
        'total' => "Slider",
    ],
    'subjectcourses' => [
        'total' => "Cursos",
    ],
    'userteachers' => [
        'total' => "Professores",
    ],
    'enrollments' => [
        'activate_enrollment_button' => "Ativar matrícula",
        'deactivate_enrollment_button' => "Desativar matrícula",
        'addday_enrollment_button' => "Adicionar mais um dia",
        'addweek_enrollment_button' => "Adicionar mais uma semana",
        'addmonth_enrollment_button' => "Adicionar mais um mês",
        'activate_enrollment_button' => "Ativar matrícula",
        'id' => "Id",
        'product' => "Produto",
        'date_begin' => "Data Início",
        'date_end' => "Date Fim",
        'total_test' => "Matrídulas de Teste",
    ],
    'themes' => [
        'total' => "Temas",
    ],
    'occupations' => [
        'description' => 'Descrição',
        'total' => ' ocupação(ões)'
    ],
    'workshops' => [
        'description' => 'Descrição',
        'total' => ' oficina(s)'
    ],
    'workshopactivitys' => [
        'name' => 'Descrição',
        'description' => 'Descrição',
        'total' => ' atividades(s)',
        'url_document' => 'Folha de resposta',
        'url_response' => 'Espelho de resposta',
        'text_response' => 'Resposta',
    ],
    'workshoptutors' => [
        'tutor' => 'Tutor',
        'criteria' => ' Ctitério',
        'position' => 'Posição',
        'max_students' => 'Máximo de Estudantes',
        'num_students' => 'Número de Matriculados',
        'total' => ' tutor(es)'
    ],
    'workshopevaluationgroups' => [
        'position' => 'Posição',
        'max_students' => 'Máximo de Estudantes',
        'num_students' => 'Número de Matriculados',
        'total' => ' grupo(s) de avaliação',
    ],
    'workshopgrouptutors' => [
        'tutor' => 'Tutor',
        'activity' => 'Atividade',
        'total' => ' tutor(es) no grupo',
    ],
    'workshopcriterias' => [
        'name' => 'Nome',
        'total' => ' critério(s)',
    ],
    'myworkshopevaluations' => [
        'url_evaluation' => 'Enviar correção',
        'evaluation' => 'Correção',
        'total' => ' Avaliação(ões) de Atividade(s)',
        'text_response' => ' Espelho de resposta',
        'text' => 'Enunciado',
        'edit_tutor_activity' => 'Alterar tutor da atividade',
    ],
    'myworkshoptutors' => [
        'count' => 'Aluno(s) sem tutor(es)',
        'total' => 'Aluno(s) com tutor(es)'
    ],
    'analysis' => [
        'intro_page' => 'Página de Introdução',
        'intro_text' => 'Texto de Introdução',
        'conclusion_text' => 'Texto de Conclusão',
    ],
    'partnerorderpayments' => [
        'total' => 'Pagamento(s)'
    ],
];
