@extends('layouts.app')
@section('title', 'Photo Gallery Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-user-check' style="color: rgb(157, 21, 161);"></i>
        <div>{{ __('messages.photo_gallery.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.photo_gallery.title') }} Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>{{ __('messages.photo_gallery.fields.date') }}</th>
                    <td>{{ $photo_gallery->date }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.photo_gallery.fields.photos') }}</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($photo_gallery->getMedia('photo_gallery') as $photo)
                                <img style="width: 100px; object-fit: cover;" src="{{$photo->getUrl()}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
