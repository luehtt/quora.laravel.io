<?php

use App\ReportReason;
use Illuminate\Database\Seeder;

class ReportReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportReason::create([ 'name' => 'Nội dung không phù hợp' ]);
        ReportReason::create([ 'name' => 'Ngôn ngữ đả kích' ]);
        ReportReason::create([ 'name' => 'Phân biệt chủng tộc' ]);
        ReportReason::create([ 'name' => 'Vi phạm bản quyền' ]);
    }
}
