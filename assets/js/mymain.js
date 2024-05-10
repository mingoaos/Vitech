function changeFiltro(link, color, filterIndex, tipoTicket) {
    var filtroInput = document.getElementById('filtroInput');
    var filtro = JSON.parse(filtroInput.value); // Parse the JSON string into an object
    var csscolor = hexToCssColor(color);

    

    // Toggle the value of the filter
    filtro[filterIndex] = !filtro[filterIndex];

    // Update the link color based on the filter state
    link.style.color = filtro[filterIndex] ? csscolor : 'grey';

    // Update the value of the filters in the hidden input field
    filtroInput.value = JSON.stringify(filtro); // Convert the object back to a JSON string

    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: { filtro: JSON.stringify(filtro), type: "ticketTablesAjax", tipoTicket: tipoTicket},
        success: function(response) {
            
           
            $('#ticketTableBody').empty(); // Clear the table body before adding new rows
            
            var tickets = JSON.parse(response);

            console.log(tickets);

            // Iterate over the array of ticket objects and generate table rows dynamically
            tickets.forEach(function(ticket) {
                var row = '<tr class="table-warning">';
                row += '<td>' + ticket.id_ticket + '</td>';
                row += '<td>' + (tipoTicket == 'Enviados' ? (ticket.nome_user_atribuido !== null ? ticket.nome_user_atribuido : 'Nenhum técnico atribuído') : ticket.nome_reportador) + '</td>';
                row += '<td>' + ticket.assunto_local + '</td>';
                row += '<td>' + ticket.data + '</td>';
                row += '<td>' + (ticket.urgencia ? '<span class="badge bg-danger">Urgente</span>' : '') + '</td>';
                row += '</tr>';
            
                console.log(row);
                // Append the row to the table body
                   // Append the row to the table body
                $('#ticketTableBody').append(row);
            });

            // Create a new table with updated data
            var dataTable = new simpleDatatables.DataTable("#datatable");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });


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





  