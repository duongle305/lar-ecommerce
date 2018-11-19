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
            ['name' => 'Hà Nội','slug_name' => 'ha-noi','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Giang','slug_name' => 'ha-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cao Bằng','slug_name' => 'cao-bang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Kạn','slug_name' => 'bac-kan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tuyên Quang','slug_name' => 'tuyen-quang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lào Cai','slug_name' => 'lao-cai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Điện Biên','slug_name' => 'dien-bien','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lai Châu','slug_name' => 'lai-chau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Sơn La','slug_name' => 'son-la','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Yên Bái','slug_name' => 'yen-bai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hòa Bình','slug_name' => 'hoa-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thái Nguyên','slug_name' => 'thai-nguyen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lạng Sơn','slug_name' => 'lang-son','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Ninh','slug_name' => 'quang-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Giang','slug_name' => 'bac-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Phú Thọ','slug_name' => 'phu-tho','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Vĩnh Phúc','slug_name' => 'vinh-phuc','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bắc Ninh','slug_name' => 'bac-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hải Dương','slug_name' => 'hai-duong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hải Phòng','slug_name' => 'hai-phong','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hưng Yên','slug_name' => 'hung-yen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thái Bình','slug_name' => 'thai-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Nam','slug_name' => 'ha-nam','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Nam Định','slug_name' => 'nam-dinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Ninh Bình','slug_name' => 'ninh-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thanh Hóa','slug_name' => 'thanh-hoa','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Nghệ An','slug_name' => 'nghe-an','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hà Tĩnh','slug_name' => 'ha-tinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Bình','slug_name' => 'quang-binh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Trị','slug_name' => 'quang-tri','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Thừa Thiên Huế','slug_name' => 'thua-thien-hue','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đà Nẵng','slug_name' => 'da-nang','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Nam','slug_name' => 'quang-nam','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Quảng Ngãi','slug_name' => 'quang-ngai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Định','slug_name' => 'binh-dinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Phú Yên','slug_name' => 'phu-yen','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Khánh Hòa','slug_name' => 'khanh-hoa','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Ninh Thuận','slug_name' => 'ninh-thuan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Thuận','slug_name' => 'binh-thuan','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Kon Tum','slug_name' => 'kon-tum','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Gia Lai','slug_name' => 'gia-lai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đắk Lắk','slug_name' => 'dak-lak','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đắk Nông','slug_name' => 'dak-nong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Lâm Đồng','slug_name' => 'lam-dong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Phước','slug_name' => 'binh-phuoc','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tây Ninh','slug_name' => 'tay-ninh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bình Dương','slug_name' => 'binh-duong','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đồng Nai','slug_name' => 'dong-nai','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bà Rịa - Vũng Tàu','slug_name' => 'ba-ria-vung-tau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hồ Chí Minh','slug_name' => 'ho-chi-minh','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Long An','slug_name' => 'long-an','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Tiền Giang','slug_name' => 'tien-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bến Tre','slug_name' => 'ben-tre','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Trà Vinh','slug_name' => 'tra-vinh','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Vĩnh Long','slug_name' => 'vinh-long','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Đồng Tháp','slug_name' => 'dong-thap','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'An Giang','slug_name' => 'an-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Kiên Giang','slug_name' => 'kien-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cần Thơ','slug_name' => 'can-tho','type' => 'Thành Phố','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Hậu Giang','slug_name' => 'hau-giang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Sóc Trăng','slug_name' => 'soc-trang','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Bạc Liêu','slug_name' => 'bac-lieu','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()],
            ['name' => 'Cà Mau','slug_name' => 'ca-mau','type' => 'Tỉnh','created_at'=> $mytime->toDateTimeString(),'updated_at'=>$mytime->toDateTimeString()]
        ]);
    }
}
