<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('degrees')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $degrees = [
            "Associate's Degree",
            "Associate of Arts (AA)",
            "Associate of Arts and Sciences (AAS)",
            "Associate of Sciences (AS)",

            "Bachelor's Degree",
            "Bachelor of Applied Science (BASc)",
            "Bachelor of Architecture (BArch)",
            "Bachelor of Arts (BA)",
            "Bachelor of Business Adminitration (BBA)",
            "Bachelor of Commerce (BCom)",
            "Bachelor of Education (BEd)",
            "Bachelor of Engineering (BEng)",
            "Bachelor of Fine Arts (BFA)",
            "Bachelor of Laws (LLB)",
            "Bachelor of Medicine, Bachelor of Surgery (MBBS)",
            "Bachelor of Pharmacy (BPharm)",
            "Bachelor of Science (BS)",
            "Bachelor of Technology (BTech)",
            "Bachelor of Computer Science (BCompSC)",
            "Bachelor of Computer Applications",
            "Bachelor of Music (BM)",
            "Bachelor of Science in Journalism",
            "Bachelor of Accountancy (BAcc)",
            "Bachelor of Science in Nursing (BSN)",
            "Bachelor of Visual Communication Design",

            "Master's Degree",
            "Master of Architecture (MArch)",
            "Master of Arts (MA)",
            "Master of Business Adminitration (MBA)",
            "Master of Computer Applications (MCA)",
            "Master of Divinity (MDiv)",
            "Master of Fine Arts (MFA)",
            "Master of Education (MEd)",
            "Master of Laws (LLM)",
            "Master of Library and Information Science (MLIS)",
            "Master of Philosophy (MPhil)",
            "Master of Commerce (MCom)",
            "Master of Public Health (MPH)",
            "Master of Science (MS)",
            "Master of Social Work (MSW)",
            "Master of Technology (MTech)",
            "Master of Public Adminitration (MPA)",
            "Master of Design (MDes)",
            "Master of Industrial Design",
            "Master of Engineering (MEng)",
            "Master of Science in Project Management (MSPM)",
            "Master of Science in Information Technology (MSc(IT))",
            'Master of Information Technology (MIT)',
            "Master of Computer Science (MSCS)",
            "Master of Mass Communication and Journalism",
            "Master of Educational Technology",
            "Master of Accountancy (MAcc)",
            "Master of Music (MM)",

            "Doctor's Degree",
            "Doctor of Engineering (DEng)",
            "Doctor of Education (EdD)",
            "Doctor of Law (JD)",
            "Doctor of Medicine (MD)",
            "Doctor of Pharmacy (PharmD)",
            "Doctor of Philosophy (PhD)",
            "Doctor of Business Adminitration (DBA)",

        ];
    	foreach ($degrees as $key => $value) {
        	\App\Models\Degree::create(['name' => $value]);
    	}
    }
}
