{{-- Content --}}
@if($data['content'])
    <div class="container w-full pt-[50px] pb-[100px] prose-base">
        {!! $data['content'] !!}
    </div>
@endif