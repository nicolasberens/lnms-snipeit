@if($found == true)
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-condensed device-overview">
            <div class="panel-heading">
                <strong>{{ $title }}</strong>
            </div>
            <div class="panel-body">
                @foreach ($data as $device)
                <div class="row">
                    <div class="col-sm-12">
                        <a href="https://{{ $api_host }}/hardware/{{ $device['id'] }}">{{ $device['asset_tag'] }}</a>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    </div>
</div>
@endif
