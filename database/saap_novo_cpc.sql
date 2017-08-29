alter table executions drop column exam_id;

alter table executions drop index executions_exam_id_foreign;

alter table executions drop foreign key executions_exam_id_foreign;

insert into subjects (id, name, created_at, updated_at, subject_id) values (1, 'NOVO CPC', now(), now(), null);
insert into subjects (id, name, created_at, updated_at, subject_id) values (2, 'PARTE GERAL', now(), now(), 1);
insert into subjects (id, name, created_at, updated_at, subject_id) values (3, 'DAS NORMAS PROCESSUAIS CIVIS', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (4, 'Normas fundamentais do novo Processo Civil (2� parte) � arts. 5� a 12�', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (5, 'Aplica��o das normas processuais � arts. 13 a 15', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (6, 'Normas fundamentais do novo Processo Civil (1� parte) � arts. 1� a 4�', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (7, 'DA FUN��O JURISDICIONAL ', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (8, 'Compet�ncia � arts. 42 a 66', now(), now(), 7);
insert into subjects (id, name, created_at, updated_at, subject_id) values (9, 'Da coopera��o internacional � arts. 26 a 41', now(), now(), 7);
insert into subjects (id, name, created_at, updated_at, subject_id) values (10, 'DOS SUJEITOS DO PROCESSO', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (11, 'Capacidade processual � arts. 70 a 76; Deveres das partes e dos procuradores � arts. 77 e 78', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (12, 'Cita��o � arts. 236 a 259', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (13, 'Litiscons�rcio � arts. 113 a 118', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (14, 'Interven��o de terceiros: aspectos gerais, assist�ncia e denuncia��o da lide � arts. 119 a 124', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (15, 'Deveres das partes e dos procuradores � arts. 77 e 78', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (16, 'Despesas, honor�rios advocat�cios e multas � arts. 79 a 96', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (17, 'Interven��o de terceiros: chamamento ao processo, incidente de desconsidera��o da personalidade jur�dica e amicuscuriae � arts. 130 a 138', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (18, 'Juiz: impedimento e suspei��o � arts. 144 a 148', now(), now(), 10);

