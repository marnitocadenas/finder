<div class="user-form-module">
    <div class="user-form-hero">
        <div>
            <span class="module-eyebrow">Account setup</span>
            <h1>{{ $user->exists ? 'Edit User' : 'Create User' }}</h1>
            <p>{{ $user->exists ? 'Update profile details, role access, or set a new password.' : 'Create a new account and assign the right access level.' }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-light">
            <i class="fa-solid fa-arrow-left me-1"></i>Back to Users
        </a>
    </div>

    <form method="POST" action="{{ $action }}" class="user-form-card">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="user-form-section">
            <div>
                <h2>Profile Details</h2>
                <p>Keep the user identity clear for reports, claims, and activity logs.</p>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="user-name">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input id="user-name" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Full name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="user-email">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input id="user-email" class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="Email address" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="user-student-id">Student ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                        <input id="user-student-id" class="form-control" name="student_id" value="{{ old('student_id', $user->student_id) }}" placeholder="Optional for non-students">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="user-password">{{ $user->exists ? 'New Password' : 'Password' }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input id="user-password" class="form-control" name="password" type="password" placeholder="{{ $user->exists ? 'Leave blank to keep current password' : 'Minimum 8 characters' }}" @required(! $user->exists)>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-form-section">
            <div>
                <h2>Access Role</h2>
                <p>Choose the workspace this account should use after login.</p>
            </div>
            <div class="role-picker">
                @foreach(['admin' => 'fa-user-shield', 'staff' => 'fa-id-badge', 'student' => 'fa-graduation-cap'] as $role => $icon)
                    <label>
                        <input type="radio" name="role" value="{{ $role }}" @checked(old('role', $user->role ?: 'student') === $role)>
                        <span>
                            <i class="fa-solid {{ $icon }}"></i>
                            <strong>{{ Illuminate\Support\Str::title($role) }}</strong>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="user-form-actions">
            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Save User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
