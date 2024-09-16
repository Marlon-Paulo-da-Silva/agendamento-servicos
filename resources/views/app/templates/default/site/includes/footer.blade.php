@if($website->logo)
        <div class="text-center mt-5">
                <a href="/" title="Home"><img src="/images/logos/{{$website->logo}}" class="mb-5" width="200"></a>
        </div>
        @endif
            <div class="text-center mt-5 mb-5">
                @if($info->company){{$info->company}}<br>@endif
                @if($info->address){{$info->address}}<br>@endif
                @if($info->zip){{$info->zip}}@endif @if($info->city){{$info->city}}<br><br>@endif
                @if($info->site_email)<a href="mailto:{{$info->site_email}}">{{$info->site_email}}</a><br>@endif
                @if($info->site_phone){{$info->site_phone}}@endif
            </div>

            <ul class="text-center social">
            @if($website->facebook)
            <li>
                <a href="{{$website->facebook}}" target="_blank" class="fb"><img height="16" width="16" src="/images/app/templates/default/app/facebook.svg"></a>
            </li>
            @endif
            @if($website->twitter)
            <li>
                <a href="{{$website->twitter}}" target="_blank" class="tw"><img height="16" width="16" src="/images/app/templates/default/app/twitter.svg"></a>
            </li>
            @endif
            @if($website->instagram)
            <li>
                <a href="{{$website->instagram}}" target="_blank" class="ins"><img height="16" width="16" src="/images/app/templates/default/app/instagram.svg"></a>
            </li>
            @endif
          </ul>

        <div class="text-center py-5 mb-5 run">Powered By <a href="https://codeland.fun">codeland.fun</a> © {{date('Y')}}</div>

