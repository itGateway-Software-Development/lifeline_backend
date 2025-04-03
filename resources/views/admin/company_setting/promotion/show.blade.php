@extends('layouts.app')
@section('title', 'Promotion Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-gift' style="color: rgb(78, 161, 57);" ></i>
        <div>{{ __('messages.promotions.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.promotions.title') }} Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>{{ __('messages.promotions.fields.promotion_title') }}</th>
                    <td>{{ $promotion->title }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.promotions.fields.content') }}</th>
                    <td>{!!  $promotion->content !!}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.promotions.fields.main_img') }}</th>
                    <td>
                        <img width="150" src="{{url('storage/images/'.$promotion->main_img)}}" alt="">
                    </td>
                </tr>
                <tr>
                    <th>{{ __('messages.promotions.fields.info_img') }}</th>
                    <td>
                        <div class="d-flex align-items-center gap-4 overflow-x-scroll">
                            @foreach ($promotion->getMedia('promotion_images') as $image)
                                <img src="{{ $image->getUrl() }}" alt="" width="200">
                            @endforeach
                        </div>
                    </td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
