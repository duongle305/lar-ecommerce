$(document).ready(function () {
    let modalResponse = null;
    let brand = $('select[name=brand]');
    let categories = $('select[name=categories]');
    let price = $('input[name=price]');
    let note = $('textarea[name=note]');
    let description = $('textarea[name=description]');
    let thumbnail = $('input[name=thumbnail]');
    let productImages = $('#product_images');
    let editProductImage = $('input[name=edit_product_image]');
    let formEditProductIamge = $('#form_edit_product_iamge');

    function uploadImage(files,input){
        let url = createProductDescription.data('url');
        var formData = new FormData();
        formData.append('image_type','0');
        formData.append("description_image", files[0]);
        axios.post(url, formData).then(res=>{
            descriptionImg.push(res.data.image_name);
            input.summernote('editor.insertImage',res.data.image_url);
        }).catch();
    }
    function generateTableBody(){
        let html = '';
        attributes.forEach(function (item,index) {
            html +=`<tr>
                        <td>${item.title}</td>
                        <td>${item.value}</td>
                        <td class="text-center"><button type="button" class="btn btn-danger delete-attribute" data-index="${index}"><i class="ti-close"></i> Xóa</button></td>
                    </tr>`
        });
        $('#table_attribute_body').html(html);
    }
    function setDropifyInfo(response,dropifyRender,dropifyFilenameInner,dropifyPreview){
        $(dropifyRender).html(`<img src="${response.data.url}"/>`);
        $(dropifyFilenameInner).text(response.data.image_name);
        $(dropifyPreview).show();
    }
    function resetDropifyInfo(dropifyPreview,dropifyFilenameInner,remove){
        $(remove).click();
        $(dropifyPreview).hide();
        $(dropifyFilenameInner).text('');
    }
    function generateImages(images){
        let html = '';
        for(image of images){
            html+=`<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="card">
                            <img class="card-img-top img-fluid hoverZoomLink" src="${image.image_url}" alt="Card image cap">
                            <div class="card-block text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_image" data-url="${image.url}" data-id="${image.id}">Sửa</button>
                                    <button type="button" class="btn btn-danger image-delete" data-url="${image.delete_url}">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
        }

        $('#product_images_show').html(html);
    }

    $('.dropify').dropify();

    price.autoNumeric('init', {mDec: '0'});

    brand.select2({
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/products/get-brand',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
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

    categories.select2({
        multiple:true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url : '/products/get-categories',
            dataType: 'json',
            delay : 250,
            method:'POST',
            data : function(params){
                return {
                    keyword : params.term,
                    page : params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        if(item != null)
                            return {
                                text: item.title,
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

    note.summernote({
        height: 100,
        placeholder: 'Ghi chú sản phẩm',
        callbacks:{
            onImageUpload: function(files, editor, welEditable) {
                uploadImage(files,createProductNote);
            },
            onMediaDelete : function(target) {
                let tmp = target[0].src.split('/');
                var fileName = tmp[tmp.length - 1];

                let formData = new FormData();
                formData.append('images',JSON.stringify([fileName]));
                formData.append('type','0');
                axios.post('/products/delete-image',formData).then(response=>{
                    if(response.data.code === 1)
                        console.log(response.data.message);
                }).catch()
            }
        }
    });

    description.summernote({
        height: 200,
        placeholder: 'Ghi chú sản phẩm',
        callbacks:{
            onImageUpload: function(files, editor, welEditable) {
                uploadImage(files,createProductNote);
            },
            onMediaDelete : function(target) {
                let tmp = target[0].src.split('/');
                var fileName = tmp[tmp.length - 1];

                let formData = new FormData();
                formData.append('images',JSON.stringify([fileName]));
                formData.append('type','0');
                axios.post('/products/delete-image',formData).then(response=>{
                    if(response.data.code === 1)
                        console.log(response.data.message);
                }).catch()
            }
        }
    });

    let manualUploader = new qq.FineUploader({
        element: document.getElementById('product_images'),
        template: 'qq-template',
        request: {
            customHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            endpoint: '/products/upload-image'
        },

        callbacks: {
            onAllComplete: function(succeeded,failed) {
                toastr.clear();
                toastr.success('Thêm sản phẩm thành công','Thông báo');
                location.reload();
                Loading.close();
            },
        },
        thumbnails: {
            placeholders: {
                waitingPath: '/storage/uploads/image_source/waiting-generic.png',
                notAvailablePath: '/storage/uploads/image_source/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png','gif'],
        },
        autoUpload: false,
        debug: false
    });

    $('#modal_edit_image').on('show.bs.modal',event=>{
        Loading.show();
        let url = $(event.relatedTarget).data('url');
        let id = $(event.relatedTarget).data('id');
        $('input[name=image_id]').val(id);
        let dropifyPreview = editProductImage.next().next();
        let remove =editProductImage.next();
        let dropifyRender = $(dropifyPreview).children('.dropify-render')[0];
        let dropifyInfos =  $(dropifyPreview).children('.dropify-infos')[0];
        let dropifyFilenameInner = $($($(dropifyInfos).children('.dropify-infos-inner')[0]).children('.dropify-filename')[0]).children('.dropify-filename-inner')[0];
        resetDropifyInfo(dropifyPreview,dropifyFilenameInner,remove);
        axios.get(url).then(response=>{
            modalResponse = response;
            setDropifyInfo(response,dropifyRender,dropifyFilenameInner,dropifyPreview);
            Loading.close();
        }).catch(feedback);
        remove.click(event=>{
            setDropifyInfo(modalResponse,dropifyRender,dropifyFilenameInner,dropifyPreview)
        })
    });

    $(document).on('click','.edit-attribute',event=>{
        let valueEl = $(event.target).parent().parent().prev()[0];
        let titleEl = $(event.target).parent().parent().prev().prev()[0];
        let value = $(valueEl).text();
        let title = $(titleEl).text();
        let input1 = document.createElement('input');
        let input2 = document.createElement('input');
        $(input1).addClass('form-control').val(title);
        $(input2).addClass('form-control').val(value);
        $(valueEl).text('').append(input2);
        $(titleEl).text('').append(input1);

        $(event.target).removeClass('btn-warning').removeClass('edit-attribute').addClass('btn-success').addClass('ok-edit').text('Ok');
    });

    $(document).on('click','.ok-edit',event=>{
        event.preventDefault();
        let valueEl = $(event.target).parent().parent().prev()[0];
        let titleEl = $(event.target).parent().parent().prev().prev()[0];

        let input1 = $(valueEl).children('input')[0];
        let input2 = $(titleEl).children('input')[0];

        $(valueEl).html('').text($(input1).val());
        $(titleEl).html('').text($(input2).val());

        $(event.target).removeClass('btn-success').removeClass('ok-edit').addClass('btn-warning').addClass('edit-attribute').text('Sửa');

    });

    $(document).on('click','.delete-attribute',event=>{
        let tr = $(event.target).parent().parent().parent()[0];
        $(tr).remove();
    });

    formEditProductIamge.submit(event=>{
        event.preventDefault();
        Loading.show();
        let url = $(event.target).attr('action');
        let formData = new FormData(event.target);
        axios.post(url,formData).then(response=>{
            if(parseInt(response.data.code) === 1){
                toastr.success(response.data.message,'Thông báo');
                $('#modal_edit_image').modal('hide');
                generateImages(response.data.images);
            }
            Loading.close();
        }).catch(feedback)
    });

    $(document).on('click','.image-delete',event=>{
        event.preventDefault();
        let url = $(event.target).data('url');
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
                axios.get(url).then(res=>{
                    if(res.data.code === 1){
                        swal({
                            title: 'Deleted!',
                            text: res.data.message,
                            type: 'success',
                            confirmButtonClass: 'btn btn-primary',
                            buttonsStyling: false
                        });
                        generateImages(res.data.images);
                    }
                }).catch(feedback)
            }
        })
    });

    $('#form_edit_product').submit(event=>{
        event.preventDefault();
        let url = $(event.target).attr('action');
        let tableAttributeBody =$('#table_attribute_body');

        let formData = new FormData(event.target);

        let attributes = [];

        for (let tr of tableAttributeBody.children('tr')){
            let title = $($(tr).children('td')[0]).text();
            let value = $($(tr).children('td')[1]).text();
            attributes.push({title: title,value:value});
        }

        formData.append('attributes',JSON.stringify(attributes));


        let categoriesData = [];

        for (let category of categories.select2('data')){
            categoriesData.push(category.id)
        }

        formData.append('categories',JSON.stringify(categoriesData));

        axios.post(url,formData).then(response=>{

        }).catch(feedback)
    });
});
