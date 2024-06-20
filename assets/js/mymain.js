//Funcao para alterar a cor e pegar os filtros selecionados para a dispor os tickets na datatable
function changeFiltro(link, color, filterIndex, tipoTicket) {
    var filtroInput = document.getElementById('filtroInput');
    var filtro = JSON.parse(filtroInput.value);
    var csscolor = hexToCssColor(color);

    filtro[filterIndex] = !filtro[filterIndex];

    link.style.color = filtro[filterIndex] ? csscolor : 'grey';


    filtroInput.value = JSON.stringify(filtro);

    getTickets(filtro, tipoTicket);

}

//Funcao para dispor os tickets na datatable
function getTickets(filtro, tipoTicket) {

    if (!$.fn.DataTable.isDataTable('#datatable')) {
        table = $('#datatable').DataTable({
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],
            order: [[4, 'desc']],

            "language": {
                "url": "./assets/json/pt_pt.json"
               
            }

        });
    }

    table.clear().draw();

    $.ajax({
        url: "./db/dashboardAjax.php",
        type: "POST",
        data: {
            filtro: JSON.stringify(filtro),
            type: "ticketTablesAjax",
            tipoTicket: tipoTicket
        },
        success: function (response) {

            var tickets = JSON.parse(response)

            if (tickets != "Sem dados") {
                // Dar append as novas rows
                tickets.forEach(function (ticket) {
                    var row = [
                        ticket.id_ticket,
                        (tipoTicket == 'Enviados' ? (ticket.nome_user_atribuido !== null ? ticket.nome_user_atribuido : 'Nenhum técnico atribuído') : ticket.nome_reportador),
                        ticket.assunto_local,
                        ticket.data,
                        (ticket.urgencia == '1' ? '<span class="badge bg-danger">Urgente</span>' : '')
                    ];


                    var newRow = table.row.add(row).draw().node();

                    // Mudar a cor consoante o status do ticket
                    $(newRow).addClass('table-' + ticket.color);
                });
            }
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


//Apagar Noticia
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


//Update dos filtros nos cards do dashboard
function updateFiltro(filtro, cardId) {
    $('#textoFiltro' + cardId).text('| ' + filtro);

    $.ajax({
        url: "./db/dashboardAjax.php",
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

//Set status dos tickets
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





