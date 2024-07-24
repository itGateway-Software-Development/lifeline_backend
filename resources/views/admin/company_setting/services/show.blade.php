@extends('layouts.app')
@section('title', 'Service Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-donate-heart' style="color: rgb(235, 92, 82);"></i>
        <div>{{ __('messages.services.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.services.title') }} Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>{{ __('messages.services.fields.service_title') }}</th>
                    <td>{{ $service->title }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.services.fields.content') }}</th>
                    <td>{!!  $service->content !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
