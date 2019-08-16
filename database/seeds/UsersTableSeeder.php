<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
		
		$adminRole = Role::where('name', 'admin')->first();
		$saleRole = Role::where('name', 'sale')->first();
		$supportRole = Role::where('name', 'support')->first();
		$userRole = Role::where('name', 'user')->first();
		
		$admin = User::create([
			'name' => 'Admin',
			'email' => 'admin@admin.com',
			'password' => bcrypt('admin'),
			'remember_token' => Str::random(10),
			'responsibilities' => '{}',
        ]);
		
		$sale = User::create([
			'name' => 'Sale',
			'email' => 'sale@sale.com',
			'password' => bcrypt('sale'),
			'remember_token' => Str::random(10),
			'responsibilities' => '{}',
        ]);
		
		$support = User::create([
			'name' => 'Support',
			'email' => 'support@support.com',
			'password' => bcrypt('support'),
			'remember_token' => Str::random(10),
			'responsibilities' => '{}',
        ]);
		
		$user = User::create([
			'name' => 'User',
			'email' => 'user@user.com',
			'password' => bcrypt('user'),
			'remember_token' => Str::random(10),
			'responsibilities' => '{}',
        ]);
		
		$admin->roles()->attach($adminRole);
		$sale->roles()->attach($saleRole);
		$support->roles()->attach($supportRole);
		$user->roles()->attach($userRole);
    }
}
