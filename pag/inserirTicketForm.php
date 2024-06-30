<?php 
unset($_SESSION['current_page']);
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
?>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <h5 class="card-title mb-4 text-center">Criar Ticket</h5>
            <form method="POST" action="./db/ticketsCode.php" class="row g-4">
        
                <!-- Assunto/Local -->
                <div class="col-md-6">
                    <label for="assunto_local" class="form-label fw-bold">Assunto/Local</label>
                    <input type="text" class="form-control" id="assunto_local" name="assunto_local" maxlength="50" required>
                </div> 

                <!-- Tipo de Ticket -->
                <div class="col-md-6">
                    <label for="tipo_ticket" class="form-label fw-bold">Tipo de Ticket</label>
                    <select class="form-select" id="tipo_ticket" name="tipo_ticket" required>
                        <option value="I">Informação</option>
                        <option value="A">Avaria</option>
                        
                    </select>
                </div>

                <!-- Mensagem/Sintomas -->
                <div class="col-12">
                    <label for="mensagem_sintomas" class="form-label fw-bold ">Mensagem/Sintomas</label>
                    <textarea class="form-control" id="mensagem_sintomas" name="mensagem_sintomas" rows="4" required></textarea>
                </div>

                <!-- Departamento de Destino -->
                <?php 
                
                $query = "SELECT id_departamento, nome FROM departamento";
                $result = mysqli_query($con,$query);

                // Verifica se encontrou resultados
                if (mysqli_num_rows($result) > 0) {
                    
                    echo '<div class="col-md-6">';
                    echo '<label for="id_departamento_destino" class="form-label fw-bold">Departamento de Destino</label>';
                    echo '<select class="form-select" id="id_departamento_destino" name="id_departamento_destino" required>';
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row["id_departamento"] . '">' . $row["nome"] . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                } else {
                   
                    echo '<div class="col-md-6">';
                    echo '<label for="id_departamento_destino" class="form-label fw-bold">Departamento de Destino</label>';
                    echo '<select class="form-select" id="id_departamento_destino" name="id_departamento_destino" required disabled>';
                    echo '<option value="">Nenhum departamento encontrado</option>';
                    echo '</select>';
                    echo '</div>';
                }
                

                
                ?>

                <!-- Urgência -->
                <div class="col-md-6">
                    <label for="urgencia" class="form-label fw-bold">Urgência</label>
                    <select class="form-select" id="urgencia" name="urgencia" required>
                        <option value="0">Baixa</option>
                        <option value="1">Alta</option>
                    </select>
                </div>

            

                <!-- Botão de Envio -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
