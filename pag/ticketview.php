<?php
$id = $_GET['id'];

require_once "db/libphp.php";

$row = getTicket($id);






?>

<div style="margin-left: 32px">
    <div style="display:flex;align-items:center">
        <a href="./?op=2"> <i  class="bi bi-arrow-left-square-fill arrow"></i> </a>
        <h1 style="margin-top: 10px">Nao gosto de ti</h1>
        <h2 class="id_ticket">#<?= $id ?></h2>
    </div>
    <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fs20 bcc_pendente" type="button" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="bi bi-person-circle"></i><div class="mx-2">Accordion Item #1</div>
                    </button>
                  </h2>
                  <div class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                      <strong>This is the first item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                
    </div>

</div>