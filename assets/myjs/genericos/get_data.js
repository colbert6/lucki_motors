
function get_correlativo(){
    idserie= $('#idserie').val();
    $.ajax({
        url: base_url + "get_datas/get_correlativo",
        type: 'GET',
        data: {idserie:idserie},
        dataType: 'JSON',
        async: true,
        success: function (data) {
            $('#correlativo').val(data.correlativo);
        }
    });
}
