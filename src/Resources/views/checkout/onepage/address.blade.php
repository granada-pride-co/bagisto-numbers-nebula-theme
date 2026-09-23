{!! view_render_event('bagisto.shop.checkout.onepage.address.before') !!}

<div class="bg-white border border-[#2e2224] p-6 md:p-8 transition-all">
    <div class="flex items-center justify-between pb-5 mb-6 border-b border-[#2e2224]/15">
        <div class="flex items-center gap-3">
            <span class="inline-block font-mono text-[10px] uppercase tracking-widest text-[#2e2224] font-bold px-2.5 py-0.5 bg-[#f7b7ba] border border-[#2e2224]">
                STEP 01
            </span>
            <h2 class="font-serif font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide">
                @lang('shop::app.checkout.onepage.address.title')
            </h2>
        </div>
    </div>

    <div>
        <template v-if="cart.is_guest">
            @include('shop::checkout.onepage.address.guest')
        </template>

        <template v-else>
            @include('shop::checkout.onepage.address.customer')
        </template>
    </div>
</div>

{!! view_render_event('bagisto.shop.checkout.onepage.address.after') !!}
