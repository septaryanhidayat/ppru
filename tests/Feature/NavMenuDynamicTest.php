<?php

use App\Models\NavMenu;

test('changes in nav_menus table immediately reflect on home page navigation', function () {
    // 1. Initial home page contains canonical root menus
    $response = $this->get(route('home'));
    $response->assertStatus(200);
    $response->assertSee('Beranda');
    $response->assertSee('Profil');

    // 2. Add a new dynamic menu item at root level
    $customMenu = NavMenu::create([
        'name' => 'Menu Uji Coba Dinamis',
        'url' => '/menu-uji-coba',
        'icon' => 'fa-solid fa-flask',
        'location' => 'header',
        'order' => 99,
        'is_active' => true,
    ]);

    $responseAfterCreate = $this->get(route('home'));
    $responseAfterCreate->assertStatus(200);
    $responseAfterCreate->assertSee('Menu Uji Coba Dinamis');
    $responseAfterCreate->assertSee('/menu-uji-coba');

    // 3. Update the menu item name
    $customMenu->update([
        'name' => 'Menu Terupdate Berhasil',
        'url' => '/menu-terupdate',
    ]);

    $responseAfterUpdate = $this->get(route('home'));
    $responseAfterUpdate->assertStatus(200);
    $responseAfterUpdate->assertSee('Menu Terupdate Berhasil');
    $responseAfterUpdate->assertSee('/menu-terupdate');
    $responseAfterUpdate->assertDontSee('Menu Uji Coba Dinamis');

    // 4. Update child item under Profil
    $profil = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Profil')->first();
    expect($profil)->not->toBeNull();

    $childItem = NavMenu::create([
        'parent_id' => $profil->id,
        'name' => 'Submenu Khusus Santri Baru',
        'url' => '/khusus-santri',
        'icon' => 'fa-solid fa-star',
        'location' => 'header',
        'order' => 50,
        'is_active' => true,
    ]);

    $responseChild = $this->get(route('home'));
    $responseChild->assertStatus(200);
    $responseChild->assertSee('Submenu Khusus Santri Baru');

    // 5. Deactivating child item hides it from navigation
    $childItem->update(['is_active' => false]);
    $responseDeactivated = $this->get(route('home'));
    $responseDeactivated->assertDontSee('Submenu Khusus Santri Baru');

    // Clean up test items
    $childItem->delete();
    $customMenu->delete();
});
