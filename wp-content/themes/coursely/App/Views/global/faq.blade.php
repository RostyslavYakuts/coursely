{{-- Global FAQ --}}


@if($data['faq'])
    <div class="mt-[20px] faq-wrapper w-full flex flex-col items-center justify-center gap-6">
        @foreach($data['faq'] as $index => $faq_item)
            <div class="faq-section w-full flex flex-col gap-6">
                @if($faq_item['question'])
                    @php
                        $css_active = '';
                        if($index === 0){
                                $css_active = 'active';
                        }
                    @endphp
                    <div class="{{$css_active}} relative faq-block bg-white py-[24px] px-[20px] lgx:p-[32px] rounded-[20px] flex flex-col">
                        <div class="question question-js cursor-pointer flex justify-between items-center relative">
                            <div>
                                <b class="block pr-[70px] h3 text-lg l:text-[20px]">
                                    {{$faq_item['question']}}
                                </b>
                            </div>
                            <svg class="absolute top-0 right-0 l:relative faq-closed min-w-[30px] min-h-[30px] w-[30px] h-[30px]"  width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="15" fill="#DDE1E6"/>
                                <path d="M15 9V21" stroke="#020609" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 15H21" stroke="#020609" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg class="absolute top-0 right-0 l:relative faq-opened min-w-[30px] min-h-[30px] w-[30px] h-[30px]" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="30" height="30" rx="15" fill="#111230"/>
                                <path d="M9 21L21 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 21L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>


                        </div>
                        <div class="answer mt-3 lgx:text-text-lg text-brand-text pr-[50px]">
                            {!! $faq_item['answer'] !!}
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif