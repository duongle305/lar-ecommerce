$(document).ready(function () {
    let url = $('#tab1').data('url');
    let tableOrders = $('#table_orders').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: url,
           error: function (xhr, error, thrown) {
               if (xhr.status === 500) {
                   let resp = xhr.responseJSON;
                   toastr.error(resp.message, 'Thông báo');
                   tableOrders.DataTable().ajax.reload();
               }
           }
       },
       columns: [
           {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
           {data: 'code', name: 'code'},
           {data: 'created_at', name: 'created_at'},
           {data: 'customer', name: 'customer'},
           {data: 'product_quantity', name: 'product_quantity'},
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
       },
        "pageLength": 10
   });

   $('.nav-link').click(event=>{
       Loading.show();
       let route = $(event.target).data('url');
       tableOrders.ajax.url(route).load();
       $('#tab-title').text(`Danh Mục Đơn Hàng ${$(event.target).text()}`);
       Loading.close();
   });
});
$(document).ready(function () {
   $('#modal_order_detail').on('show.bs.modal',event=>{
       Loading.show();
       let url = $(event.relatedTarget).data('url');
       let orderCode = $('#order_code');

       axios.get(url).then(response=>{
           orderCode.text(response.data.code);
           $('#customer_name').text(response.data.customer_info.name);
           $('#customer_phone').text((response.data.customer_info.phone) ? response.data.customer_info.phone : 'N/A');
           $('#customer_email').text((response.data.customer_info.email) ? response.data.customer_info.email : 'N/A');
           $('#customer_address').text((response.data.customer_info.address) ? response.data.customer_info.address : 'N/A');
           $('#order_status').html(`<b>${response.data.status}</b>`);
           $('#order_date').text(response.data.order_date);
           $('#total_product').text(response.data.total_product);
           $('#total_price').text(`${response.data.total_price} VNĐ`);
           $('#order_address').text(response.data.address);
           $('#order_note').text((response.data.order_note) ? response.data.order_note : 'N/A');

           let products = response.data.products;
           let html = '';
           for (let product of products){
               html+=`<tr>
                            <td>${product.code}</th>
                            <td>${product.title}</td>
                            <td>${product.order_price} VNĐ</td>
                            <td>${product.order_quantity}</td>
                        </tr>`;
           }

           $('#ordrt_products').html(html);
           Loading.close();
       }).catch(feedback)
   });
   $(document).on('click','.next-status',event=>{
       Loading.show();
       let url = $(event.target).data('url');
       axios.get(url).then(response=>{
           toastr.clear();
           toastr.success(response.data.message,'Thông báo');
           $('#table_orders').DataTable().ajax.reload();
           Loading.close();
       }).catch(feedback)
   })
});
