$(document).ready(function () {
    let tableSliders = $('#table_sliders');
    let btnReloadSliders = $('#btn-reload-sliders');
    tableSliders.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: btnReloadSliders.data('href'),
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
            {data: 'url', name: 'url'},
            {data: 'image', name: 'image'},
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
    btnReloadSliders.click((event) => {
        event.preventDefault();
        Loading.show();
        tableSliders.DataTable().ajax.reload();
        Loading.close();
    })
});

$(document).ready(function () {
    $('.dropify').dropify();
    let formCreateSlider = $('#form_create_slider');

    $('#modal_create_slider').on('show.bs.modal',event=>{
        $('input[name=create_slider_url]').val('');
        $('textarea[name=create_slider_note]').val('');
        let createSliderImage =  $('input[name=create_slider_image]');
        let btnRemove = createSliderImage.next();
        btnRemove.click();
    });

    formCreateSlider.submit(event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');

        let formData = new FormData(event.target);

        axios.post(url,formData).then(response=>{
            Loading.close();
            toastr.success(response.data.message,'Thông báo');
            $('#table_sliders').DataTable().ajax.reload();
            $('#modal_create_slider').modal('hide');
        }).catch(feedback);

    })
});

$(document).ready(function () {
   $('#modal_edit_slider').on('show.bs.modal',event=>{
       let url = $(event.relatedTarget).data('edit');
       Loading.show();
       $('input[name=edit_slider_id]').val('');
       $('input[name=edit_slider_url]').val('');
       $('textarea[name=edit_slider_note]').val('');
       let btn = $('input[name=edit_slider_image]').next();
       btn.click();
       axios.get(url).then(response=>{
           $('input[name=edit_slider_id]').val(response.data.id);
           $('input[name=edit_slider_url]').val(response.data.url);
           $('textarea[name=edit_slider_note]').val(response.data.note);
           let preview = $('input[name=edit_slider_image]').next().next();
           preview.show();
           let render = preview.children('.dropify-render');
           $(render).html(`<img src="${response.data.image_url}"/>`);
           Loading.close();
       }).catch(feedback)
   });

   $('#form_edit_slider').submit(event=>{
       event.preventDefault();
       Loading.show();

       let url = $(event.target).attr('action');
       let formData = new FormData(event.target);

       axios.post(url,formData).then(response=>{
           toastr.clear();
           toastr.success(response.data.message,'Thông báo');
           $('#table_sliders').DataTable().ajax.reload();
           $('#modal_edit_slider').modal('hide');
           Loading.close();
       }).catch(feedback)
   });

   $(document).on('click','.change',event=>{
       event.preventDefault();
       let url = $(event.target).data('change');
       Loading.show();
       axios.get(url).then(response=>{
           toastr.success(response.data.message,'Thông báo');
           $('#table_sliders').DataTable().ajax.reload();
           Loading.close();
       }).catch(feedback)
   });

   $(document).on('click','.delete',event=>{
       event.preventDefault();
       let url = $(event.target).data('delete');
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
               axios.delete(url).then(res=>{
                   Loading.close();
                   toastr.success(res.data.message,'Thông báo');
                   $('#table_sliders').DataTable().ajax.reload();
               }).catch(feedback)
           }
       })
   });
});
