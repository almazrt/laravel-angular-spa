<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<SQL
insert into cities(name) values('Москва');
insert into cities(name) values('Казань');
SQL;

        Db::unprepared($sql);
    }
}
