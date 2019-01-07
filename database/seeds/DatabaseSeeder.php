<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      $limit = 50;

      for ($i = 0; $i < $limit; $i++) {
          DB::table('siswas')->insert([ //,
              'nisn' => str_random(4),
              'nama_siswa' => str_random(10),
          ]);
      }
    }
}
