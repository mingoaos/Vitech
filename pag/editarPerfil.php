<div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar Perfil</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3">
                <div class="col-md-12">
                    <label for="Detalhes" class="form-label fw-bold">Detalhes</label>
                  <input type="text" class="form-control" id="nome" placeholder="Nome" value="<?=$_SESSION['user']['nome']?>">
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" id="email" placeholder="Email" value="<?=$_SESSION['user']['email']?>">
                </div>
                <div class="col-md-6">
                  <input type="telemovel" class="form-control" id="telemovel" placeholder="Telemóvel" value="<?=$_SESSION['user']['telefone']?>">
                </div>
                <div class="col-12">
                    <label for="Passwords" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="passAntiga" placeholder="Password antiga">
                </div>
                <div class="col-12">
                  <input type="password" class="form-control" id="passNova" placeholder="Password Nova">
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>