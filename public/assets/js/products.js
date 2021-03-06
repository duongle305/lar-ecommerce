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
    btnReloadProducts.on('click',(event) => {
        event.preventDefault();
        Loading.show();
        tableProducts.DataTable().ajax.reload();
        Loading.close();
    });
});

$(document).ready(function () {
    let descriptionImg = [];
    let attributes = [];
    let createProductName = $('input[name=create_product_name]');
    let createProductBrand =$('select[name=create_product_brand]');
    let createProductCategory = $('select[name=create_product_category]');
    let createProductPrice = $('input[name=create_product_price]');
    let createProductDiscount = $('input[name=create_product_discount]');
    let createProductNote = $('textarea[name=create_product_note]');
    let createProductDescription = $('textarea[name=create_product_description]');
    let createProductAttributeValue = $('input[id=create_product_attribute_value]');
    let createProductAttributeName = $('input[id=create_product_attribute_name]');
    let createProductCode = $('input[name=create_product_code]');
    let createProductCheckAutoCode = $('input[name=create_product_check_auto_code]');
    let createProductQuantity = $('input[name=create_product_quantity]');
    let addAttributeBtn = $('#add_attribute_btn');
    let formCreateProduct = $('#form_create_product');

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

    createProductCheckAutoCode.attr('checked',true);

    $('.add-code').hide();

    createProductCheckAutoCode.change(event=>{
        if($(event.target).is(':checked')){
            $('.add-code').hide();
        } else {
            $('.add-code').show();
        }
    });

    createProductCode.on('input',(event)=>{
        createProductCode.val(createProductCode.val().toUpperCase());
    });

    createProductPrice.autoNumeric('init', {mDec: '0'});

    $('.dropify').dropify();

    createProductNote.summernote({
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

    createProductDescription.summernote({
        height: 200,
        placeholder: 'Mô tả sản phẩm',
        callbacks:{
            onImageUpload: function(files, editor, welEditable) {
                uploadImage(files,createProductDescription);
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

    createProductBrand.select2({
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

    createProductCategory.select2({
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

    addAttributeBtn.click(event=>{
        event.preventDefault();
        if(createProductAttributeValue.val().length === 0 || createProductAttributeName.val().length === 0){
            toastr.clear();
            toastr.error('Chưa nhập đủ thông tin','Thông báo');
            return false;
        }
        attributes.push({'title':createProductAttributeName.val(),'value':createProductAttributeValue.val()});
        generateTableBody();
        createProductAttributeValue.val('');
        createProductAttributeName.val('');
    });

    $(document).on('click','.delete-attribute',event=>{
        event.preventDefault();
        let index = $(event.target).data('index');
        attributes.splice(index, 1);
        generateTableBody();
    });

    let manualUploader = new qq.FineUploader({
        element: document.getElementById('my-uploader'),
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

    $('.reload').click(event=>{
        Loading.show();
        event.preventDefault();
        formCreateProduct.trigger('reset');
        createProductBrand.val(null).trigger('change');
        createProductCategory.val(null).trigger('change');
        createProductNote.summernote('reset');
        createProductDescription.summernote('reset');
        $('#table_attribute_body').html('');
        attributes = [];
        if(descriptionImg.length > 0){
            let formData = new FormData();
            formData.append('images',JSON.stringify(descriptionImg));
            formData.append('type','0');
            axios.post('/products/delete-image',formData).then(response=>{
                if(response.data.code === 1)
                    console.log(response.data.message);
                descriptionImg = [];
            }).catch(error=>{

            })
        }
        $('.dropify-clear').click();
        manualUploader.reset();
        Loading.close();
    });

    formCreateProduct.submit(event=>{
        event.preventDefault();
        let url = $(event.target).attr('action');
        let imageBtn = document.getElementsByClassName('qq-upload-cancel');
        if(imageBtn.length < 1){
            toastr.clear();
            toastr.error('Thêm ít nhất 1 hình ảnh cho sản phẩm','Thông báo');
            return false;
        }

        Loading.show();
        let formData = new FormData(event.target);

        if(attributes.length > 0)
            formData.append('attributes',JSON.stringify(attributes));

        let categories = [];

        for (let category of createProductCategory.select2('data')){
            categories.push(category.id)
        }

        formData.append('create_product_category',JSON.stringify(categories));
        formData.append('create_product_price',createProductPrice.val().replace(/\./gi, ""));
        axios.post(url,formData).then(res=>{
            if(res.data.code === 1){
                manualUploader.setParams({
                    'image_type': 1,
                    'product_slug': Helpers.slug(createProductName.val()),
                    'product_id' : res.data.data.id
                });
                manualUploader.uploadStoredFiles();
            }
        }).catch(feedback)
    });

    $(document).on('click','.change-state',event=>{
        event.preventDefault();
        let url = $(event.target).data('change');
        Loading.show();
        axios.get(url).then(response=>{
            if(response.data.code === 1){
                $('#table_products').DataTable().ajax.reload();
                toastr.clear();
                toastr.success(response.data.message,'Thông báo');
                Loading.close();
            }
        }).catch(feedback)
    });

    $(document).on('click','.delete',event=>{
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
                    $('#table_products').DataTable().ajax.reload();
                }).catch(feedback)
            }
        })
    });

    $(document).on('click','.view',event=>{
        let url = $(event.target).data('view');
        window.open(url,'_blank');
    });
    // $(document).on('click','.edit',event=>{
    //     let url = $(event.target).data('edit');
    //     window.open(url,'_blank');
    // });
});
