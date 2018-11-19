$(document).ready(function () {
    let tableBrands = $('#table_brands');
    let btnReloadBrands = $('#btn-reload-brands');
    tableBrands.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: btnReloadBrands.data('href'),
            error: function (xhr, error, thrown) {
                if (xhr.status === 500) {
                    let resp = xhr.responseJSON;
                    toastr.error(resp.message, 'Thông báo');
                    tableBrands.DataTable().ajax.reload();
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'slug', name: 'slug'},
            {data: 'name', name: 'name'},
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
    btnReloadBrands.click((event) => {
        event.preventDefault();
        Loading.show();
        tableBrands.DataTable().ajax.reload();
        Loading.close();
    })
});
$(document).ready(function () {
    $('.dropify').dropify();
    $('#modal_edit_brand').on('show.bs.modal', (event) => {
        Loading.show();
        let id = $(event.relatedTarget).data('id');
        let editUrl = $(event.relatedTarget).data('edit');
        let editBrandID = $('input[name=edit_brand_id]');
        let editBrandSlug = $('input[name=edit_brand_slug]');
        let editBrandName = $('input[name=edit_brand_name]');
        let editBrandNote = $('textarea[name=edit_brand_note]');
        let editBrandLogo = $('input[name=edit_brand_logo]');
        let inputShowImg = $('.dropify-render img')[0];

        editBrandID.val('');
        editBrandName.val('');
        editBrandSlug.val('');
        editBrandNote.val('');
        editBrandLogo.val(null);
        $(inputShowImg).removeAttr('src');

        axios.get(editUrl).then(response => {
            editBrandID.val(id);
            editBrandName.val(response.data.name);
            editBrandSlug.val(response.data.slug);
            editBrandNote.val(response.data.note);
            $(inputShowImg).attr('src', response.data.logo_url);
            Loading.close();
        }).catch(error => {
            console.log(error);
            // toastr.error(error.response.message);
            Loading.close();
        })
    });
    /*submit form edit brand*/
    $('#form_edit_brand').submit((e) => {
        e.preventDefault();
        Loading.show();
        let updateUrl = $(e.target).attr('action');
        let formData = new FormData(e.target);
        axios.post(updateUrl, formData).then(res=>{
            toastr.success(res.data.message,'Thông báo');
            $('#table_brands').DataTable().ajax.reload();
            $('#modal_edit_brand').modal('hide');
            Loading.close();
        }).catch(er=>{
            if(parseInt(er.response.status) === 500){
                toastr.error(er.response.data.error,'Thông báo');
            } else{
                let errors = er.response.data.errors;
                let message = '';
                for (let key in errors) {
                    message += errors[key][0] + "\n";
                }
                toastr.error(message,'Thông báo');
            }
            Loading.close();
        });

    });
    /*delete brand*/
    $(document).on('click','.delete',(event)=>{
        event.preventDefault();
        let href = $(event.target).data('delete');
        swal({
            title: 'Are you sure?',
            text: "Bạn sẽ không thể khôi phục lại điều này !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
            confirmButtonClass: 'btn btn-primary mr-1',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function (isConfirm) {
            if (isConfirm === true) {
                axios.delete(href).then(res=>{
                    swal({
                        title: 'Deleted!',
                        text: res.data.message,
                        type: 'success',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    $('#table_brands').DataTable().ajax.reload();
                }).catch(er=>{
                    swal({
                        title: 'Thông báo',
                        text: er.response.message,
                        type: 'error',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false
                    });
                    Loading.close();
                })
            }
        })
    });

    $('#modal_create_brand').on('show.bs.modal',(event)=>{
        let createBrandSlug = $('input[name=create_brand_slug]');
        let createBrandName = $('input[name=create_brand_name]');
        let createBrandNote = $('textarea[name=create_brand_note]');
        let createBrandLogo = $('input[name=create_brand_logo]');
        let drEvent = createBrandLogo.dropify().data('dropify');

        createBrandName.val('');
        createBrandSlug.val('');
        createBrandLogo.val(null);
        createBrandNote.val('');
        drEvent.resetPreview();
        drEvent.clearElement();
    });

    $('#create_brand_name').on('input',(event)=>{
        let displayName = $(event.currentTarget).val();
        $('input[name=create_brand_slug]').val(Helpers.slug(displayName));
    });

    $('#form_create_brand').submit((event)=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');
        let formData = new FormData(event.target);
        axios.post(url, formData).then(res=>{
            toastr.success(res.data.message,'Thông báo');
            $('#table_brands').DataTable().ajax.reload();
            $('#modal_create_brand').modal('hide');
            Loading.close();
        }).catch(er=>{
            if(parseInt(er.response.status) === 500){
                toastr.error(er.response.data.error,'Thông báo');
            } else{
                let errors = er.response.data.errors;
                let message = '';
                for (let key in errors) {
                    message += errors[key][0] + "\n";
                }
                toastr.error(message,'Thông báo');
            }
            Loading.close();
        });
    });
});
