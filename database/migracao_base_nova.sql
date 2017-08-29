-- mudar default dos campos de datas das tabelas (contents, view, view_log, enrollments, coupons, newsletters, tickets, ticket_messages, assigned_roles, users)

SET FOREIGN_KEY_CHECKS = 0;

delete from content_notes;

delete from content_comments;

delete from ask_the_teacher;

delete from notification_message;

delete from notification_user;

delete from question_notes;

delete from assigned_roles where user_id > 300;

ALTER TABLE assigned_roles AUTO_INCREMENT = 301;

delete from users where id > 300;

ALTER TABLE users AUTO_INCREMENT = 301;

delete from ticket_messages;

ALTER TABLE ticket_messages AUTO_INCREMENT = 1;

delete from tickets;

ALTER TABLE tickets AUTO_INCREMENT = 1;

delete from newsletters;

ALTER TABLE newsletters AUTO_INCREMENT = 1;

delete from coupons;

ALTER TABLE coupons AUTO_INCREMENT = 1;

delete from enrollments;

ALTER TABLE enrollments AUTO_INCREMENT = 1;

delete from view;

ALTER TABLE view AUTO_INCREMENT = 1;

delete from view_log;

ALTER TABLE view_log AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 0;

delete from coupon_user;

ALTER TABLE coupon_user AUTO_INCREMENT = 1;

delete from orders;

ALTER TABLE orders AUTO_INCREMENT = 1;

delete from order_courses;

ALTER TABLE order_courses AUTO_INCREMENT = 1;

delete from order_packages;

ALTER TABLE order_packages AUTO_INCREMENT = 1;

delete from ticket_messages;

ALTER TABLE ticket_messages AUTO_INCREMENT = 1;

delete from tickets;

ALTER TABLE tickets AUTO_INCREMENT = 1;

delete from newsletters;

ALTER TABLE newsletters AUTO_INCREMENT = 1;

delete from coupons;

ALTER TABLE coupons AUTO_INCREMENT = 1;

delete from enrollments;

ALTER TABLE enrollments AUTO_INCREMENT = 1;

delete from view;

ALTER TABLE view AUTO_INCREMENT = 1;

delete from view_log;

ALTER TABLE view_log AUTO_INCREMENT = 1;

delete from executions;

ALTER TABLE executions AUTO_INCREMENT = 1;

delete from answers_executions;

ALTER TABLE answers_executions AUTO_INCREMENT = 1;

delete from questions_executions;

ALTER TABLE questions_executions AUTO_INCREMENT = 1;

delete from view_exams;

ALTER TABLE view_exams AUTO_INCREMENT = 1;

delete from study_plans;

ALTER TABLE study_plans AUTO_INCREMENT = 1;

delete from preenrollments;

ALTER TABLE preenrollments AUTO_INCREMENT = 1;

delete from studentgroups;

ALTER TABLE studentgroups AUTO_INCREMENT = 1;

-- marcar noticias como destaque

-- buscar artigos sem autores

-- buscar viedos sem autores

--  preencher package x teacher

-- preencher sector x user

SET FOREIGN_KEY_CHECKS = 1;




SET FOREIGN_KEY_CHECKS = 0;


insert into newsletters (id, name, email, created_at, updated_at, deleted_at)
select id + 1000, nome, email, data_cadastro, data_cadastro, null from brjrestore.newsletters;

SET FOREIGN_KEY_CHECKS = 0;

UPDATE brjrestore.alunos SET data_nascimento = '1990-01-01' WHERE year(data_nascimento) = 0;

UPDATE brjrestore.alunos SET data_ultimo_acesso = '1990-01-01' WHERE year(data_ultimo_acesso) = 0;

insert into users (id, name, email, password, status, confirmation_code, confirmed, created_at, updated_at, deleted_at, photo,
cel, personal_id, address, professional_number, neighborhood, city_id, zip, address_number, address_comp,
is_newsletter_subscriber, gender, birthdate, last_access)
select a.id + 8000, nome, email, '', 1, senha, true, data_cadastro, data_cadastro, null, arquivo_foto,
 mid(telefone, 1, 20), cpf, mid(logradouro, 1, 100), '',  mid(bairro, 1, 100), c.id, cep, mid(numero, 1, 10), mid(complemento, 1, 100),
