<?php
include "../entites/client.php";
include "../Core/Clients.php";



  $pseudo =$_POST['email'];

  $pass = $_POST['pass'];





if(!empty($_POST['email']) && !empty($_POST['pass']))
{

  try{
 $db = config::getConnexion();
  $db->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }
$req = $db->prepare('SELECT ID_CLIENT  FROM client WHERE (USERNAME=:pseudo  || EMAIL=:pseudo )');
  $req->execute(array(':pseudo'=>$pseudo));
  if($req->rowCount()>0)
  {
      $req = $db->prepare('SELECT ID_CLIENT FROM client WHERE ((USERNAME=:pseudo && PASSWORD=:pass)) || (EMAIL=:pseudo && PASSWORD=:pass)');
  $req->execute(array(':pseudo'=>$pseudo ,':pass'=>$pass));
  if($req->rowCount()>0)
  {
  $req = $db->prepare('SELECT ID_CLIENT  FROM client WHERE ((USERNAME=:pseudo  || EMAIL=:pseudo ) && (EmailConfirmed=1))');
  $req->execute(array(':pseudo'=>$pseudo));
 if($req->rowCount()>0)
{
   $req = $db->prepare('SELECT ID_CLIENT  FROM client WHERE ((USERNAME=:pseudo  || EMAIL=:pseudo ) && (status="active"))');
  $req->execute(array(':pseudo'=>$pseudo));

if($req->rowCount()>0){
  	echo '<script language="javascript"> alert("welcome to Our site '.$pseudo.'"); ;</script>';
      session_start();
    $_SESSION['l']= $pseudo;
    $_SESSION['p']=$pass;
                   $client=new Clients();
$info=$client->afficherClient($_SESSION['l'],$_SESSION['p']);

foreach($info as $row){
   $_SESSION['ID']=$row['ID_CLIENT'];
}
  	 ?>

    <script type=""> location.replace("../views/page profil.php");</script>
    <?php
    $status = 'success';
    $message = 'welcome';
}
else {echo '<script language="javascript"> alert("'.$pseudo.' account blocked"); ;</script>';
  ?>
    <script type=""> location.replace("../views/index.html");</script>
    <?php
}

  }

else {echo '<script language="javascript"> alert("'.$pseudo.' Email not Confirmed"); ;</script>';
  ?>
    <script type=""> location.replace("../views/index.html");</script>
    <?php
}
}
  else {  $status = 'error';
  echo '<script language="javascript"> alert("wrong PASSWORD for '.$pseudo.' account "); ;</script>';
    $message = 'verifier votre mdp';
    ?>
    <script type=""> location.replace("../views/login.php");</script>
    <?php
} 
 }
 else { $status = 'error';
  echo '<script language="javascript"> alert("'.$pseudo.' Is not a membre "); ;</script>';
    $message = 'compte introuvable';
    ?>
    <script type=""> location.replace("../views/login.php");</script>
    <?php
     }
}

else
{
  $status = 'error';
  $message = 'veuillez saisir votre username and mdp';
}




//echo json_encode($data);



?>