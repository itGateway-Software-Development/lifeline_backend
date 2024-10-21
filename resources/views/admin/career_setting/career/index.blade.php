@extends('layouts.app')
@section('title', 'Career')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-briefcase-alt-2' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.careers.title') }}</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.careers.title') }} List</span>

            <a href="{{ route('admin.careers.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                    class='bx bxs-plus-circle me-2'></i>
                Create New {{ __('messages.careers.title') }}</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>{{ __('messages.careers.fields.position') }}</th>
                    <th>{{ __('messages.careers.fields.department') }}</th>
                    <th>{{ __('messages.careers.fields.location') }}</th>
                    <th>{{ __('messages.careers.fields.posts') }}</th>
                    <th>{{ __('messages.careers.fields.careers_title') }}</th>
                    <th>{{ __('messages.careers.fields.requirements') }}</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            //datatable
            const table = new DataTable('#DataTable', {
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '/admin/career-setting/careers-list',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon'
                    },
                    {
                        data: 'position_id',
                        name: 'position_id'
                    },
                    {
                        data: 'department_id',
                        name: 'department_id'
                    },
                    {
                        data: 'location_id',
                        name: 'location_id'
                    },
                    {
                        data: 'posts',
                        name: 'posts'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'requirements',
                        name: 'requirements'
                    },
                    {
                        data: 'action',
                        data: 'action',
                    }
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    sortable: false,
                    searchable: false
                }, {
                    targets: [0],
                    class: 'control'
                }]
            })

            //delete function
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure to delete ?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/career-setting/careers/" + id,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                console.log(res);
                                table.ajax.reload();
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
