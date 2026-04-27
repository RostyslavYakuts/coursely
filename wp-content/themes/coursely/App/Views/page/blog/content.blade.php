{{-- Contacts Content --}}
@if($data['content'])
    <div class="container mx-auto flex flex-col prose-base pb-10">
        {!! $data['content'] !!}
    </div>
@endif