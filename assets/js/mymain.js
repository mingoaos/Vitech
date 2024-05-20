function changeFiltro(link, color, filterIndex, tipoTicket) {
    var filtroInput = document.getElementById('filtroInput');
    var filtro = JSON.parse(filtroInput.value);
    var csscolor = hexToCssColor(color);

    

 
    filtro[filterIndex] = !filtro[filterIndex];


    link.style.color = filtro[filterIndex] ? csscolor : 'grey';


    filtroInput.value = JSON.stringify(filtro); 

    getTickets(filtro,tipoTicket);
    
}


function getTickets(filtro,tipoTicket)
{
    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: { filtro: JSON.stringify(filtro), type: "ticketTablesAjax", tipoTicket: tipoTicket},
        success: function(response) {
            var tableId = document.getElementById('datatable');
            var tBody = tableId.getElementsByTagName('tbody')[0];
    
            // Clear the tbody
            tBody.innerHTML = '';
    
            // Parse the JSON response
            var tickets = JSON.parse(response);
    
            console.log(tickets);
    
            // Append new rows and cells based on the data received
            tickets.forEach(function(ticket) {
                var row = '<tr class="table-'+ticket.color+'">';
                row += '<td>' + ticket.id_ticket + '</td>';
                row += '<td>' + (tipoTicket == 'Enviados' ? (ticket.nome_user_atribuido !== null ? ticket.nome_user_atribuido : 'Nenhum técnico atribuído') : ticket.nome_reportador) + '</td>';
                row += '<td>' + ticket.assunto_local + '</td>';
                row += '<td>' + ticket.data + '</td>';
                row += '<td>' + (ticket.urgencia ? '<span class="badge bg-danger">Urgente</span>' : '') + '</td>';
                row += '</tr>';
    
                console.log(row);
    
                // Append the prepared row to the tbody
                tBody.insertAdjacentHTML('beforeend', row);
            });
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
    $(document).on('click', '.delete-message', function(e) {
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
                    url: './db/noticiasCode.php',
                    method: 'POST',
                    data: { noticiaId: noticiaId, type: "deleteNoticia" },
                    success: function(response) {
                        Swal.fire({
                            title: 'Apagado',
                            text: 'A notícia foi apagada com sucesso',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
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





  