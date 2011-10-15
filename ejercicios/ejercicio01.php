<?php
require("clases/basededatos.php");
$consultar=$_REQUEST['consultar_titulo'];
$bd = new basededatos();
$bd->bda_consultar("SELECT clientes.cli_codigo,clientes.cli_nombre,clientes.cli_apellido1,clientes.cli_apellido2,clientes.cli_email,clientes.cli_direccion01, clientes.cli_telefono, clientes.cli_celular, clientes_estado.ces_nombre FROM clientes, clientes_estado where clientes.ces_codigo = clientes_estado.ces_codigo AND clientes.cli_nombre LIKE ('%$consultar%') OR clientes.ces_codigo = clientes_estado.ces_codigo AND clientes.cli_apellido1 LIKE ('%$consultar%') OR clientes.ces_codigo = clientes_estado.ces_codigo AND clientes.cli_apellido2 LIKE ('%$consultar%') or clientes.ces_codigo = clientes_estado.ces_codigo AND clientes.cli_email LIKE ('%$consultar%')");
if($bd->bda_numregistros>=1){
	echo"<center><br><br><br>
      <table border=1><tr>
      <td>Codigo</td>
      <td>Nombre</td>
      <td>Primer Apellido</td>
      <td>Segundo Apellido</td>
      <td>Email</td>
      <td>Direccion</td>
      <td>Telefono Fijo</td>
      <td>Telefono Celular</td>
      <td>Estado</td></tr>";
//$i=0;

while($rs=$bd->bda_extraer())
{
//$i++;


     echo "<tr>
          <td>$rs[0]</td>
          <td>$rs[1]</td>
            <td>$rs[2]</td>
            <td>$rs[3]</td>
            <td>$rs[4]</td>
            <td>$rs[5]</td>
            <td>$rs[6]</td>
            <td>$rs[7]</td>
            <td>$rs[8]</td>
    </tr>";
}
echo "</table>";
}
else
echo "no se encontraron registros";
?>
?>