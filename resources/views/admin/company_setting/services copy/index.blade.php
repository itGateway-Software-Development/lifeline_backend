@extends('layouts.app')
@section('title', 'Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-gift' style="color: rgb(78, 161, 57);" ></i>
        <div>{{ __('messages.promotions.title') }}</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.promotions.title') }} List</span>
            @can('user_create')
                <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New {{ __('messages.promotions.title') }}</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>{{ __('messages.promotions.fields.title') }}</th>
                    <th>{{ __('messages.promotions.fields.main_img') }}</th>
                    <th>{{ __('messages.promotions.fields.info_img') }}</th>
                    <th>{{ __('messages.promotions.fields.content') }}</th>
                    <th class="no-sort">{{ __('messages.promotions.fields.status') }}</th>
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
                ajax: '/admin/company-setting/promotions-list',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'main_img',
                        name: 'titmain_imgle'
                    },
                    {
                        data: 'info_img',
                        name: 'info_img'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'status',
                        name: 'status'
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

            //toggle status
            $(document).on('click', '.promotion-status', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');
                Swal.fire({
                    title: 'Are you sure ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/company-setting/change-promotions-status",
                            data: {id, status},
                            type: "GET",
                            success: function(res) {
                                if(res == 'success') {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                    })
                                    Toast.fire({
                                        icon: 'success',
                                        title: "Success !"
                                    })
                                    table.ajax.reload();
                                }
                            }
                        })
                    }
                })
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
                            url: "/admin/company-setting/promotions/" + id,
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
