import * as $ from 'jquery';

export const accountTabs = ()=>{
    const $accountTab = $('.account-tab-js');
    const $tabContentItem = $('.account-tabs-content-item');
    const $accountTabsContent = $('.account-tabs-content');
    const isMobile = window.matchMedia('(max-width: 1199px)').matches;
    const $toTabBtn = $('.mobile-to-tabs-js');


    $accountTab.on('click',function(){
        const dataTab = $(this).data('tab');
        if(!isMobile){
            $accountTab.removeClass('active');
            $tabContentItem.removeClass('active');
            $('.'+dataTab).addClass('active');
            $(this).addClass('active');
        }else{
            $accountTabsContent.removeClass('hidden');
            $tabContentItem.removeClass('mobile-active');
            $('.'+dataTab).addClass('mobile-active');
        }
    });


    $toTabBtn.on('click',function (){
        if(isMobile){
            $tabContentItem.removeClass('mobile-active');
            $accountTabsContent.addClass('hidden');
        }
    });




}