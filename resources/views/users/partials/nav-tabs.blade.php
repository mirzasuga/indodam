<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('profile.show', __('user.summary'), [$user]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'members' ? 'active' : '' }}">
        {!! link_to_route('profile.members.index', __('user.members'), [$user]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'transactions' ? 'active' : '' }}">
        {!! link_to_route('profile.transactions.index', __('user.transactions'), [$user]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'withdraw' ? 'active' : '' }}">
        {!! link_to_route('withdraw.index', __('Withdraw'), [$user]) !!}
    </li>
    @can ('see-detail', $user)
        <li class="{{ Request::segment(3) == 'cloud-servers' ? 'active' : '' }}">
            {!! link_to_route('profile.cloud-servers.index', __('user.cloud_servers'), [$user]) !!}
        </li>
    @endif
</ul>
<br>
