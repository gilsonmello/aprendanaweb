<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Alert Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain alert messages for various scenarios
      | during CRUD operations. You are free to modify these language lines
      | according to your application's requirements.
      |
     */
    'products' => [
        'created' => 'Produto cadastrado com sucesso.',
        'created_error' => 'Erro ao cadastrar produto',
        'updated' => 'Produto atualizado com sucesso.',
        'updated_error' => 'Erro ao atualizar produto.',
        'deleted' => 'Produto deletado com sucesso.',
        'deleted_error' => 'Erro ao deletar produto.'
    ],
    'suppliers' => [
        'created' => 'Fornecedor cadastrado com sucesso.',
        'created_error' => 'Erro ao cadastrar fornecedor',
        'updated' => 'Fornecedor atualizado com sucesso.',
        'updated_error' => 'Erro ao atualizar fornecedor.',
        'deleted' => 'Fornecedor deletado com sucesso.',
        'deleted_error' => 'Erro ao deletar fornecedor.'
    ],
    'articles' => [
        'created' => 'Artigo criado com sucesso.',
        'updated' => 'Artigo atualizado com sucesso.',
        'deleted' => 'Artigo excluído com sucesso.'
    ],
    'faqs' => [
        'created' => 'FAQ criado com sucesso.',
        'updated' => 'FAQ atualizado com sucesso.',
        'deleted' => 'FAQ excluído com sucesso.'
    ],
    'coupons' => [
        'created' => 'Cupom criado com sucesso.',
        'updated' => 'Cupom atualizado com sucesso.',
        'deleted' => 'Cupom excluído com sucesso.',
        'sent' => 'Cupon enviado.',
        'toimport' => 'toimport',
    ],
    'newsletters' => [
        'created' => 'Newsletter criada com sucesso.',
        'updated' => 'Newsletter atualizada com sucesso.',
        'deleted' => 'Newsletter deletada com sucesso.'
    ],
    'permissions' => [
        'created' => 'Permissão criada com sucesso.',
        'updated' => 'Permissão atualizada com sucesso.',
        'deleted' => 'Permissão deletada com sucesso.'
    ],
    'roles' => [
        'created' => 'O papel foi criado com sucesso.',
        'updated' => 'O papel foi atualizado com sucesso.',
        'deleted' => 'O papel foi excluído com sucesso.'
    ],
    'sections' => [
        'created' => 'Seção criada com sucesso.',
        'updated' => 'Seção atualizada com sucesso.',
        'deleted' => 'Seção excluída com sucesso.'
    ],
    'subsections' => [
        'created' => 'Subseção criada com sucesso.',
        'updated' => 'Subseção atualizada com sucesso.',
        'deleted' => 'Subseção atualizada com sucesso.'
    ],
    'users' => [
        'created' => 'O usuário foi criado com sucesso.',
        'updated' => 'O usuário foi atualizado com sucesso.',
        'deleted' => 'O usuário foi excluído com sucesso.',
        'deleted_permanently' => 'O usuário foi excluído permanentemente.',
        'restored' => 'O usuário foi restaurado com sucesso.',
        'updated_password' => "A senha do usuário foi atualizada com sucesso.",
        'confirmation_email' => 'Uma nova confirmação de e-mail será enviada.'
    ],
    'videos' => [
        'created' => 'Vídeo criado com sucesso.',
        'updated' => 'Vídeo atualizado com sucesso.',
        'deleted' => 'Vídeo excluído com sucesso.',
        'empty' => 'Aula sem blocos.',
    ],
    'faqcategory' => [
        'created' => 'Categoria FAQ criada com sucesso.',
        'updated' => 'Categoria FAQ atualizada com sucesso.',
        'deleted' => 'Categoria FAQ deletada com sucesso.'
    ],
    'tags' => [
        'created' => 'Tag criada com sucesso.',
        'updated' => 'Tag atualizada com sucesso.',
        'deleted' => 'Tag deletada com sucesso.',
        'activated' => 'Tag ativada',
        'deactivated' => 'Tag desativada',
    ],
    'userstudent' => [
        'created' => 'O aluno foi criado com sucesso.',
        'updated' => 'O aluno foi atualizado com sucesso.',
        'deleted' => 'O aluno foi excluído com sucesso.',
        'deleted_permanently' => 'O aluno foi excluído permanentemente.',
        'restored' => 'O aluno foi restaurado com sucesso.',
        'updated_password' => "A senha do aluno foi atualizada com sucesso.",
        'confirmation_email' => 'Uma nova confirmação de e-mail será enviada.'
    ],
    'contentcomments' => [
        'created' => 'Comentário criado com sucesso.',
        'updated' => 'Comentário autorizado com sucesso.',
        'deleted' => 'Comentário excluído com sucesso.',
        'deactivated' => 'Comentário Desativado',
        'activated' => 'Comentário Ativado'
    ],
    'contactus' => [
        'send' => 'Mensagem enviada com sucesso. Por favor, aguarde o retorno de nossa equipe de atendimento.',
        'send_error' => 'Erro ao enviar mensagem. Tente novamente.'
    ],
    'processteacherstatements' => [
        'processed' => 'Processamento de pagamento executado com sucesso!',
        'invalid_date' => 'Data inválida!',
        'notprocessed' => 'Processamento de pagamento FALHOU!',
    ],
    'generaldiscount' => [
        'invalid_date_begin' => 'Data inicial inválida!',
        'invalid_date_end' => 'Data final inválida!',
        'invalid_percentage' => 'Percentual informado inválido!',
        'applied' => 'Desconto aplicado!',
        'notapplied' => 'Desconto NÃO aplicado!',
    ],
    'preenrollments' => [
        'login_fail' => 'Falha no login!',
        'password_empty' => 'Informe a senha!',
        'password_different' => 'Senhas indformadas são diferentes!',
        'terms_accepted' => 'É necessário fazer o aceite dos termos!',
        'error' => 'Ocorreu um erro ao tentar confirmar a sua matrícula! Entre em contato com nosso suporte.',
        'active' => 'Prematrícula ativada',
        'created' => 'Prematrícula criada',
        'dayadded' => 'Prazo de inscrição extendido em 1 dia',
        'deleted' => 'Prematrícula excluída',
        'emailsent' => 'E-mail enviado',
        'imported' => 'Prematrículas importadas',
        'importfilenotinformed' => 'Arquivo não informado',
        'is_enrollment' => 'Prematrícula já confirmada',
        'updated' => 'Pré matrícula atualizada',
        'weekadded' => 'Prazo de inscrição extendido em 1 semana',
        'order_not_active' => 'Contrato não encontra-se ativo.',
        'total_enrollments_reached' => 'Total de matrículas contratadas já se esgotou.',
        'deadline' => 'Você ultrapassou o prazo de inscrição.',
        'password_minimum_6_char' => 'A sua senha deve ter no mínimo 6 caracteres.',
    ],
    'asktheteachers' => [
        'created' => 'Tira dúvida criada com sucesso.',
        'updated' => 'Tira dúvida atualizada com sucesso.',
        'deleted' => 'Tira dúvida deletada com sucesso.'
    ],
    'banners' => [
        'created' => 'Banner criado com sucesso.',
        'updated' => 'Banner atualizado com sucesso.',
        'deleted' => 'Banner excluído com sucesso.'
    ],
    'cities' => [
        'created' => 'Cidade criada com sucesso.',
        'updated' => 'Cidade atualizada com sucesso.',
        'deleted' => 'Cidade deletada com sucesso.'
    ],
    'configurations' => [
        'created' => 'Configuração criada com sucesso.',
        'updated' => 'Configuração atualizada com sucesso.',
        'deleted' => 'Configuração deletada com sucesso.'
    ],
    'coursecreated' => 'Curso criado com sucesso.',
    'coursedeleted' => 'Curso excluído com sucesso.',
    'courseupdated' => 'Curso atualizado com sucesso.',
    'coursealerts' => [
        'created' => 'Aviso criado com sucesso.',
        'sendbyemail' => 'Enviar aviso para os alunos por e-mail.',
        'sendemail' => 'Aviso enviado por e-mail com sucesso.',
        'errorsendemail' => 'Erro ao enviar e-mails ou o curso não possue nenhum aluno.',
        'updated' => 'Aviso atualizado com sucesso.',
        'deleted' => 'Aviso excluído com sucesso.'
    ],
    'coursecalendars' => [
        'created' => 'Item de calendário criado com sucesso.',
        'updated' => 'Item de calendário atualizado com sucesso.',
        'deleted' => 'Item de calendário excluído com sucesso.'
    ],
    'courses' => [
        'block' => 'Curso bloqueado.',
        'created' => 'Curso criado com sucesso.',
        'deleted' => 'Curso excluído com sucesso.',
        'teachers_empty' => 'Professor não informado.',
        'unblock' => 'Curso desbloqueado.',
        'updated' => 'Curso atualizado com sucesso.',
    ],
    'examcourses' => [
        'addsuccess' => 'Curso adicionado com sucesso.',
        'created' => '',
    ],
    'groupquestions' => [
        'addsuccess' => 'Questão adicionada com sucesso',
    ],
    'exams' => [
        'created' => 'SAAP criado com sucesso.',
        'deleted' => 'SAAP excluído com sucesso',
        'updated' => 'SAAP atualizado com sucesso',
    ],
    'groupquestion' => [
        'changesequenceerror' => 'Não foi possível mudar a sequência.',
        'changesequencesuccess' => 'Sequência alterada com sucesso.',
        'addsuccess' => 'Questão adicionada com sucesso',
    ],
    'institutions' => [
        'created' => 'Instituição criada com sucesso.',
        'deleted' => 'Instituição deletada com sucesso',
        'updated' => 'Instituição atualizada com sucesso',
    ],
    'lessons' => [
        'created' => 'Aula criada com sucesso.',
        'deleted' => 'Aula deletada com sucesso',
        'empty' => 'Nenhuma aula adicionada.',
        'updated' => 'Aula atualizada com sucesso',
    ],
    'modules' => [
        'created' => 'Módulo criado com sucesso.',
        'deleted' => 'Módulo excluído com sucesso',
        'empty' => 'Nenhuma módulo adicionado.',
        'updated' => 'Módulo atualizado com sucesso',
        'noname' => "É necessário informar um nome para o módulo"
    ],
    'news' => [
        'created' => 'Notícia criada com sucesso.',
        'deleted' => 'Notícia deletada com sucesso',
        'updated' => 'Notícia atualizada com sucesso',
    ],
    'offices' => [
        'created' => 'Cargo criado com sucesso.',
        'deleted' => 'Cargo excluído com sucesso',
        'updated' => 'Cargo atualizado com sucesso',
    ],
    'orders' => [
        'activated' => 'Pedido ativado.',
        'deactivated' => 'Pedido desativado.',
        'created' => 'Pedido criado com sucesso.',
        'deleted' => 'Pedido excluído com sucesso',
        'updated' => 'Pedido atualizado com sucesso',
    ],
    'packageexams' => [
        'addsuccess' => 'SAAP adicionado com sucesso.',
    ],
    'packages' => [
        'created' => 'Pacote de SAAP criado com sucesso.',
        'deleted' => 'Pacote de SAAP excluído com sucesso',
        'updated' => 'Pacote de SAAP atualizado com sucesso',
    ],
    'packageteachers' => [
        'addsuccess' => 'Professor adicionado com sucesso.',
    ],
    'partnerorders' => [
        'created' => 'Pedido de Conveniado criado com sucesso.',
        'deleted' => 'Pedido de Conveniado excluído com sucesso',
        'updated' => 'Pedido de Conveniado atualizado com sucesso',
    ],
    'partners' => [
        'created' => 'Conveniado criado com sucesso.',
        'deleted' => 'Conveniado excluído com sucesso',
        'updated' => 'Conveniado atualizado com sucesso',
    ],
    'partnermanager' => [
        'created_or_update' => 'Gerente criado ou alterado com sucesso.'
    ],
    'advertisingpartners' => [
        'created' => 'Parceiro Comercial criado com sucesso.',
        'deleted' => 'Parceiro Comercial excluído com sucesso',
        'updated' => 'Parceiro Comercial atualizado com sucesso',
    ],
    'questions' => [
        'created' => 'Questão criada com sucesso.',
        'deleted' => 'Questão deletada com sucesso',
        'updated' => 'Questão atualizada com sucesso',
    ],
    'report' => [
        'select_at_least_one_dim' => 'Selecione ao menos uma das dimesões.',
        'select_course' => 'Selecione um curso',
    ],
    'sectors' => [
        'created' => 'Setor criado com sucesso.',
        'deleted' => 'Setor excluído com sucesso',
        'updated' => 'Setor atualizado com sucesso',
    ],
    'sliders' => [
        'created' => 'Slider criado com sucesso.',
        'deleted' => 'Slider excluído com sucesso',
        'updated' => 'Slider atualizado com sucesso',
    ],
    'sources' => [
        'created' => 'Banca criada com sucesso.',
        'deleted' => 'Banca deletada com sucesso',
        'updated' => 'Banca atualizada com sucesso',
    ],
    'studentgroups' => [
        'created' => 'Turma criada com sucesso.',
        'deleted' => 'Turma deletada com sucesso',
        'updated' => 'Turma atualizada com sucesso',
    ],
    'subjectcourses' => [
        'addsuccess' => 'Curso adicionado com sucesso.',
        'created' => 'Relação curso x assunto criada com sucesso.',
        'deleted' => 'Relação curso x assunto deletada com sucesso',
        'updated' => 'Relação curso x assunto atualizada com sucesso',
    ],
    'subjects' => [
        'created' => 'Assunto criado com sucesso.',
        'deleted' => 'Assunto excluído com sucesso',
        'updated' => 'Assunto atualizado com sucesso',
    ],
    'teachers' => [
        'deleted' => 'Processor excluído',
    ],
    'teacherstatements' => [
        'activated' => 'Lançamento no extrato ativado',
        'deactivated' => 'Lançamento no extrato desativado',
        'created' => 'Lançamento no extrato criado com sucesso.',
        'deleted' => 'Lançamento no extrato excluído com sucesso',
        'updated' => 'Lançamento no extrato atualizado com sucesso',
    ],
    'tickets' => [
        'created' => 'Atendimento criado com sucesso.',
        'deleted' => 'Atendimento excluído com sucesso.',
        'updated' => 'Atendimento atualizado com sucesso.',
        'finish' => 'Atendimento finalizado com sucesso.',
        'message_replied' => 'Atendimento respondido.',
    ],
    'userstudents' => [
        'created' => 'Aluno criado com sucesso.',
        'deleted' => 'Aluno excluído com sucesso.',
        'updated' => 'Aluno atualizado com sucesso.',
    ],
    'userteachers' => [
        'created' => 'Professor criado com sucesso.',
        'deleted' => 'Professor excluído com sucesso.',
        'updated' => 'Professor atualizado com sucesso.',
    ],
    'myworkshoptutors' => [
        'created' => 'Tutor criado com sucesso.',
        'deleted' => 'Tutor excluído com sucesso.',
        'updated' => 'Tutor atualizado com sucesso.',
    ],
    'webinars' => [
        'created' => 'Webinar criado com sucesso.',
        'deleted' => 'Webinar excluído com sucesso.',
        'updated' => 'Webinar atualizado com sucesso.',
        'error' => 'Erro ao Criar ou Alterar o Webinar.',
    ],
    
    'enrollments' => [
        'created' => 'Matrícula criada com sucesso.',
        'updated' => 'Matrícula atualizada com sucesso.',
        'error' => 'Erro ao criar matrícula.',
        'upated_error' => 'Erro ao atualizar matrícula'
    ],
];
