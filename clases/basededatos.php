<?php
class basededatos
{
   // Atributos de la clase
   var $bda_nombre;
   var $bda_hostserver;
   var $bda_usuario;
   var $bda_contrasena;
   var $bda_conexion;
   var $bda_resultado;
   var $bda_numregistros;

   // Métodos de la clase

   /**********************************
    Método: basededatos
    Desarrollado por: Jk0
    Creado: 04-Mar-2011 11:31 AM
    Versión: 01
    Descripción: Es el método constructor, inicializa los atributos de la clase.
    Parámetros:

   **********************************/
   function basededatos ()
   {
      $this->bda_hostserver = "";
      $this->bda_nombre = "";
      $this->bda_usuario = "";
      $this->bda_contrasena = "";
   }

   /**********************************
    Método: bda_conectar
    Desarrollado por: Jk0
    Creado: 04-Mar-2011 11:06 AM
    Versión: 01
    Descripción: Se conecta a una base de datos de MySQL
    Parámetros:

   **********************************/
   function bda_conectar ()
   {
      $respuesta = true;
      $this->bda_conexion =  mysql_connect($this->bda_hostserver,
                                           $this->bda_usuario,
                                           $this->bda_contrasena);
      if (!$this->bda_conexion)
        {  $respuesta = false;
           die('No pudo conectarse a la base de datos porque: ' . mysql_error());
        }
      else
        {
           $db_selected = mysql_select_db($this->bda_nombre, $this->bda_conexion);
           if (!$db_selected)
           {
              die ('No se puede establecer conexión con: '.$this->bda_nombre.
                    ', debido a: '. mysql_error());
           }
        }
       return ($respuesta);
   }

   /**********************************
    Método: bda_desconectar
    Desarrollado por: Jk0
    Creado: 04-Mar-2011 11:26 AM
    Versión: 01
    Descripción: Termina una conexión previamente creada con una base de datos de MySQL
    Parámetros:

   **********************************/
   function bda_desconectar ()
   {
      mysql_close($this->bda_conexion);
   }


   /**********************************
    Método: bda_insertar
    Desarrollado por:Jk0
    Creado: 04-Mar-2011 11:36 AM
    Versión: 01
    Descripción: Inserta un registro en una tabla de una base de datos con la cual
                 se realizó previamente una conexión.
    Parámetros:
       + $tabla: Nombre de la tabla donde se va a insertar un registro.
       + $campos: Nombres de los campos de la tabla.
       + $valores: Valores a registrar
    **********************************/
   function bda_insertar ($tabla, $campos, $valores)
   {
      $respuesta = true;
      $sql = "INSERT INTO ".$tabla." (".$campos.") VALUES (".$valores.")";
      $this->bda_conectar();
      $this->bda_resultado = mysql_query($sql);
      if (!$this->bda_resultado)
        {
          $respuesta = false;
          die('Error al insertar un registro: ' . mysql_error());
        }
      $this->bda_desconectar ();
      return ($respuesta);
   }

   /**********************************
    Método: bda_consultar
    Desarrollado por:Jk0
    Creado: 09-Mar-2011 11:20 AM
    Versión: 01
    Descripción: Ejecuta una consulta en la base de datos.
    Parámetros:
       + $sql: Contiene la sentencia SQL a ejecutar
    **********************************/
   function bda_consultar ($sql)
   {
      $respuesta = true;
      $this->bda_conectar();
      $this->bda_resultado = mysql_query($sql);
      if (!$this->bda_resultado)
        {
          $respuesta = false;
          die('Error al consultar un registro: ' . mysql_error().$sql);
        }
      $this->bda_numregistros = @mysql_num_rows($this->bda_resultado);
      $this->bda_desconectar ();
      return ($respuesta);
   }

   /**********************************
    Método: bda_actualizar
    Desarrollado por:Jk0
    Creado: 09-Mar-2011 11:24 AM
    Versión: 01
    Descripción: Realiza una modificación en la base de datos
    Parámetros:
       + $tabla: Nombre de la tabla donde se va a modificar un registro.
       + $camposyvalores: Nombres de los campos de la tabla.
       + $condicion: Condicion de actualización
    **********************************/
   function bda_actualizar ($tabla, $camposyvalores, $condicion)
   {
      $respuesta = true;
      if ($condicion =="")
      {
         $sql = "UPDATE ".$tabla." SET ".$camposyvalores;
      }
      else
      {
         $sql = "UPDATE ".$tabla." SET ".$camposyvalores." WHERE ".$condicion;
      }
      $this->bda_conectar();
      $this->bda_resultado = mysql_query($sql);
      if (!$this->bda_resultado)
        {
          $respuesta = false;
          die('Error al actualizar un registro: ' . mysql_error());
        }
      $this->bda_desconectar ();
      return ($respuesta);
   }

   /**********************************
    Método: bda_eliminar
    Desarrollado por:Jk0
    Creado: 09-Mar-2011 11:35 AM
    Versión: 01
    Descripción: Elimina registros de una tabla de la base de datos
    Parámetros:
       + $tabla: Nombre de la tabla donde se va a eliminar un registro.
       + $condicion: Condicion de eliminación
    **********************************/
   function bda_eliminar ($tabla, $condicion)
   {
      $respuesta = true;
      if ($condicion =="")
      {
         $sql = "DELETE FROM ".$tabla;
      }
      else
      {
         $sql = "DELETE FROM ".$tabla." WHERE ".$condicion;
      }
      $this->bda_conectar();
      $this->bda_resultado = mysql_query($sql);
      if (!$this->bda_resultado)
        {
          $respuesta = false;
          die('Error al insertar un registro: ' . mysql_error());
        }
      $this->bda_desconectar ();
      return ($respuesta);
   }

   /**********************************
   Método: bda_extraer
   Desarrollado por:Jk0
   Creado: 11-Mar-2011 10:35 AM
   Versión: 01
   Descripción: Extraer los datos de una base de datos
   Parámetros:
   **********************************/
   function bda_extraer()
   {
    return(@mysql_fetch_array($this->bda_resultado));
   }

}
?>

