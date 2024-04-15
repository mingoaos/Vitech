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
    var dataTable = new simpleDatatables.DataTable('#datatable');
   

    document.querySelector('#datatable tbody').addEventListener('click', function (event) {
      tr = event.target.closest('tr');
      var firstTd = tr.querySelector('td:first-child');
      TdText = firstTd.textContent.trim();
      if(TdText){
        var href = './?id=' + TdText;
          console.log(href);
          if (href) {
              window.location = href;
          }
      }
      
      // If a row with data-href attribute is found
      if (row) {
          var href = row.getAttribute('data-href');
          console.log(href);
          if (href) {
              window.location = href;
          }
      }
  });
});




  