<!DOCTYPE html>
<html>
<head>
  <title>Página de Produtos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- adicionando jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <!-- adicionando Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

  <!-- adicionando Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script>
    function editarItem(id) {
      // Redirecionar para a página de edição com o ID como parâmetro
      window.location.href = "editar.php?id=" + id;
    }
  </script>

</head>
<body>
  

<!--MODAL-->
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalhes do Produto</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>ID: <span id="productId"></span></p>
        <p>Nome: <span id="productName"></span></p>
        <p>Valor: <span id="productValue"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!--CONTAINER COM A TABELA-->
<div class="container">
  <h2>Lista de Produtos</h2>
  <div class="table-responsive">
    <!-- Botão para adicionar um novo produto -->
    <a href="inclusao.php" class="btn btn-primary">
      <i class="fa fa-plus"></i> Incluir
    </a>

    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col" style="width:10%">ID</th>
        <th scope="col" style="width:50%">Nome</th>
        <th scope="col" style="width:20%">Valor</th>
        <th scope="col" style="width:5%">Visualizar</th>
        <th scope="col" style="width:5%">Editar</th>
        <th scope="col" style="width:5%">Excluir</th>
      </tr>
    </thead>
      <tbody>
        <?php
        include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

        $sql = "SELECT * FROM produto"; // Consulta SQL para obter todos os produtos

        $result = $conn->query($sql); // Executa a consulta
        if ($conn->error) {
          die("Erro na consulta: " . $conn->error); // Se houver um erro na consulta, interrompe a execução do script
        }
        ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome']; ?></td>
            <td>R$ <?php echo number_format($row['valor'], 2, '.', ','); ?></td>
            <td style="cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"></i></td>
            <td><a href="editar.php?id=<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a></td>
            <td><a href="#" 
                   class="delete-btn" 
                   data-id="<?php echo $row['id']; ?>">
                  <i class="fa fa-trash"></i>
                </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
$(document).ready(function(){
 
  $(".delete-btn").click(function(e){
    e.preventDefault();
  
    var productId = $(this).data('id'); 
    
   
    var userConfirmation = confirm('Tem certeza de que deseja excluir este produto?'); 
    if(userConfirmation){
      window.location.href = "excluir.php?id=" + productId; 
    }
  });

  $(".fa-eye").click(function(){
    var $row = $(this).closest("tr");
    var productId = $row.find("td:nth-child(1)").text(); 
    var productName = $row.find("td:nth-child(2)").text(); 
    var productValue = $row.find("td:nth-child(3)").text(); 

    $("#productId").text(productId); 
    $("#productName").text(productName); 
    $("#productValue").text(productValue); 

    $("#modal-info").modal(); 
  });
});
</script>
</body>
</html>
