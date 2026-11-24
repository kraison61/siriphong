<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@siriphong.com',
        ], [
            'name' => 'Siriphong Admin',
            'password' => 'password',
        ]);

        $this->call(SettingSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(IndustrialVacuum3MotorPageSeeder::class);
        $this->call(WpBfProductSeeder::class);
        $this->call(SeoVacuumCaseSeeder::class);
        $this->call(SeoPortfolioCasesSeeder::class);
        $this->call(SaraburiCarwashPortfolioSeeder::class);
        $this->call(MotorRepairBlogSeeder::class);
        $this->call(RepairSubmergedIndustrialVacuumBlogSeeder::class);
        $this->call(ShowroomVacuumOnsiteRepairPortfolioSeeder::class);
        $this->call(SchoolVacuumWontTurnOnPortfolioSeeder::class);
        $this->call(PortfolioCategorySeeder::class);
        $this->call(CentricPlaceHotelPortfolioSeeder::class);
    }
}
