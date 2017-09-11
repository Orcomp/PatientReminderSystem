@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            @can('appointment_access')
                <li class="{{ $request->segment(2) == 'appointments' ? 'active' : '' }}">
                    <a href="{{ route('admin.appointments.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">@lang('global.appointments.title')</span>
                    </a>
                </li>
            @endcan

            @can('patient_access')
                <li class="{{ $request->segment(2) == 'patients' ? 'active' : '' }}">
                    <a href="{{ route('admin.patients.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">@lang('global.patients.title')</span>
                    </a>
                </li>
            @endcan

            @can('user_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('global.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('permission_access')
                <li class="{{ $request->segment(2) == 'permissions' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.permissions.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.permissions.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('role_access')
                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.roles.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('global.users.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('user_action_access')
                <li class="{{ $request->segment(2) == 'user_actions' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.user_actions.index') }}">
                            <i class="fa fa-th-list"></i>
                            <span class="title">
                                @lang('global.user-actions.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            @can('setting_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span class="title">@lang('global.settings.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('contact_type_access')
                <li class="{{ $request->segment(2) == 'contact_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.contact_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.contact-types.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('designation_type_access')
                <li class="{{ $request->segment(2) == 'designation_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.designation_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.designation-types.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('address_type_access')
                <li class="{{ $request->segment(2) == 'address_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.address_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.address-types.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('country_access')
                <li class="{{ $request->segment(2) == 'countries' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.countries.index') }}">
                            <i class="fa fa-flag"></i>
                            <span class="title">
                                @lang('global.countries.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('state_access')
                <li class="{{ $request->segment(2) == 'states' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.states.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.states.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('city_access')
                <li class="{{ $request->segment(2) == 'cities' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.cities.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.cities.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('diagnoses_type_access')
                <li class="{{ $request->segment(2) == 'diagnoses_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.diagnoses_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.diagnoses-types.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('treatment_type_access')
                <li class="{{ $request->segment(2) == 'treatment_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.treatment_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.treatment-types.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('treatment_stage_access')
                <li class="{{ $request->segment(2) == 'treatment_stages' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.treatment_stages.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.treatment-stages.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('reschedule_reason_access')
                <li class="{{ $request->segment(2) == 'reschedule_reasons' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.reschedule_reasons.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                                @lang('global.reschedule-reasons.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('appointment_type_access')
                    <li class="{{ $request->segment(2) == 'appointment_types' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.appointment_types.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                            @lang('global.appointment-types.title')
                        </span>
                        </a>
                    </li>
                @endcan
                @can('settings_access')
                    <li class="{{ $request->segment(2) == 'settings' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.settings.index') }}">
                            <i class="fa fa-gears"></i>
                            <span class="title">
                            @lang('global.settings.title')
                        </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('auth.change_password') }}">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('global.app_change_password')</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('global.app_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
