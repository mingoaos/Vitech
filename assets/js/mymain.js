function changeFiltro(link, color, filterIndex, tipoTicket) {
    var filtroInput = document.getElementById('filtroInput');
    var filtro = JSON.parse(filtroInput.value);
    var csscolor = hexToCssColor(color);

    filtro[filterIndex] = !filtro[filterIndex];

    link.style.color = filtro[filterIndex] ? csscolor : 'grey';


    filtroInput.value = JSON.stringify(filtro);

    getTickets(filtro, tipoTicket);

}


function getTickets(filtro, tipoTicket) {

    if (!$.fn.DataTable.isDataTable('#datatable')) {
        table = $('#datatable').DataTable({
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],
            order: [[4, 'desc']]
        });
    }

    table.clear().draw();

    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: {
            filtro: JSON.stringify(filtro),
            type: "ticketTablesAjax",
            tipoTicket: tipoTicket
        },
        success: function (response) {
            var tickets = JSON.parse(response);
            console.log(tickets);

            // Clear DataTable


            // Append new rows and cells based on the data received
            tickets.forEach(function (ticket) {
                var row = [
                    ticket.id_ticket,
                    (tipoTicket == 'Enviados' ? (ticket.nome_user_atribuido !== null ? ticket.nome_user_atribuido : 'Nenhum técnico atribuído') : ticket.nome_reportador),
                    ticket.assunto_local,
                    ticket.data,
                    (ticket.urgencia == '1' ? '<span class="badge bg-danger">Urgente</span>' : '')
                ];

                // Add row to DataTable
                var newRow = table.row.add(row).draw().node();

                // Set row color based on ticket color
                $(newRow).addClass('table-' + ticket.color);
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


/* Muda cor Tickets */
function hexToCssColor(hex) {
    switch (hex) {
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


$('#btnCriarNoticia').click(function () {
    $('#NoticiaModal').modal('show');
});


$(document).ready(function () {
    $(document).on('click', '.delete-message', function (e) {
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
                    success: function (response) {
                        Swal.fire({
                            title: 'Apagado',
                            text: 'A notícia foi apagada com sucesso',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire('Erro', 'Erro ao apagar a notícia', 'error');
                    }
                });
            }
        });
    });
});



function updateFiltro(filtro, cardId) {
    $('#textoFiltro' + cardId).text('| ' + filtro);

    $.ajax({
        url: "./db/Ajax.php",
        type: "POST",
        data: { filtro: filtro, cardId: cardId, type: "cardsAjax" },
        success: function (response) {

            $('#card-body-' + cardId + ' h6').text(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}

function setStatus(id_status, status, color, id_ticket) {
    $.ajax({
        url: "./db/ticketsCode.php",
        type: "POST",
        data: {
            id_status: id_status,
            id_ticket: id_ticket,
            type: "setStatus"
        },
        success: function (response) {
            $("#estadoBola").css('color', color);
            $("#estadoText").text(status);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}