0, if(sexo=2,'F','M'), data_nascimento, data_ultimo_acesso
from brjrestore.alunos a, cities c, states s
where excluido = false and short = estado and c.state_id = s.id and c.name = cidade
and email not in ('bruno.moura@agencianuve.com.br', 'mariana@brasiljuridico.com.br', 'gesoaldo@brasiljuridico.com.br', 'edmarsampaio@gmail.com', 'adrianacarvalho@brasiljuridico.com.br', 'adhemarfontes@gmail.com', 'daniele@brasiljuridico.com.br', 'cinara@brasiljuridico.com.br', 'daiane@brasiljuridico.com.br', 'gilson@brasiljuridico.com.br',  'bruno@brasiljuridico.com.br', 'lucas.reis@salvedigital.com.br', 'paulo@jus.com.br', 'adhemar.fontes@ipq.com.br', 'joao@joaoglicerio.com' , 'ciolynho@yahoo.com.br' , 'nandarayne@hotmail.com', 'franciscofontenele.fonte@gmail.com', 'fortunato.priscilla@gmail.com', 'rcsampaio@tre-ba.jus.br'   );

insert into users (id, name, email, password, status, confirmation_code, confirmed, created_at, updated_at, deleted_at, photo,
cel, personal_id, address, professional_number, neighborhood, city_id, zip, address_number, address_comp,
is_newsletter_subscriber, gender, birthdate, last_access)
select id + 8000, nome, email, '', 1, senha, true, data_cadastro, data_cadastro, null, arquivo_foto,
 mid(telefone, 1, 20), cpf, mid(logradouro, 1, 100), '',  mid(bairro, 1, 100), null, cep, mid(numero, 1, 10), mid(complemento, 1, 100),
0, if(sexo=2,'F','M'), data_nascimento, data_ultimo_acesso
from brjrestore.alunos where excluido = false and email not in ( 'acioly@brasiljuridico.com.br', '', 'bruno.moura@agencianuve.com.br', 'mariana@brasiljuridico.com.br', 'gesoaldo@brasiljuridico.com.br', 'edmarsampaio@gmail.com', 'adrianacarvalho@brasiljuridico.com.br', 'adhemarfontes@gmail.com', 'daniele@brasiljuridico.com.br', 'cinara@brasiljuridico.com.br', 'daiane@brasiljuridico.com.br', 'gilson@brasiljuridico.com.br',  'bruno@brasiljuridico.com.br', 'lucas.reis@salvedigital.com.br', 'paulo@jus.com.br', 'adhemar.fontes@ipq.com.br', 'joao@joaoglicerio.com', 'ciolynho@yahoo.com.br' , 'nandarayne@hotmail.com', 'franciscofontenele.fonte@gmail.com' , 'fortunato.priscilla@gmail.com' , 'rcsampaio@tre-ba.jus.br'     )
and id not in (
select a.id from brjrestore.alunos a, cities c, states s
where a.cidade = c.name and short = a.estado and s.id = c.state_id and excluido = false);

insert into assigned_roles( id, user_id, role_id)
select id + 8000, id + 8000, 3 from brjrestore.alunos where (id + 8000) in (select id from users);

SET FOREIGN_KEY_CHECKS = 0;

insert into tickets (id, user_student_id, sector_id, message, date_dead_line_reply, is_replied, is_finished, created_at, updated_at, deleted_at)
select id + 3000, aluno_id + 8000, 1, descricao, DATE_ADD(data_cadastro ,INTERVAL 5 DAY), respondida, status, data_cadastro, data_cadastro, null
from  brjrestore.iteracoes where iteracao_id = 0;

insert into ticket_messages (id, ticket_id, user_id, message, created_at, updated_at, deleted_at)
select id + 1000, iteracao_id + 3000, aluno_id + 8000, descricao, data_cadastro, data_cadastro, null
from  brjrestore.iteracoes where iteracao_id != 0 and aluno_id != 0;

insert into ticket_messages (id, ticket_id, user_id, message, created_at, updated_at, deleted_at)
select id + 1000, iteracao_id + 3000, administrador_id + 100, descricao, data_cadastro, data_cadastro, null
from  brjrestore.iteracoes where iteracao_id != 0 and administrador_id != 0;

SET FOREIGN_KEY_CHECKS = 0;

insert into coupons (id , name, code, start_date, due_date, `limit`, used, percentage, value, created_at, updated_at, deleted_at, institutional)
select id + 1000, titulo, codigo, data_inicio, data_fim, quantidade_uso, quantidade_usado, porcentagem, dinheiro, data_cadastro, data_cadastro, null, 0
from brjrestore.cupons where excluido = 0;

