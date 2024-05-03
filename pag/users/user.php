<div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0" style="font-weight:800; color: #012970;" >Utilizadores</h6>
                        <button type="button" class="btn btn-success" id="btnAddUser">
                            Add <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Departmento</th>
                                <th>Tipo de Utilizador</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            require "db/dbcon.php";
                            
                            $query = "SELECT u.id_user, u.nome, 
                                            GROUP_CONCAT(d.nome SEPARATOR ', ') AS departamentos,
                                            GROUP_CONCAT(t.nome SEPARATOR ', ') AS tipos
                                    FROM user u
                                    INNER JOIN user_departamento_tipo udt ON u.id_user = udt.id_user
                                    INNER JOIN departamento d ON udt.id_departamento = d.id_departamento
                                    INNER JOIN tipo_user t ON udt.id_tipo = t.id_tipo_user
                                    GROUP BY u.id_user, u.nome;
                     ";

                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $user)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $user['id_user'] ?></td>
                                        <td><?= $user['nome'] ?></td>
                                        <td><?= $user['departamentos'] ?></td>
                                        <td><?= $user['tipos'] ?></td>
                                        <td>
                                            
                                            <button type="button" value="<?=$user['id_user'];?>" class="editUserBtn btn btn-outline-warning btn-sm"> <i class="bi bi-pencil-square"></i> </button>
                                            <button type="button" value="<?=$user['id_user'];?>" class="deleteUserBtn btn btn-outline-danger btn-sm"> <i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>