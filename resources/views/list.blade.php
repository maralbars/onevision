@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-primary text-white " role="alert">
            <span class="alert-text">{{ $error }}</span>
        </div>
        @endforeach
        @endif
        @if (session('status'))
        <div class="alert alert-success text-white " role="alert">
            <span class="alert-text">{{ session('status') }}</span>
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                {{-- ID, тема, сообщение, имя клиента, почта клиента, ссылка на прикрепленный файл,
                                время создания --}}
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Description</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author,
                                    Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Attachment</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Created at</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                    style="width: 220;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $feedback)
                            <tr>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $feedback->id }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $feedback->subject
                                        }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $feedback->description
                                        }}</span>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $feedback->user->name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $feedback->user->email }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    @if ($feedback->attachment_original_name)
                                    <span class="text-secondary text-xxs font-weight-bold">
                                        <a href="{{ route('feedback.download', $feedback->id) }}" class="text-nowrap overflow-hidden d-inline-block"
                                            style="width: 10rem; text-overflow: ellipsis;"
                                            title="{{$feedback->attachment_original_name }}"><i
                                                class="fas fa-download me-1"></i> {{$feedback->attachment_original_name
                                            }}</a></span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{
                                        $feedback->created_at->format('d.m.Y H:i:s')
                                        }}</span>
                                </td>
                                <td class="align-middle text-center p-3 text-wrap">
                                    @if ($feedback->answered_at)
                                    <span class="text-secondary text-xs font-weight-bold">Answered at {{
                                        $feedback->answered_at->format('d.m.Y H:i:s')
                                        }}</span>
                                    @else
                                    @can('change-feedback-status')
                                    <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="feedback_id" value="">
                                        <button class="btn-loading btn bg-gradient-success w-100">Is answered?</button>
                                    </form>
                                    @else
                                    <span class="text-secondary text-xs font-weight-bold">Not answered yet</span>
                                    @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $feedbacks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<script>
    const loadingBtns = document.querySelectorAll('button.btn-loading');
        loadingBtns.forEach(element => {
            element.addEventListener("click", () => {
            element.innerText = 'Loading...';
            element.disabled = true;
            element.closest('form').submit();
        });
        }); 
</script>
@endsection