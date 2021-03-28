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
		$superadminRole = Role::where('name', 'superadmin')->first();
		$saleRole = Role::where('name', 'sale')->first();
		$supportRole = Role::where('name', 'support')->first();
		$userRole = Role::where('name', 'user')->first();
		
		$admin = User::create([
			'name' => 'Admin',
			'surname' => 'Admin',
			'email' => 'admin@admin.com',
			'active' => 1,
			'calendar' => 0,
			'password' => bcrypt('admin'),
			'remember_token' => Str::random(10),
        ]);
		
		$sale = User::create([
			'name' => 'Sale',
			'surname' => 'Sale',
			'active' => 1,
			'calendar' => 0,
			'email' => 'sale@sale.com',
			'password' => bcrypt('sale'),
			'remember_token' => Str::random(10),
        ]);
		
		$support = User::create([
			'name' => 'Support',
			'surname' => 'Support',
			'active' => 1,
			'calendar' => 0,
			'email' => 'support@support.com',
			'password' => bcrypt('support'),
			'remember_token' => Str::random(10),
        ]);
		
		$user = User::create([
			'name' => 'User',
			'surname' => 'User',
			'active' => 1,
			'calendar' => 0,
			'email' => 'user@user.com',
			'password' => bcrypt('user'),
			'remember_token' => Str::random(10),
        ]);
		
		$admin->roles()->attach($adminRole);
		$admin->roles()->attach($superadminRole);
		$sale->roles()->attach($saleRole);
		$support->roles()->attach($supportRole);
		$user->roles()->attach($userRole);
    }
}
