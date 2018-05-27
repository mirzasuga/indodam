<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('user.sponsors') }}</h3></div>
    <table class="table">
        <tbody>
            <tr>
                <td>{{ __('user.upline_level') }} 1</td>
                <td>
                    @php $level1 = $user->sponsor; @endphp
                    {{ optional($level1)->name }}
                </td>
            </tr>
            <tr>
                <td>{{ __('user.upline_level') }} 2</td>
                <td>
                    @php $level2 = $level1 ? $level1->sponsor : null; @endphp
                    {{ optional($level2)->name }}
                </td>
            </tr>
            {{-- <tr>
                <td>{{ __('app.level') }} 3</td>
                <td>
                    @php $level3 = $level2 ? $level2->sponsor : null; @endphp
                    {{ optional($level3)->name }}
                </td>
            </tr>
            <tr>
                <td>{{ __('app.level') }} 4</td>
                <td>
                    @php $level4 = $level3 ? $level3->sponsor : null; @endphp
                    {{ optional($level4)->name }}
                </td>
            </tr>
            <tr>
                <td>{{ __('app.level') }} 5</td>
                <td>
                    @php $level5 = $level4 ? $level4->sponsor : null; @endphp
                    {{ optional($level5)->name }}
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>
