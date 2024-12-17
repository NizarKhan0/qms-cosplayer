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

    public function updateRole($userId, $role)
    {
        // Find the user by ID
        $user = User::find($userId);

        if ($user) {
            // Update the user's role
            $user->role_id = $role;
            $user->save();
        }

        // Reload the list of users
        $this->reloadUsers();
    }
}; ?>


<div wire:poll="reloadUsers" class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <table id="page-length-option" class="display">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role_id === 1)
                                        <span class="chip red white-text">Super Admin</span>
                                        @elseif ($user->role_id === 2)
                                        <span class="chip blue white-text">Admin</span>
                                        @else
                                        <span class="chip green white-text">Cosplayer</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <!-- Role Selection Dropdown -->
                                        <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="browser-default">
                                            <option value="" disabled selected>Change Role</option>
                                            <option value="1" {{ $user->role_id === 1 ? 'selected' : '' }}>Super Admin</option>
                                            <option value="2" {{ $user->role_id === 2 ? 'selected' : '' }}>Admin</option>
                                            <option value="3" {{ $user->role_id === 3 ? 'selected' : '' }}>Cosplayer</option>
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
    </div>
</div>

