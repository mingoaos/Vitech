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
          new simpleDatatables.DataTable('#datatable');
  });
  
  
  $(document).ready(function(){
    $('#datatable tbody').on('click', 'tr[data-href]', function(){
      window.location = $(this).attr('data-href');
    });
  });