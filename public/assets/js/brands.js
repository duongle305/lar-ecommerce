$(document).ready(function () {
    let tableBrands =$('#table_brands');
    let btnReloadBrands = $('#btn-reload-brands');
    tableBrands.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:btnReloadBrands.data('href'),
            error: function (xhr, error, thrown) {
                if(xhr.status === 500){
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message,'Thông báo');
                    tableBrands.DataTable().ajax.reload();
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'logo', name: 'logo'},
            {data: 'note', name: 'note'},
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
});
