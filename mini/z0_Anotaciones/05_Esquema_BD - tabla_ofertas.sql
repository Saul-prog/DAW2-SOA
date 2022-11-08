-----------------------------------------------------------------------------
-- Estructura de la tabla "ofertas".
-----------------------------------------------------------------------------
DROP TABLE IF EXISTS `ofertas`;
CREATE TABLE IF NOT EXISTS `ofertas` (
  `idOferta` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la linea de oferta.',
  `refArt` varchar(10) NOT NULL COMMENT 'Referencia al articulo relacionado.',
  `precio` float NOT NULL COMMENT 'Precio del articulo con 2 decimales',
  `activa` tinyint(1) NOT NULL COMMENT 'Si la oferta esta activa o no.',
  `notas` text COMMENT 'Notas internas para la Oferta.',  
  PRIMARY KEY (`idOferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
-----------------------------------------------------------------------------

-----------------------------------------------------------------------------
-----------------------------------------------------------------------------
