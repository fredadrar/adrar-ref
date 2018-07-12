use `adrar-ref`;

DELETE FROM `equipment`;
DELETE FROM `category`;
DELETE FROM `room`;

INSERT INTO `category` VALUES
(1,'tour',9),
(2,'ecran',9),
(3,'imprimante',3),
(4,'projecteur',3);

INSERT INTO `room` VALUES
(1,'Réserve'),
(2,'Salle 1'),
(3,'Salle 2'),
(4,'Salle 3'),
(5,'Salle 4'),
(6,'Salle 5'),
(7,'La Salle Certif');

INSERT INTO `equipment` VALUES
(1,1,1,'tour_1'),
(2,1,2,'ecran_1'),
(3,1,3,'imprimante_1'),
(4,2,4,'projecteur_1'),
(5,3,1,'tour_2'),
(6,3,1,'tour_3'),
(7,6,1,'tour_4'),
(8,6,2,'ecran_2'),
(9,3,2,'ecran_3'),
(10,5,2,'ecran_4'),
(11,5,1,'tour_5'),
(12,3,2,'ecran_5'),
(13,2,3,'imprimante_2'),
(14,5,4,'projecteur_2'),
(15,4,1,'tour_6'),
(16,2,1,'tour_7'),
(17,2,1,'tour_8'),
(18,2,2,'ecran_6'),
(19,4,2,'ecran_7'),
(20,2,2,'ecran_8');