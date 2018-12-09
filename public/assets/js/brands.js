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
            {data: 'state', name: 'state'},
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
    let deleteBrand = null;
    let currentBrand = $('input[name=current_brand]');
    let transferBrand = $('select[name=transfer_brand]');
    let transferBrandID = $('input[name=transfer_brand_id]');

    $('.dropify').dropify();
    $('#modal_edit_brand').on('show.bs.modal', (event) => {
        Loading.show();
        let id = $(event.relatedTarget).data('id');
        let editUrl = $(event.relatedTarget).data('edit');
        let editBrandID = $('input[name=edit_brand_id]');
        let editBrandName = $('input[name=edit_brand_name]');
        let editBrandNote = $('textarea[name=edit_brand_note]');
        let editBrandLogo = $('input[name=edit_brand_logo]');
        let inputShowImg = $('.dropify-render img')[0];
        let removeBtn = $('.dropify-clear')[0];
        editBrandID.val('');
        editBrandName.val('');
        editBrandNote.val('');
        editBrandLogo.val(null);
        $(inputShowImg).removeAttr('src');

        axios.get(editUrl).then(response => {
            editBrandID.val(id);
            editBrandName.val(response.data.name);
            editBrandNote.val(response.data.note);
            $(inputShowImg).attr('src', response.data.logo_url);
            $(removeBtn).hide();
            Loading.close();
        }).catch(feedback)
    });

    $('input[name=edit_brand_logo]').change(event=>{
        let removeBtn = $('.dropify-clear')[0];
        if($(event.target)[0].files.length > 0){
            $(removeBtn).show();
        } else $(removeBtn).hide();
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
        }).catch(feedback);
    });

    /*delete brand*/
    $(document).on('click','.delete',(event)=>{
        event.preventDefault();
        let href = $(event.target).data('delete');
        deleteBrand = $(event.target).data('id');
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
                Loading.show();
                axios.delete(href).then(res=>{
                    Loading.close();
                    if(res.data.has_product > 0){
                        swal({
                            title: 'Thông báo',
                            type: 'info',
                            html: res.data.message,
                            showCloseButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Chuyển sản phẩm',
                            cancelButtonText: 'Đóng',
                            confirmButtonClass: 'btn btn-primary btn-lg mr-1',
                            cancelButtonClass: 'btn btn-danger btn-lg',
                            buttonsStyling: false
                        }).then(function(isConfirm) {
                            if (isConfirm) {
                                $('#modal_transfer_brand').modal('show');
                            }
                        });
                    } else {
                        toastr.success(res.data.message,'Thông báo');
                        $('#table_brands').DataTable().ajax.reload();
                    }

                }).catch(feedback)
            }
        })
    });

    $('#modal_transfer_brand').on('show.bs.modal',event=>{
        currentBrand.val('');
        transferBrand.val(null).trigger('change');
        transferBrandID.val(deleteBrand);

        Loading.show();
        axios.get(`/brands/get-info-change-brand/${deleteBrand}`).then(response=>{
            currentBrand.val(response.data.name);
            Loading.close();
        }).catch(feedback)
    });

    transferBrand.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/brands/get-brands',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    current_brand: deleteBrand,
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: `${item.name}`,
                            id: item.id
                        }
                    }),
                    pagination: {
                        more : (params.page  * 10) < data.total
                    }
                };
            },
            cache: true
        },
        templateResult : function (repo) {
            if(repo.loading) return repo.text;
            var markup = repo.text;
            return markup;
        },
        templateSelection : function(repo) {
            return repo.text;
        },
        escapeMarkup : function(markup){ return markup; }
    });

    $('#form_transfer_brand').submit(event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');
        let formData = new FormData(event.target);
        axios.post(url,formData).then(response=>{
            Loading.close();
            $('#table_brands').DataTable().ajax.reload();
            toastr.success(response.data.message,'Thông báo');
            $('#modal_transfer_brand').modal('hide');
        }).catch(feedback)
    });

    $('#modal_create_brand').on('show.bs.modal',(event)=>{
        $('#form_create_brand').trigger('reset');
        let drEvent = $('input[name=create_brand_logo]').dropify().data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
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
        }).catch(feedback);
    });

    $(document).on('click','.change',event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).data('change');
        axios.get(url).then(response=>{
            toastr.clear();
            toastr.success(response.data.message,'Thông báo');
            $('#table_brands').DataTable().ajax.reload();
            Loading.close();
        }).catch(feedback)
    })
});


