alter table executions drop column exam_id;

alter table executions drop index executions_exam_id_foreign;

alter table executions drop foreign key executions_exam_id_foreign;

insert into subjects (id, name, created_at, updated_at, subject_id) values (1, 'NOVO CPC', now(), now(), null);
insert into subjects (id, name, created_at, updated_at, subject_id) values (2, 'PARTE GERAL', now(), now(), 1);
insert into subjects (id, name, created_at, updated_at, subject_id) values (3, 'DAS NORMAS PROCESSUAIS CIVIS', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (4, 'Normas fundamentais do novo Processo Civil (2ª parte) – arts. 5º a 12º', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (5, 'Aplicação das normas processuais – arts. 13 a 15', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (6, 'Normas fundamentais do novo Processo Civil (1ª parte) – arts. 1º a 4º', now(), now(), 3);
insert into subjects (id, name, created_at, updated_at, subject_id) values (7, 'DA FUNÇÃO JURISDICIONAL ', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (8, 'Competência – arts. 42 a 66', now(), now(), 7);
insert into subjects (id, name, created_at, updated_at, subject_id) values (9, 'Da cooperação internacional – arts. 26 a 41', now(), now(), 7);
insert into subjects (id, name, created_at, updated_at, subject_id) values (10, 'DOS SUJEITOS DO PROCESSO', now(), now(), 2);
insert into subjects (id, name, created_at, updated_at, subject_id) values (11, 'Capacidade processual – arts. 70 a 76; Deveres das partes e dos procuradores – arts. 77 e 78', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (12, 'Citação – arts. 236 a 259', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (13, 'Litisconsórcio – arts. 113 a 118', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (14, 'Intervenção de terceiros: aspectos gerais, assistência e denunciação da lide – arts. 119 a 124', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (15, 'Deveres das partes e dos procuradores – arts. 77 e 78', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (16, 'Despesas, honorários advocatícios e multas – arts. 79 a 96', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (17, 'Intervenção de terceiros: chamamento ao processo, incidente de desconsideração da personalidade jurídica e amicuscuriae – arts. 130 a 138', now(), now(), 10);
insert into subjects (id, name, created_at, updated_at, subject_id) values (18, 'Juiz: impedimento e suspeição – arts. 144 a 148', now(), now(), 10);

