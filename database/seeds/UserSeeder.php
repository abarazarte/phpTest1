<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create(
			[
				'username'=>'abarazarte',
				'password'=> Hash::make('123456'),
				'age'=>18
			]);

	}
}
