{{-- Content --}}
@if($data['content'])
    <div class="container mx-auto w-full pt-[50px] pb-[100px] prose-base">
        {!! $data['content'] !!}
    </div>
@endif