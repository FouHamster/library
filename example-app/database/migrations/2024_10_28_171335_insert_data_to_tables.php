<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $modelRoleAdmin = new \App\Models\Role();
        $modelRoleAdmin->title = 'Admin';
        $modelRoleAdmin->save();

        $modelRoleUser = new \App\Models\Role();
        $modelRoleUser->title = 'User';
        $modelRoleUser->save();

        $admin = new \App\Models\User();
        $admin->name = 'Admin';
        $admin->surname = 'Admin';
        $admin->login = 'Admin';
        $admin->password = 'Admin';
        $admin->role_id = $modelRoleAdmin->id;
        $admin->phone = 0;
        $admin->save();

        $user = new \App\Models\User();
        $user->name = 'User';
        $user->surname = 'User';
        $user->login = 'User';
        $user->password = 'User';
        $user->role_id = $modelRoleUser->id;
        $user->phone = 0;
        $user->save();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
