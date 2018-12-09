$(document).ready(function () {
    $('.dropify').dropify();
    $('#form_edit_logo').submit(event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');
        let formData = new FormData(event.target);

        axios.post(url,formData).then(response=>{
            toastr.success(response.data.message,'Thông báo');
            Loading.close();
            location.reload();
        }).catch(feedback)
    });
});
