@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        @can('leave-feedback', $latestFeedback)
        <div class="card mb-4">
            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    name="subject" value="{{ old('subject') }}" id="subject"
                                    placeholder="I have a qustion about...">
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    name="description" id="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="attachment" class="form-label" name="attachment">Add attachment</label>
                            <input class="form-control @error('attachment') is-invalid @enderror" name="attachment"
                                type="file" id="file">
                            @error('attachment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Leave feedback</button>
                </div>
            </form>
        </div>
        @else
        <div class="card mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">You already have left feedback!</h5>
                <p>You can write a new feedback {{ $latestFeedback->timeLeft }}.</p>
            </div>
        </div>
        @endcan
    </div>
</div>
<script>

</script>
@endsection