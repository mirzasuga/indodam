<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
        {{ __('nav_menu.admin_area') }} <span class="caret"></span>
    </a>

    <ul class="dropdown-menu">
        <li>{{ link_to_route('packages.index', __('package.list')) }}</li>
        <li>{{ link_to_route('options.page-1', __('option.sponsor_bonus_setting')) }}</li>
        <li>{{ link_to_route('backups.index', __('backup.index_title')) }}</li>
    </ul>
</li>
