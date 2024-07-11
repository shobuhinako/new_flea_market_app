@component('mail::message')
# お知らせ

{{ $message }}

@component('mail::button', ['url' => route('index')])
    coachtech フリマ
@endcomponent

Thanks,<br>
coachtech フリマ
@endcomponent