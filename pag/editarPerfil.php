<div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar Perfil</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="./db/userCode.php">

                <label for="Detalhes" class="form-label fw-bold">Detalhes</label>

                <div class="col-md-6">
                  <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?=$_SESSION['user']['nome']?>" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Email" value="<?=$_SESSION['user']['email']?>" required>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="username" placeholder="Username" value="<?=$_SESSION['user']['username']?>" required>
                </div>
                <div class="col-md-6">
                  <input type="telemovel" class="form-control" name="telemovel" placeholder="Telemóvel" value="<?=$_SESSION['user']['telefone']?>">
                </div>

                <label for="Passwords" class="form-label fw-bold">Password</label>

                <div class="col-12">
                  <input type="password" class="form-control" name="passAntiga" placeholder="Password antiga" required>
                </div>
                <div class="col-12">
                  <input type="password" class="form-control" name="passNova" placeholder="Password Nova" required>
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>