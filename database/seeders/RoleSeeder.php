<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;

class RoleSeeder extends Seeder
{
	public function run(): void
	{
		// Users
		$roles = [
			'adopter',
			'breeder',
			'professionnal_breeder',
			'individual_breeder',
			'professionnal'
		];

		foreach($roles as $role) {
			$newRole = Role::create(['name' => $role, 'guard_name' => 'web']);
		}

		// Admins
		$rolesAdmin = [
			'admin',
			'support'
		];

		foreach($rolesAdmin as $role) {
			$newRole = Role::create(['name' => $role, 'guard_name' => 'admin']);
		}
	}
}