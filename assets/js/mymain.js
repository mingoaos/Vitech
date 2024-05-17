// function changeFiltro(link, color, filterIndex, tipoTicket) {
//     var filtroInput = document.getElementById('filtroInput');
//     var filtro = JSON.parse(filtroInput.value);
//     var csscolor = hexToCssColor(color);

    

 
//     filtro[filterIndex] = !filtro[filterIndex];


//     link.style.color = filtro[filterIndex] ? csscolor : 'grey';


//     filtroInput.value = JSON.stringify(filtro); 

//     $.ajax({
//         url: "./db/Ajax.php",
//         type: "POST",
//         data: { filtro: JSON.stringify(filtro), type: "ticketTablesAjax", tipoTicket: tipoTicket},
//         success: function(response) {
            
           
//             $('#ticketTableBody').empty(); 
            
//             var tickets = JSON.parse(response);

//             console.log(tickets);

           
//             tickets.forEach(function(ticket) {
//                 var row = '<tr class="table-warning">';
//                 row += '<td>' + ticket.id_ticket + '</td>';
//                 row += '<td>' + (tipoTicket == 'Enviados' ? (ticket.nome_user_atribuido !== null ? ticket.nome_user_atribuido : 'Nenhum técnico atribuído') : ticket.nome_reportador) + '</td>';
//                 row += '<td>' + ticket.assunto_local + '</td>';
//                 row += '<td>' + ticket.data + '</td>';
//                 row += '<td>' + (ticket.urgencia ? '<span class="badge bg-danger">Urgente</span>' : '') + '</td>';
//                 row += '</tr>';
            
//                 console.log(row);
      
//                 $('#ticketTableBody').append(row);
//             });

//             let dataTable = new DataTable("#datatable",{
//                 perPageSelect: [5, 10, 15, ["All", -1]],
//                 columns: [{
//                     select: 2,
//                     sortSequence: ["desc", "asc"]
//                   },
//                   {
//                     select: 3,
//                     sortSequence: ["desc"]
//                   },
//                   {
//                     select: 4,
//                     cellClass: "green",
//                     headerClass: "red"
//                   }]
                  
//             });
//             dataTable.insert(tickets);

           

           
//         },
//         error: function(xhr, status, error) {
//             console.error(xhr.responseText);
//         }
//     });


// }

  
  
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
        console.log("assa");
        const noticiaId = $(this).data('noticia-id');
        console.log(noticiaId);
        
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





  