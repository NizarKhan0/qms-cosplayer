<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $users; // Property to hold users

    protected $listeners = ['userRegistered' => 'reloadUsers'];

    public function mount()
    {
        // Fetch users when the component mounts
        $this->reloadUsers();
    }

    public function reloadUsers()
    {
        $this->users = User::all();
    }

    //userId & role ni utk paarmeter action updaet role kat bawah ni
    public function updateRole($userId, $role)
    {
        // Find the user by ID
        $user = User::find($userId);

        if ($user) {
            // Update the user's role
            $user->role_id = $role;
            $user->save();

            // Send success notification
            session()->flash('success', 'Status updated successfully!');
        }

        // Reload the list of users
        $this->reloadUsers();
    }
}; ?>

<div wire:poll="reloadUsers">
    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <h5 class="card-header">List Users</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role_id === 1)
                                        <span class="badge bg-label-danger me-1">Super Admin</span>
                                    @elseif ($user->role_id === 2)
                                        <span class="badge bg-label-info me-1">Admin</span>
                                    @else
                                        <span class="badge bg-label-success me-1">Cosplayer</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <!-- Role Selection Dropdown -->
                                    <select wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                        class="browser-default">
                                        <option value="" disabled selected>Change Role</option>
                                        <option value="1" {{ $user->role_id === 1 ? 'selected' : '' }}>Super Admin
                                        </option>
                                        <option value="2" {{ $user->role_id === 2 ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="3" {{ $user->role_id === 3 ? 'selected' : '' }}>Cosplayer
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
