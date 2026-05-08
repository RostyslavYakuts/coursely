{{-- Account Subscription --}}
<div class="account-tabs-content-item subscription min-h-[626px]">
    <h2 class="leading-0 font-bold text-[20px] lgx:text-[32px] flex items-center gap-2">
        <button class="mobile-to-tabs-js lgx:hidden">
            <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.16667 1L1 5.375L5.16667 9.75M1 5.375H11" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        {{__('Subscription & Payments','coursely')}}
    </h2>
    <div class="border border-gray rounded-[8px] p-4 mt-8">
        <span class="text-lg text-brand-text">{{__('Current plan','coursely')}}:</span>
        <div class="mt-2 flex flex-row gap-2 text-[20px]">
            <b class="">{{$data['active_subscription']['plan_name']}}</b>
            <span class="text-brand">(${{$data['active_subscription_price']}})</span>
        </div>
        <div class="flex flex-col gap-8 md:flex-row md:justify-between md:items-center mt-2">
                          <span class="w-full text-lg text-brand-text">
                                {{__('Next payment','coursely')}} {{$data['next_payment'] }}
                          </span>
            <a href="{{$data['activate_subscription_link']}}" class="min-w-[250px] bg-white flex justify-center items-center gap-2 p-3 rounded-full border border-brand-gray text-lg hover:text-white hover:bg-brand-dark brand-btn-light">
                {{__('Manage subscription','coursely')}}
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1667 18L19 12L13.1667 6M19 12L5 12" stroke="#111230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

    </div>

    <div class="invoices hidden lgx:block mt-8 text-sm">

        <!-- header -->
        <div class="bg-gray rounded-[8px] grid grid-cols-5 bg-gray-100 text-sm font-medium">
            <div class="p-3 flex items-center gap-2 ">
                Invoice ID
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 0.5V9.83333M0.5 5.16667L5.16667 9.83333L9.83333 5.16667" stroke="#111230" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="p-3 flex items-center gap-2">
                Billing Date
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 0.5V9.83333M0.5 5.16667L5.16667 9.83333L9.83333 5.16667" stroke="#111230" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="p-3 flex items-center gap-2">
                Status
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 0.5V9.83333M0.5 5.16667L5.16667 9.83333L9.83333 5.16667" stroke="#111230" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="p-3 flex items-center gap-2">
                Amount
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 0.5V9.83333M0.5 5.16667L5.16667 9.83333L9.83333 5.16667" stroke="#111230" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="p-3 flex items-center gap-2">
                Plan
                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 0.5V9.83333M0.5 5.16667L5.16667 9.83333L9.83333 5.16667" stroke="#111230" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- row -->
        @if($data['invoices'])
            @foreach($data['invoices'] as $invoice)
                <div class="invoice grid grid-cols-5 text-sm">
                    <div class="p-3">{{$invoice['stripe_invoice_id']}}</div>
                    <div class="p-3">
                        @php
                            $created_date = new \DateTime($invoice['created_at']);
                        @endphp
                        {{ $created_date->format('F j, Y') }}
                    </div>
                    <div class="p-3">
                                    <span class="invoice-status {{$invoice['status']}}">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill=""/>
                                        </svg>
                                        {{ ucfirst($invoice['status'])}}
                                    </span>
                    </div>
                    <div class="p-3">${{$invoice['total']}}</div>
                    <div class="p-3">{{$invoice['plan_name']}}</div>
                </div>
            @endforeach
        @endif


    </div>
    <div class="invoices flex flex-col lgx:hidden">
        @if($data['invoices'])
            @foreach($data['invoices'] as $invoice)
                <div class="invoice flex flex-col gap-2 text-sm">
                    <div class="p-2 flex justify-between items-center">
                        <span>Invoice</span>
                        <span>{{$invoice['stripe_invoice_id']}}</span>
                    </div>
                    <div class="p-2 flex justify-between items-center">
                        <span>Billing Date</span>
                        @php
                            $created_date = new \DateTime($invoice['created_at']);
                        @endphp
                        <span> {{ $created_date->format('F j, Y') }}</span>
                    </div>
                    <div class="p-2 flex justify-between items-center">
                        <span>Status</span>
                        <span class="invoice-status {{$invoice['status']}}">
                                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill=""/>
                                        </svg>
                                        {{ ucfirst($invoice['status'])}}
                                    </span>
                    </div>
                    <div class="p-2 flex justify-between items-center">
                        <span>Amount</span>
                        <span>${{$invoice['total']}}</span>
                    </div>
                    <div class="p-2 flex justify-between items-center">
                        <span>Plan</span>
                        <span>{{$invoice['plan_name']}}</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>

