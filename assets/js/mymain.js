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
  


    // Open the popup form when the button is clicked
    $('#btnCriarNoticia').click(function() {
        $('#NoticiaModal').modal('show');
    });






function updateFiltro(filtro,cardId){
    $('#textoFiltro' + cardId).text('| ' + filtro); 

    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: { filtro: filtro, cardId: cardId },
        success: function(response) {
            $('#card-body-' + cardId + ' h6').text(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    
}





  