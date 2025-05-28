@extends('app')
@section('title', 'Employee')
@section('item-title', 'Employee')
@section('item-path')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
@endsection
@section('modal')
    <!-- Create Modal -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="assignRole" action="#" method="post">
                        @method('put')
                        @csrf
                        <div class="row py-2 px-4">
                                @forelse($roles as $role)
                                <div class="col-md-3 form-check mb-2">
                                    <input type="checkbox" name="roles[]"
                                           class="form-check-input role-checkbox"
                                           value="{{ $role->name }}"
                                           id="role-{{ $role->id }}"
                                           data-role-id="{{ $role->id }}"
                                         />
                                    <label class="form-check-label" for="role-{{ $role->id }}">
                                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                    </label>
                                </div>
                                @empty
                                    <span>No role found.</span>
                                @endforelse
                            <div class="col-md-12 pt-2">
                                <button type="submit" class="btn btn-sm btn-success float-end">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('item')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Employee List</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between p-2">
                            <x-per-page-selector />
                            <x-search column="name" />
                        </div>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Branch</th>
                                <th>Role</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($employees as $employee)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}
                                    @if($loop->first)
                                        <span class="badge rounded-pill text-bg-info">You</span>
                                    @endif
                                </td>
                                <td>{{ $employee->email }}</td>
                                <td>N/A</td>
                                <td>
                                    @forelse($employee?->roles as $role)
                                        <span class="badge bg-dark me-1">{{ $role->name }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" value="" id="checkNativeSwitch" switch>
                                        <label class="form-check-label" for="checkNativeSwitch">
                                            Active
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-dark" data-bs-toggle="tooltip" data-bs-title="Assign Permission" onclick="openAssignRoleModal({{ $employee->id }})">
                                        <i class="bi bi-person-fill-lock"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-title="Assign Branch">
                                        <i class="bi bi-shop"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Not found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="py-2 px-4"><x-pagination :paginator="$employees"/></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        // assign role to employee modal logic
        function openAssignRoleModal(id) {
            $('.role-checkbox').prop('checked', false);
            const assignRoleForm = $('#assignRole');
            let getUserRole = '{{ route('permission.employees.show', '__id__') }}';
            let assignRole = '{{ route('permission.employees.update', '__id__') }}';
            getUserRole = getUserRole.replace('__id__', id);
            assignRole = assignRole.replace('__id__', id);
            assignRoleForm.attr('action', assignRole);
            $.get(getUserRole, function(data) {
                $('.role-checkbox').each(function() {
                    const roleId = parseInt($(this).data('role-id'));
                    if (data.includes(roleId)) {
                        $(this).prop('checked', true);
                    }
                });
            });
            $('#assignRoleModal').modal('show');
        }
    </script>
@endpush
