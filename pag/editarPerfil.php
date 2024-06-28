<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <h5 class="card-title mb-4 text-center ">Editar Perfil</h5>
            <!-- Multi Columns Form -->
            <form class="row g-4" method="POST" action="./db/userCode.php">
                <div class="mb-4">
                    <label for="Detalhes" class="form-label fw-bold">Detalhes</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$_SESSION['user']['nome']?>" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?=$_SESSION['user']['email']?>" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-person-badge-fill"></i></span>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?=$_SESSION['user']['username']?>" required maxlength="30">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                          <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="bi bi-phone-fill"></i></span>
                            <input type="tel" class="form-control" name="telemovel" placeholder="Telemóvel" 
                                value="<?php if (!empty($_SESSION['user']['telefone'])) {
                                    echo $_SESSION['user']['telefone'];
                                } ?>"
                                maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);">
                          </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="Passwords" class="form-label fw-bold">Password</label>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" name="passAntiga" placeholder="Password Antiga" required>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" name="passNova" placeholder="Password Nova">
                            </div>
                        </div>
                    </div>
                </div>
                

                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>