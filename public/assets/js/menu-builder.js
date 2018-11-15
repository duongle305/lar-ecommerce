$(document).ready(()=>{
    let tableMenus = $('#table_menus');
    let btnReloadMenus = $('#btn-reload-menus');
    tableMenus.DataTable({
        processing: true,
        serverSide: true,
        ajax: href,
        columns:[
            { data: 'DT_RowIndex',name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name:'name'},
            { data: 'email', name:'email'},
            { data: 'role', name:'role'},
            { data: 'actions',name:'actions', class:'text-xs-center', orderable: false, searchable: false}
        ],
        oLanguage: {
            sLengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
            sZeroRecords: 'Không tìm thấy dữ liệu',
            sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
            sInfoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
            sInfoFiltered: '(lọc từ tổng số _MAX_ dòng)',
            sSearch:'Tìm kiếm:'
        }
    });
});