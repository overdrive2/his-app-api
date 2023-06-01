<div>
    <table class="dark:text-gray-200 w-full overflow-x-auto">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = ($rows->currentPage()-1) * $rows->perPage() +1;
            @endphp
            @foreach($rows as $key => $row)
            <tr class="border-b">
                <td class="p-2">{{ $key + 1 }}</td>
                <td class="p-2">{{ $row->name }}</td>
                <td class="p-2">{{ $row->email }}</td>
                <td class="p-2">{!! $row->is_admin ? 'Admin' : 'User' !!}</td>
                <td class="p-2">
                    <x-button.link :href="route('admin.user-profile', 'uid='.$row->id)">Profile</x-button.link>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
