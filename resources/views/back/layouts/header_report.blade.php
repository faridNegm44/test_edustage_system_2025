<div class="row">
    <div class="col-xs-6 text-left">
        <div style="padding-top: 10px;">
            {{ date('d-m-Y') }} <span style="font-size: 16px;font-weight: bold;">{{ date('h:i a') }}</span>
            <div>{{ auth()->user()->name  }}</div>
        </div>
    </div>
    <div class="col-xs-6 text-right">
        <img src="{{ asset('back/images/settings/logo.png') }}" alt="" style="width: 80px;height: 70px;margin-top: -12px;margin-bottom: 10px;">
    </div>
</div>