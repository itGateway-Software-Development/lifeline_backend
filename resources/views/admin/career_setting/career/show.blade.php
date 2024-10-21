@extends('layouts.app')
@section('title', 'Career Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-briefcase-alt-2' style="color: rgb(16, 184, 10);"></i>
        <div>{{ __('messages.careers.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.careers.title') }} Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>{{ __('messages.careers.fields.position') }}</th>
                    <td>{{ $career->position->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.careers.fields.department') }}</th>
                    <td>{{ $career->department->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.careers.fields.location') }}</th>
                    <td>{{ $career->location->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.careers.fields.posts') }}</th>
                    <td>{{ $career->posts }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.careers.fields.careers_title') }}</th>
                    <td>{{ $career->title }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.careers.fields.requirements') }}</th>
                    <td>{!!  $career->requirements !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
