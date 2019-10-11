function newAlert(){
    $('input').val('');
    $('.dataTables_wrapper').fadeOut(20);
    $('.form').fadeIn(200);
    $('.boton-cancelar').show();
    $('.boton-cancelar a').show();
};

function cancelAlert(){
    $('input').val('');
    $('.dataTables_wrapper').fadeIn(200);
    $('.form').fadeOut(20);
    $('.boton-cancelar').hide();
    $('.boton-cancelar a').hide();
};

function closeAlert(){
    swal({
        title: "No te vayas :(",
        text: "¿Deseas cerrar sesión?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willClose) => {
        if (willClose) {
            window.location.href = "/includes/close_session.php";
        } else {
            
        }
    });
};

function errorAlert(){
    swal({
        title: 'Oops...',
        text: '¡Algo salió mal!',
        icon: "error",
      })
};