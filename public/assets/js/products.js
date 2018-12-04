$(document).ready(function () {
    let tableProducts = $('#table_products');
    let btnReloadProducts = $('#btn-reload-products');
    tableProducts.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: btnReloadProducts.data('href'),
            error: function (xhr, error, thrown) {
                if (xhr.status === 500) {
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message, 'Thông báo');
                    tableProducts.DataTable().ajax.reload();
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'title', name: 'title'},
            {data: 'state', name: 'state'},
            {data: 'brand', name: 'brand'},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'thumbnail', name: 'thumbnail'},
            {data: 'actions', name: 'actions', class: 'text-xs-center', orderable: false, searchable: false}
        ],
        oLanguage: {
            sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
            sZeroRecords: 'Không tìm thấy dữ liệu',
            sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
            sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
            sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
            sSearch: 'Tìm kiếm:'
        }
    });
    btnReloadBrands.click((event) => {
        event.preventDefault();
        Loading.show();
        tableBrands.DataTable().ajax.reload();
        Loading.close();
    });
});
