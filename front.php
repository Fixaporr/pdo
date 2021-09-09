<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("cadastro_usuario","localhost:3307","root","usbw");
?>

<!DOCTYPE html>

<html lang="pt-br">
 <head>  
    <meta charset="utf-8">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
 </head> 
 <body>
     <?PHP
     if(isset($_POST['nome']))//CLICOU NO BOTAO CADASTRAR OU EDITAR
     {
         if(isset($_GET['id_up'])&& !empty($_GET['id-up']))
         {
            $id_upd=addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //EDITAR 
                $p->atualizarDados($id_upd,$nome,$telefone,$email);
                header("location:front.php");
           }else//CADASTRAR 
            {
                ?>
                <div>
                    <img src="aviso.jpg">
                <h4>Preencha todos os campos"</h4>
            </div>
            <?php
              
            }
         }
         else{

        
         $nome = addslashes($_POST['nome']);
         $telefone = addslashes($_POST['telefone']);
         $email = addslashes($_POST['email']);
         if(!empty($nome) && !empty($telefone) && !empty($email))
         {
             //cadastrar 
             if(!$p->cadastrarPessoa($nome,$telefone,$email))
             {

                ?>
                <div>
                    <img src="aviso.jpg">
                <h4>Email ja esta cadastrado!</h4>
            </div>
            <?php
                
             }
        }else//CADASTRAR 
         {
             ?>
            <div>
                <img src="aviso.jpg">
            <h4>Preencha todos os campos!</h4>
        </div>
        <?php
            
         }
        }

     }
     
        if(isset($_GET['id_up']))//SE A PESSOA CLICOU EM EDITAR
        {
            $id_upd = addslashes($_GET['id_up']);
            $res=$p->buscarDadosPessoa($id_upd);
        }

    ?>

     <section id="esquerda">
         <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">NOME:</label>
            <input type="text"name="nome" id="nome"
            value="<?php if(isset($res)){echo $res['nome'];}?>">

            <label for="nome">TELEFONE:</label>
            <input type="text"name="telefone" id="telefone"
            value="<?php if(isset($res)){echo $res['telefone'];}?>">

            <label for="nome">EMAIL:</label>
            <input type="email"name="email" id="email"
            value="<?php if(isset($res)){echo $res['email'];}?>">

            <input type="submit" 
            value="<?php if(isset($res)){echo "Atualizar";}
            else{echo "Cadastrar";}?>">
         </form>
     </section>
    
     <section id="direita">
     <table>
             <tr id="titulo">
                <td>Nome:</td>
                <td>Telefone:</td>
                <td colspan="2">Email:</td>
             </tr>

     <?php
        $dados = $p->buscarDados();
        if(count($dados) > 0)//TEM PESSOAS NO BANCO DE DADOS 
        { 
            
            for($i=0; $i< count($dados);$i++){
                    echo"<tr>";
                foreach($dados[$i] as $k => $v){
                    if($k !="id"){
                       
                            echo "<td>".$v."</td>";
                        
                    }
                                  
                }
                   
                ?>
                <td>
                    <a href="front.php?id_up=<?php echo $dados[$i]['id']?>">Editar</a>
                    <a href="front.php?id=<?php echo $dados[$i]['id']?>">Excluir</a>
                </td>
            <?php
            echo"</tr>" ; 
            }
           
        }
        else// O BANCO DE DADOS ESTA VAZIO
        {
        
            ?>
         </table>
      
         <div class="aviso">
             <h4>Ainda não há pessoas cadastrada!</h4>
         </div>
         <?php
     }
     
  ?>
     </section>


 </body>
</html>
<?php
    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location:front.php");
    }
?>