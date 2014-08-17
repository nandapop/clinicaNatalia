CREATE TABLE alergia (
  idAlergia_pk int(11) NOT NULL auto_increment,
  nombreAlergia varchar(50) default NULL,
  descripcion varchar(100) default NULL,
  PRIMARY KEY  (idAlergia_pk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'alergiapaciente'
-- 

CREATE TABLE alergiapaciente (
  idAlergia_pk_fk int(11) NOT NULL default '0',
  idPac_pk_fk int(11) NOT NULL default '0',
  comentarios varchar(255) default NULL,
  PRIMARY KEY  (idAlergia_pk_fk,idPac_pk_fk),
  KEY idPac_pk_fk (idPac_pk_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'categoriausuario'
-- 

CREATE TABLE categoriausuario (
  idCat_pk int(11) NOT NULL auto_increment,
  nombreCategoria varchar(50) NOT NULL default '',
  descripcion varchar(255) default NULL,
  privilegios int(11) NOT NULL default '0',
  PRIMARY KEY  (idCat_pk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'cita'
-- 

CREATE TABLE cita (
  idCita_pk int(11) NOT NULL auto_increment,
  idPac_fk int(11) NOT NULL default '0',
  estado varchar(50) default NULL,
  fechaCita datetime NOT NULL default '0000-00-00 00:00:00',
  tipoCita varchar(50) default NULL,
  diagnosticoCita varchar(50) NOT NULL default '',
  PRIMARY KEY  (idCita_pk),
  KEY idPac_fk (idPac_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'exlab'
-- 

CREATE TABLE exlab (
  idCita_pk_fk int(11) NOT NULL default '0',
  idTipo_pk_fk int(11) NOT NULL default '0',
  comentario varchar(50) default NULL,
  PRIMARY KEY  (idCita_pk_fk,idTipo_pk_fk),
  KEY idTipo_pk_fk (idTipo_pk_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'foto'
-- 

CREATE TABLE foto (
  idFoto_pk int(11) NOT NULL auto_increment,
  idCita_fk int(11) NOT NULL default '0',
  comentarioArchivo varchar(50) default NULL,
  PRIMARY KEY  (idFoto_pk),
  KEY idCita_fk (idCita_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'paciente'
-- 

CREATE TABLE paciente (
  idPac_pk int(11) NOT NULL auto_increment,
  run varchar(20) default NULL,
  apellidoP varchar(50) NOT NULL default '',
  apellidoM varchar(50) NOT NULL default '',
  nombre varchar(50) NOT NULL default '',
  direccion varchar(255) default NULL,
  telefono varchar(20) NOT NULL default '',
  mail varchar(50) default NULL,
  fechaNac datetime NOT NULL default '0000-00-00 00:00:00',
  fechaPrimeraCita datetime NOT NULL default '0000-00-00 00:00:00',
  sexo char(1) default NULL,
  celular varchar(20) default NULL,
  prevision varchar(50) NOT NULL default '',
  ocupacion varchar(50) default NULL,
  derivadoPor varchar(50) default NULL,
  PRIMARY KEY  (idPac_pk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'pruebaparche'
-- 

CREATE TABLE pruebaparche (
  idParche_pk int(11) NOT NULL auto_increment,
  idCita_fk int(11) NOT NULL default '0',
  descripcion varchar(50) default NULL,
  PRIMARY KEY  (idParche_pk),
  KEY idCita_fk_parche (idCita_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'receta'
-- 

CREATE TABLE receta (
  idReceta_pk int(11) NOT NULL auto_increment,
  medicamento varchar(50) default NULL,
  indicaciones varchar(50) default NULL,
  idCita_fk int(11) NOT NULL default '0',
  PRIMARY KEY  (idReceta_pk),
  KEY idCita_fk_receta (idCita_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'tipoex'
-- 

CREATE TABLE tipoex (
  idTipo_pk int(11) NOT NULL auto_increment,
  nombre varchar(20) default NULL,
  descripcion varchar(20) default NULL,
  estado varchar(20) default NULL,
  PRIMARY KEY  (idTipo_pk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'usuario'
-- 

CREATE TABLE usuario (
  idUsuario_pk varchar(12) NOT NULL default '',
  nombreUsuario varchar(50) default NULL,
  apellidoPaterno varchar(50) NOT NULL default '',
  apellidoMaterno varchar(50) NOT NULL default '',
  clave varchar(128) NOT NULL default '',
  idCat_fk int(11) NOT NULL default '0',
  PRIMARY KEY  (idUsuario_pk),
  KEY idCat_fk (idCat_fk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `alergiapaciente`
-- 
ALTER TABLE `alergiapaciente`
  ADD CONSTRAINT idPac_pk_fk FOREIGN KEY (idPac_pk_fk) REFERENCES paciente (idPac_pk),
  ADD CONSTRAINT idAlergia_pk_fk FOREIGN KEY (idAlergia_pk_fk) REFERENCES alergia (idAlergia_pk);

-- 
-- Filtros para la tabla `cita`
-- 
ALTER TABLE `cita`
  ADD CONSTRAINT idPac_fk FOREIGN KEY (idPac_fk) REFERENCES paciente (idPac_pk);

-- 
-- Filtros para la tabla `exlab`
-- 
ALTER TABLE `exlab`
  ADD CONSTRAINT idTipo_pk_fk FOREIGN KEY (idTipo_pk_fk) REFERENCES tipoex (idTipo_pk),
  ADD CONSTRAINT idCita_pk_fk FOREIGN KEY (idCita_pk_fk) REFERENCES cita (idCita_pk);

-- 
-- Filtros para la tabla `foto`
-- 
ALTER TABLE `foto`
  ADD CONSTRAINT idCita_fk FOREIGN KEY (idCita_fk) REFERENCES cita (idCita_pk);

-- 
-- Filtros para la tabla `pruebaparche`
-- 
ALTER TABLE `pruebaparche`
  ADD CONSTRAINT idCita_fk_parche FOREIGN KEY (idCita_fk) REFERENCES cita (idCita_pk);

-- 
-- Filtros para la tabla `receta`
-- 
ALTER TABLE `receta`
  ADD CONSTRAINT idCita_fk_receta FOREIGN KEY (idCita_fk) REFERENCES cita (idCita_pk);

-- 
-- Filtros para la tabla `usuario`
-- 
ALTER TABLE `usuario`
  ADD CONSTRAINT idCat_fk FOREIGN KEY (idCat_fk) REFERENCES categoriausuario (idCat_pk);
