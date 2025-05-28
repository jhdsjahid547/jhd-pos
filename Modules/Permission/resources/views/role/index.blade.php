@extends('app')
@section('title', 'Roles & Permissions')
@section('item-title', 'Roles & Permissions')
@section('item-path')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
@endsection
@section('modal')
    <!-- Create Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('permission.roles.store') }}" method="post">
                    @csrf
                    <div class="row py-2 px-4">
                        <div class="col-md-2 pt-1"><label for="roleTitle">Title:</label></div>
                        <div class="col-md-10">
                            <input id="roleTitle" type="text" class="form-control" name="name" placeholder="Enter title/name">
                        </div>
                        <div class="col-md-12 pt-2">
                            <button type="submit" class="btn btn-sm btn-success float-end">Save</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm" action="#" method="post">
                        @method('put')
                        @csrf
                        <div class="row py-2 px-4">
                            <div class="col-md-2 pt-1"><label for="roleEditTitle">Title:</label></div>
                            <div class="col-md-10">
                                <input id="roleEditTitle" type="text" class="form-control" name="name" placeholder="Enter title/name">
                            </div>
                            <div class="col-md-12 pt-2">
                                <button type="submit" class="btn btn-sm btn-success float-end">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--delete form-->
    <form id="deleteForm" action="#" method="post">@method('delete') @csrf</form>
@endsection
@section('item')
    <section>
        <div class="row">
            <div class="col-md-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">All Role</h3>
                        @can('Create Role')
                        <button type="button" class="btn btn-sm btn-primary" onclick="openAddModal()">
                            <i class="bi bi-plus-lg"></i>&nbsp;Create Role
                        </button>
                        @endcan
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Title</th>
                            <th style="width: 150px" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('permission.roles.index') }}?id={{ $role->id }}" class="fw-bold text-decoration-none">{{ $role->name }}</a>
                            </td>
                            <td>
                                <div class="d-flex flex-row"></div>
                                @can('Edit Role')
                                <button type="button" class="btn btn-sm btn-primary" onclick="openEditModal({{ $role->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                @endcan
                                @can('Delete Role')
                                <button type="button" class="btn btn-sm btn-danger"  onclick="deleteRole({{ $role->id }})">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                            <td colspan="5">No data found</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-header pt-4">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">
                            @if($activeRole)
                                Permission For <span class="border border-warning rounded-3 px-1">{{ $activeRole->name }}</span>
                            @else
                                Select a <u>role</u> to view permissions
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form method="POST" action="{{ $activeRole ? route('permission.roles.update-permissions', $activeRole->id) : '#' }}">
                        @csrf
                        @if($activeRole)
                            @method('PUT')
                        @endif
                        <table class="table table-striped">
                        <tbody>
                        @if($activeRole)
                            {{--@foreach($permissionGroups as $module => $sections)
                                <tr>
                                    <td colspan="2" class="fw-bold bg-light">{{ $module }}</td>
                                </tr>
                                @foreach($sections as $section => $permissions)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="col-md-3 form-check mb-2">
                                                <!-- Add a class 'section-checkbox' and data-section attribute -->
                                                <input type="checkbox" class="form-check-input section-checkbox"
                                                       data-section="{{ $module }}-{{ $section }}" />
                                                <label class="form-check-label">{{ $section }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-md-3 form-check mb-2">
                                                        <input type="checkbox" class="form-check-input child-checkbox"
                                                               data-section="{{ $module }}-{{ $section }}"
                                                               id="permission-{{ $permission->id }}" />
                                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                            <span class="badge bg-primary me-1">{{ $permission->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach--}}
                            @foreach($permissionGroups as $module => $sections)
                                <tr>
                                    <td colspan="2" class="fw-bold bg-light">#&nbsp;{{ $module }} Module</td>
                                </tr>
                                @foreach($sections as $section => $permissions)
                                    @php
                                        // Check if all permissions in this section are assigned to the role
                                        $allChecked = true;
                                        foreach ($permissions as $permission) {
                                            if (!in_array($permission->id, $rolePermissions)) {
                                                $allChecked = false;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="ps-4" style="width: 150px">
                                            <div class="col-md-3 form-check mb-2">
                                                <input id="s{{ $section }}" type="checkbox" class="form-check-input section-checkbox"
                                                       data-section="{{ $module }}-{{ $section }}"
                                                    {{ $allChecked ? 'checked' : '' }} />
                                                <label class="form-check-label" for="s{{ $section }}">{{ $section }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-md-3 form-check mb-2">
                                                        <input type="checkbox" name="permissions[]"
                                                               class="form-check-input child-checkbox"
                                                               data-section="{{ $module }}-{{ $section }}"
                                                               value="{{ $permission->id }}"
                                                               id="permission-{{ $permission->id }}"
                                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                            <span class="badge bg-primary me-1">{{ $permission->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td class="text-muted">Select a role first.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                        @if (request()->has('id'))
                            @can('Assign Permission')
                            <button type="submit" class="btn btn-sm btn-primary float-end btn-success">Save Permissions</button>
                            @endcan
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        //for operations
        function openAddModal() {
            $('#addRoleModal').modal('show');
        }
        function openEditModal(id) {
            const roleName = $('#roleEditTitle');
            const editRoleForm = $('#editRoleForm');
            let getUrl = '{{ route('permission.roles.show', '__id__') }}';
            let actionUrl = '{{ route('permission.roles.update', '__id__') }}';
            getUrl = getUrl.replace('__id__', id);
            actionUrl = actionUrl.replace('__id__', id);
            $.get(getUrl, function(data) {
                editRoleForm.attr('action', actionUrl);
                roleName.val(data.name);
                $('#editRoleModal').modal('show');
            });
        }
        function deleteRole(id) {
            const deleteForm = $('#deleteForm');
            let deleteUrl = '{{ route('permission.roles.destroy', '__id__') }}';
            deleteUrl = deleteUrl.replace('__id__', id);
            deleteForm.attr('action', deleteUrl);
            if(confirm('Are you sure want to delete.')) {
                deleteForm.submit();
            }
        }
        // section for check uncheck of section items
        $(document).ready(function() {
            updateAllSectionStates();
            $('.section-checkbox').on('change', function() {
                const section = $(this).data('section');
                const isChecked = $(this).prop('checked');
                $(`.child-checkbox[data-section="${section}"]`)
                    .prop('checked', isChecked)
                    .trigger('change');
            });

            $('.child-checkbox').on('change', function() {
                const section = $(this).data('section');
                updateSectionState(section);
            });

            function updateSectionState(section) {
                const $children = $(`.child-checkbox[data-section="${section}"]`);
                const $sectionCheckbox = $(`.section-checkbox[data-section="${section}"]`);
                const checkedCount = $children.filter(':checked').length;
                $sectionCheckbox.prop('indeterminate', checkedCount > 0 && checkedCount < $children.length);
                $sectionCheckbox.prop('checked', checkedCount === $children.length);
            }

            function updateAllSectionStates() {
                $('.section-checkbox').each(function() {
                    updateSectionState($(this).data('section'));
                });
            }
        });
    </script>
@endpush
