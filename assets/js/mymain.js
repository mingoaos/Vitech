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
  
  /* Chama datatable */
  document.addEventListener('DOMContentLoaded', function () {
    // Check if the page URL contains a specific string
    if (window.location.href.includes('tickets-enviados')) {
        var dataTable = new simpleDatatables.DataTable('#datatable');

        document.querySelector('#datatable tbody').addEventListener('click', function (event) {
            tr = event.target.closest('tr');
            var firstTd = tr.querySelector('td:first-child');
            TdText = firstTd.textContent.trim();
            if(TdText){
              var href = './?op=2&id=' + TdText;
                console.log(href);
                if (href) {
                    window.location = href;
                }
            }
        });
    }

    
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





  