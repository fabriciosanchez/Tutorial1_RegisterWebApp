<html>
<head>
<Title>Formulário de Registro</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Registre-se aqui!</h1>
<p>Preencha seu nome e e-mail e após isso, clique em <strong>Enviar</strong> para registrar-se.</p>
<form method="post" action="index.php" enctype="multipart/form-data" >
      Nome  <input type="text" name="nome" id="nome"/></br>
      E-mail <input type="text" name="email" id="email"/></br>
      <br />
      <input type="submit" name="submit" value="Enviar" />
</form>

<?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the Azure Portal.
    $host = "localhost";
    $user = "fabricio";
    $pwd = "48Bxm7E4NLzjKCDa";
    $db = "RegistrationDB";
    
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    
    // Insert registration info
    if(!empty($_POST)) {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $data = date("Y-m-d");
        // Insert data
        $sql_insert = "INSERT INTO Registration (nome, email, data)
                   VALUES (?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $data);
        $stmt->execute();
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    echo "<h3>Você foi registrado com sucesso!</h3>";
    }
    
    // Retrieve data
    $sql_select = "SELECT * FROM Registration";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();
    if(count($registrants) > 0) {
        echo "<h2>Pessoas já registradas:</h2>";
        echo "<table>";
        echo "<tr><th>Nome</th>";
        echo "<th>E-mail</th>";
        echo "<th>Data do registro</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['Nome']."</td>";
            echo "<td>".$registrant['Email']."</td>";
            echo "<td>".$registrant['Data']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>Ops! Ninguém registrado por enquanto :-( </h3>";
    }
?>

</body>
</html>