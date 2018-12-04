<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $mytime = Carbon\Carbon::now();
        
        DB::table('provinces')->insert([
            ['name' => 'Hà Nội','slug' => 'ha-noi','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Giang','slug' => 'ha-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cao Bằng','slug' => 'cao-bang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Kạn','slug' => 'bac-kan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tuyên Quang','slug' => 'tuyen-quang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lào Cai','slug' => 'lao-cai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Điện Biên','slug' => 'dien-bien','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lai Châu','slug' => 'lai-chau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Sơn La','slug' => 'son-la','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Yên Bái','slug' => 'yen-bai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hòa Bình','slug' => 'hoa-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thái Nguyên','slug' => 'thai-nguyen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lạng Sơn','slug' => 'lang-son','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Ninh','slug' => 'quang-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Giang','slug' => 'bac-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Phú Thọ','slug' => 'phu-tho','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Vĩnh Phúc','slug' => 'vinh-phuc','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Ninh','slug' => 'bac-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hải Dương','slug' => 'hai-duong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hải Phòng','slug' => 'hai-phong','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hưng Yên','slug' => 'hung-yen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thái Bình','slug' => 'thai-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Nam','slug' => 'ha-nam','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Nam Định','slug' => 'nam-dinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Ninh Bình','slug' => 'ninh-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thanh Hóa','slug' => 'thanh-hoa','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Nghệ An','slug' => 'nghe-an','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Tĩnh','slug' => 'ha-tinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Bình','slug' => 'quang-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Trị','slug' => 'quang-tri','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thừa Thiên Huế','slug' => 'thua-thien-hue','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đà Nẵng','slug' => 'da-nang','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Nam','slug' => 'quang-nam','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Ngãi','slug' => 'quang-ngai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Định','slug' => 'binh-dinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Phú Yên','slug' => 'phu-yen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Khánh Hòa','slug' => 'khanh-hoa','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Ninh Thuận','slug' => 'ninh-thuan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Thuận','slug' => 'binh-thuan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Kon Tum','slug' => 'kon-tum','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Gia Lai','slug' => 'gia-lai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đắk Lắk','slug' => 'dak-lak','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đắk Nông','slug' => 'dak-nong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lâm Đồng','slug' => 'lam-dong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Phước','slug' => 'binh-phuoc','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tây Ninh','slug' => 'tay-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Dương','slug' => 'binh-duong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đồng Nai','slug' => 'dong-nai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bà Rịa - Vũng Tàu','slug' => 'ba-ria-vung-tau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hồ Chí Minh','slug' => 'ho-chi-minh','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Long An','slug' => 'long-an','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tiền Giang','slug' => 'tien-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bến Tre','slug' => 'ben-tre','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Trà Vinh','slug' => 'tra-vinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Vĩnh Long','slug' => 'vinh-long','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đồng Tháp','slug' => 'dong-thap','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'An Giang','slug' => 'an-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Kiên Giang','slug' => 'kien-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cần Thơ','slug' => 'can-tho','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hậu Giang','slug' => 'hau-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Sóc Trăng','slug' => 'soc-trang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bạc Liêu','slug' => 'bac-lieu','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cà Mau','slug' => 'ca-mau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()]
        ]);
    }
}
