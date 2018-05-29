@can('update', $user)
    {{ link_to_route('users.edit', __('user.edit'), [$user], ['class' => 'btn btn-warning', 'id' => 'edit-user-'.$user->id]) }}
    @if ($user->is_active)
        {!! FormField::formButton(
            [
                'route' => ['users.suspend', $user],
                'onsubmit' => __('user.suspend_confirm'),
                'method' => 'delete',
            ],
            __('user.suspend'),
            [
                'class' => 'btn btn-danger',
                'id' => 'suspend-user',
            ],
            [
                'user_id' => $user->id,
                'action' => 'suspend',
            ]
        ) !!}
    @else
        {!! FormField::formButton(
            [
                'route' => ['users.activate', $user],
                'onsubmit' => __('user.activate_confirm'),
                'method' => 'patch',
            ],
            __('user.activate'),
            [
                'class' => 'btn btn-success',
                'id' => 'activate-user',
            ],
            [
                'user_id' => $user->id,
                'action' => 'activate',
            ]
        ) !!}
    @endif
@endcan

@can('should-upgrade', $user)

    {{ 
        link_to_route(
            'profile.members.create',
            __('member.upgrade'),
            [$user],
            ['class' => 'btn btn-danger', 'id' => 'add-member-'.$user->id ]
        )
    }}
    
@endcan