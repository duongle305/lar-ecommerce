<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            ['name'=>'Chờ xử lý','note'=>'PENDING'],
            ['name'=>'Sẵn sàng giao','note'=>'READY'],
            ['name'=>'Đang giao','note'=>'SHIPPING'],
            ['name'=>'Hoàn thành','note'=>'DELIVERED'],
            ['name'=>'Hủy bỏ','note'=>'CANCELLED'],
            ['name'=>'Thất bại','note'=>'DELIVERY FAILED'],
            ['name'=>'Trả hàng','note'=>'RETURNED'],
        ]);
    }
}
