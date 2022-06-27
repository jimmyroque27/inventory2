<?php

use Illuminate\Database\Seeder;

use App\Event;
class AddDummyEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
        	['title'=>'Demo Event-1', 'start'=>'2022-06-11', 'end'=>'2022-06-12'],
        	['title'=>'Demo Event-2', 'start'=>'2022-06-11', 'end'=>'2022-06-13'],
        	['title'=>'Demo Event-3', 'start'=>'2022-06-14', 'end'=>'2022-06-14'],
        	['title'=>'Demo Event-3', 'start'=>'2022-06-17', 'end'=>'2022-06-17'],
        ];
        foreach ($data as $key => $value) {
        	Event::create($value);
        }
    }
}