update coupons set partner_id = null, advertisingpartner_id = null;
update coupons set advertisingpartner_id = 1 where name like '%correio%';

SET FOREIGN_KEY_CHECKS = 0;

UPDATE brjrestore.pedidos SET data_cancelamento = '2014-01-01' WHERE year(data_cancelamento) = 0;

UPDATE brjrestore.pedidos SET data_liberacao = '2014-01-01' WHERE year(data_liberacao) = 0;

insert into orders (id, student_id, coupon_id, status_id, date_registration, date_confirmation, date_cancel, price, discount_price, created_at, updated_at, deleted_at)
select id + 1000, aluno_id + 8000, cupom_id + 1000, status, data_cadastro, data_liberacao, data_cancelamento, preco + ifnull(dinheiro_cupom, 0), (preco + ifnull(dinheiro_cupom, 0)) - ifnull(dinheiro_cupom, 0), data_cadastro, data_cadastro, null
from brjrestore.pedidos where preco_liquido = 0 and porcentagem_cupom != 0;

insert into orders (id, student_id, coupon_id, status_id, date_registration, date_confirmation, date_cancel, price, discount_price, created_at, updated_at, deleted_at)
select id + 1000, aluno_id + 8000, cupom_id + 1000, status, data_cadastro, data_liberacao, data_cancelamento, preco, preco, data_cadastro, data_cadastro, null
from brjrestore.pedidos where preco_liquido = 0 and porcentagem_cupom = 0;

insert into orders (id, student_id, coupon_id, status_id, date_registration, date_confirmation, date_cancel, price, discount_price, created_at, updated_at, deleted_at)
select id + 1000, aluno_id + 8000, cupom_id + 1000, status, data_cadastro, data_liberacao, data_cancelamento, preco + ifnull(dinheiro_cupom, 0), preco_liquido, data_cadastro, data_cadastro, null
from brjrestore.pedidos where preco_liquido != 0;


update orders set status_id = 12 where status_id = 0;
update orders set status_id = 12 where status_id = 1;
update orders set status_id = 12 where status_id = 2;
update orders set status_id = 15 where status_id = 3;
update orders set status_id = 14 where status_id = 5;
update orders set status_id = 14 where status_id = 4;
update orders set status_id = 14 where status_id = 6;
update orders set status_id = 5 where status_id = 15;
update orders set status_id = 4 where status_id = 14;
update orders set status_id = 2 where status_id = 12;

insert into order_courses (id, order_id, course_id, price, discount_price, created_at, updated_at, deleted_at)
select id + 1000, pedido_id + 1000, pacote_id, preco, preco, now(), now(), null
from brjrestore.itens;

SET FOREIGN_KEY_CHECKS = 0;

UPDATE brjrestore.matriculas SET data_expiracao = data_cadastro WHERE year(data_expiracao) = 0;

insert into enrollments(id, student_id, course_id, module_id, lesson_id, date_begin, date_end, is_active, is_paid, created_at, updated_at, deleted_at, order_id)
select id + 8000, aluno_id + 8000, pacote_id, null, null, data_cadastro, data_expiracao, ativo, 1, data_cadastro, data_cadastro, null, pedido_id + 1000
from brjrestore.matriculas;


SET FOREIGN_KEY_CHECKS = 0;

insert into view ( enrollment_id, content_id, max_view, view, created_at, updated_at, deleted_at)
select matricula_id + 8000, a.id, 2, count(*), now(), now(), null
from brjrestore.visualizacoes v, brjrestore.aulas_midias a
where v.aula_id = a.aula_id and v.midia_id = a.midia_id and v.excluido = false
group by   matricula_id, a.id, now(), now();

SET FOREIGN_KEY_CHECKS = 0;

insert into view_log ( enrollment_id, content_id, datetime_view, video_index_seconds, created_at, updated_at, deleted_at)
select matricula_id + 8000, a.id, data, 0, data, data, null
from brjrestore.visualizacoes v, brjrestore.aulas_midias a
where v.aula_id = a.aula_id and v.midia_id = a.midia_id and v.excluido = false;

update orders set discount_price = price where discount_price = 0;

update courses set orders_count = (select count(*) from orders, order_courses where courses.id = order_courses.course_id and order_courses.order_id = orders.id and status_id = 4);

update users set orders_count = (select count(*) from orders, order_courses, course_teachers where order_courses.order_id = orders.id and status_id = 4 and course_teachers.course_id = order_courses.course_id and course_teachers.teacher_id = users.id);

SET FOREIGN_KEY_CHECKS = 1;

