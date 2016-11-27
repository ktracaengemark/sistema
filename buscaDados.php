 <?php  

 $mysqli = new mysqli('localhost', 'root', '', 'app');
$text = $mysqli->real_escape_string($_GET['term']);
 
$query = "SELECT NomeProfissional FROM app_profissional WHERE NomeProfissional LIKE '%$text%' ORDER BY name ASC";
$result = $mysqli->query($query);
$json = '[';
$first = true;
while($row = $result->fetch_assoc())
{
    if (!$first) { $json .=  ','; } else { $first = false; }
    $json .= '{"value":"'.$row['name'].'"}';
}
$json .= ']';
echo $json;

?>