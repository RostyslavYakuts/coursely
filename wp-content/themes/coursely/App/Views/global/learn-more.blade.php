{{-- Learn More --}}
@php
    /**
    * @var $data
    */
    $button_text = $data['button_title'] ?? 'Dowiedz się więcej';
    $button_text = $button_text ?: 'Dowiedz się więcej';
    $extra_classes = $data['tw_classes'] ?? '';
    $class = 'class="learn-more mt-4 btn flex gap-3
    items-center bg-white hover:text-brand-header text-lg text-brand ' . $extra_classes . '"';
    $tag = $data['button_tag'] ?? 'a';
    $href = $data['button_link'] ?? '#';
    $href_attr = 'href="'.$href.'"';
    if($tag !== 'a'){
        $href_attr = '';
    }
@endphp

<{{$tag}} {!! $href_attr !!} {!! $class !!}>
    {!! $button_text !!}
    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.16667 1L15 7M15 7L9.16667 13M15 7L1 7" stroke="#009CFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</{{$tag}}>