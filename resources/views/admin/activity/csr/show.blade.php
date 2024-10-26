@extends('layouts.app')
@section('title', 'CSR Activities Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-spa' style="color: rgb(62, 136, 62);"></></i>
        <div>{{ __('messages.csr.title') }} Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>{{ __('messages.csr.title') }} Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>{{ __('messages.csr.fields.title') }}</th>
                    <td>{{ $csrActivity->title }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.csr.fields.date') }}</th>
                    <td>{{ $csrActivity->date }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.csr.fields.content') }}</th>
                    <td>{{ $csrActivity->content }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.csr.fields.photos') }}</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($csrActivity->getMedia('csr') as $photo)
                                <img style="width: 120px; object-fit: cover;" src="{{$photo->getUrl()}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>{{ __('messages.csr.fields.videos') }}</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($csrActivity->csrVideos as $video)
                                <div class="video-container">
                                    <video width="200" controls>
                                        <source src="{{ Storage::url($video->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
