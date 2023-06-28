CREATE DATABASE task_list;

CREATE TABLE tasks (
	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    description VARCHAR(2000) NOT NULL,
	status VARCHAR(1) NOT NULL    
);

INSERT INTO tasks(title, description, status) 
VALUES('Bater o ponto', 'Lembrar de bater o ponto as 8, 11, 13 e 18 horas', 'p'),
      ('Entregar trabalho de Web II', 'Data da entrega: 29/06/2033', 'f');