<div>
    <!-- Breadcrumb -->
    <x-breadcrumb.nav>
        <x-breadcrumb.li href="{{ route('dashboard') }}">
            <x-icon.home />
            Admin
        </x-breadcrumb.li>
        <x-breadcrumb.li href="#">
            <x-icon.next />
            Users
        </x-breadcrumb.li>
        <x-breadcrumb.li-active>
            Profile
        </x-breadcrumb.li-active>
    </x-breadcrumb.nav>
    <div class="text-left py-2 px-2">
        <h2>
            {{ $user->name }}
        </h2>
        <div>
            @livewire('admin.user-wards', ['uid' => $uid], key('uid-'.$uid))
        </div>
    </div>
</div>
