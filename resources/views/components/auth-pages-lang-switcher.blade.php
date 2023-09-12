@push('styles')
    <style>
        .btn-lang {
            width: 100px;
            background-color: #5437C3;
            border-radius:  unset
        }
    </style>
@endpush
<div class="col-12 mx-auto pb-3">
    <a href="{{ route('changeLang', ['lang' => 'en']) }}" class="btn btn-info {{ session()->get('locale') == 'en' ? 'active' : '' }} mr-2 btn-lang" aria-current="page">English</a>
    <a href="{{ route('changeLang', ['lang' => 'ar']) }}" class="btn btn-info {{ session()->get('locale') == 'ar' ? 'active' : '' }} mr-2 btn-lang">العربية</a>
    <a href="{{ route('changeLang', ['lang' => 'ur']) }}" class="btn btn-info {{ session()->get('locale') == 'ur' ? 'active' : '' }} btn-lang">اردو</a>
</div>
