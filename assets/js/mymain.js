function changeColor(link, color) {
    
    var csscolor = hexToCssColor(color);
  
      if (link.style.color === csscolor) {
          link.style.color = 'grey';
      } else {
          link.style.color = csscolor;
      }
}
  
  
    /* Muda cor Tickets */
function hexToCssColor(hex) {
    switch(hex) {
        case '#FFD700':
            return 'gold';
        case '#32CD32':
            return 'limegreen';
        case '#ff0000':
            return 'red';
        default:
            return 'grey'; 
    }
}


$('#btnCriarNoticia').click(function() {
    $('#NoticiaModal').modal('show');
});


$(document).ready(function() {
    $('.delete-message').on('click', function(e) {
        e.preventDefault();

        const noticiaId = $(this).data('noticia-id');

        Swal.fire({
        title: 'Apagar',
        text: 'Tem a certeza que deseja apagar esta notícia',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: 'Sim, apague',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
            url: './db/Ajax.php',
            method: 'POST',
            data: { noticiaId: noticiaId, type: "deleteNoticia" },
            success: function(response) {

                Swal.fire({
                    title: 'Apagado',
                    text: 'A notícia foi apagada com sucesso',
                    icon: 'success'
                }).then(() => {
                    location.reload(); // Refresh the page
                });     
            },
            error: function(xhr, status, error) {
               
                Swal.fire('Erro', 'Erro ao apagar a notícia', 'error');
            }
            });
        }
        });
    });
});



function updateFiltro(filtro,cardId){
    $('#textoFiltro' + cardId).text('| ' + filtro); 

    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: { filtro: filtro, cardId: cardId, type: "cardsAjax"},
        success: function(response) {
            $('#card-body-' + cardId + ' h6').text(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    
}





  