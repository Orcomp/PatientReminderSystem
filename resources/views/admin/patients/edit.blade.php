@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.patients.title')</h3>

    {!! Form::model($patient, ['method' => 'PUT', 'route' => ['admin.patients.update', $patient->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('first_name', trans('global.patients.fields.first-name'), ['class' => 'control-label required']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('first_name'))
                        <p class="help-block">
                            {{ $errors->first('first_name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('last_name', trans('global.patients.fields.last-name'), ['class' => 'control-label required']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('last_name'))
                        <p class="help-block">
                            {{ $errors->first('last_name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('gender', trans('global.patients.fields.gender'), ['class' => 'control-label required']) !!}
                    {!! Form::select('gender', $enum_gender, old('gender'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('gender'))
                        <p class="help-block">
                            {{ $errors->first('gender') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('birth_date', trans('global.patients.fields.birth-date'), ['class' => 'control-label']) !!}
                    {!! Form::text('birth_date', old('birth_date'), ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('birth_date'))
                        <p class="help-block">
                            {{ $errors->first('birth_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('schooled', trans('global.patients.fields.schooled'), ['class' => 'control-label']) !!}
                    {!! Form::hidden('schooled', 0) !!}
                    {!! Form::checkbox('schooled', 1, old('schooled'), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('schooled'))
                        <p class="help-block">
                            {{ $errors->first('schooled') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('notes', trans('global.patients.fields.notes'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('notes', old('notes'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('notes'))
                        <p class="help-block">
                            {{ $errors->first('notes') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- contacts begin --}}
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-contacts">
                <div class="panel-heading">
                    @lang('global.contacts.title')
                </div>

                <div class="panel-body">
                    @foreach($contacts as $idx => $contact)
                        <div class="box box-success with-border">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][first_name]', trans('global.contacts.fields.first-name'), ['class' => 'control-label required']) !!}
                                        {!! Form::text('contact[' . $idx . '][first_name]', $contact->first_name, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][last_name]', trans('global.contacts.fields.last-name'), ['class' => 'control-label required']) !!}
                                        {!! Form::text('contact[' . $idx . '][last_name]', $contact->last_name, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][mobile_number]', trans('global.contacts.fields.mobile-number'), ['class' => 'control-label']) !!}
                                        {!! Form::text('contact[' . $idx . '][mobile_number]', $contact->mobile_number, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][phone_number]', trans('global.contacts.fields.phone-number'), ['class' => 'control-label']) !!}
                                        {!! Form::text('contact[' . $idx . '][phone_number]', $contact->phone_number, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][email]', trans('global.contacts.fields.email'), ['class' => 'control-label']) !!}
                                        {!! Form::email('contact[' . $idx . '][email]', $contact->email, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][contact_type_id]', trans('global.contacts.fields.contact-type'), ['class' => 'control-label']) !!}
                                        {!! Form::select('contact[' . $idx . '][contact_type_id]', $contact_types, $contact->contact_type_id, ['class' => 'form-control select2']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][designation_type_id]', trans('global.contacts.fields.designation-type'), ['class' => 'control-label']) !!}
                                        {!! Form::select('contact[' . $idx . '][designation_type_id]', $designation_types, $contact->designation_type_id, ['class' => 'form-control select2']) !!}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {!! Form::label('contact[' . $idx . '][is_primary]', trans('global.contacts.fields.is-primary'), ['class' => 'control-label']) !!}
                                        {!! Form::hidden('contact[' . $idx . '][is_primary]', 0) !!}
                                        {!! Form::checkbox('contact[' . $idx . '][is_primary]', 1, $contact->is_primary, []) !!}
                                    </div>
                                    {!! Form::hidden('contact[' . $idx . '][id]', $contact->id) !!}
                                </div>
                                @foreach($contact->addresses as $jdx => $address)
                                    <div class="box box-primary with-border">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][address_type_id]', trans('global.addresses.fields.address-type'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('contact[' . $idx . '][address][' . $jdx . '][address_type_id]', $address_types, $address->address_type_id, ['class' => 'form-control select2']) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][street]', trans('global.addresses.fields.street'), ['class' => 'control-label']) !!}
                                                    {!! Form::text('contact[' . $idx . '][address][' . $jdx . '][street]', $address->street, ['class' => 'form-control', 'placeholder' => '']) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][country_id]', trans('global.addresses.fields.country'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('contact[' . $idx . '][address][' . $jdx . '][country_id]', $countries->pluck('name', 'id'), $address->country_id, ['class' => 'form-control select2 form-country-id', 'id' => 'country_id']) !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][state_id]', trans('global.addresses.fields.state'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('contact[' . $idx . '][address][' . $jdx . '][state_id]', $states, $address->state_id, ['class' => 'form-control select2 form-state-id', 'id' => 'state_id']) !!}
                                                    {!! Form::text('contact[' . $idx . '][address][' . $jdx . '][state]', null, ['class' => 'form-control', 'placeholder' => 'Enter state manually', 'style' => 'margin-top: 4px;']) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][city_id]', trans('global.addresses.fields.city'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('contact[' . $idx . '][address][' . $jdx . '][city_id]', $cities, $address->city_id, ['class' => 'form-control select2 form-city-id', 'id' => 'city_id']) !!}
                                                    {!! Form::text('contact[' . $idx . '][address][' . $jdx . '][city]', null, ['class' => 'form-control', 'placeholder' => 'Enter city manually', 'style' => 'margin-top: 4px;']) !!}
                                                </div>
                                                <div class="col-md-4">
                                                    {!! Form::label('contact[' . $idx . '][address][' . $jdx . '][note]', trans('global.addresses.fields.note'), ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('contact[' . $idx . '][address][' . $jdx . '][note]', $address->note, ['class' => 'form-control ', 'placeholder' => '']) !!}
                                                </div>
                                            </div>
                                            {!! Form::hidden('contact[' . $idx . '][address][' . $jdx . '][id]', $address->id) !!}
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-primary btn-existing-address" data-cfid="{{ $idx }}">
                                    <span class="fa fa-plus"></span> @lang('global.addresses.address-button')
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" class="btn btn-success btn-contact"><span class="fa fa-plus"></span> @lang('global.contacts.contact-button')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- contacts end --}}

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @include('partials.forms.date')
    <script>
    $(function() {
        // dynamic forms

        var i = 0; // contact form iterator
        var j = 0; // address form iterator, belongs to contact
        var countryData = {
            "country": [
                @foreach($countries as $country)
                {
                    "id": {{ $country->id }},
                    "name": "{{ $country->name }}",
                    "states": [
                        @foreach($country->states as $state)
                        {
                            "id": {{ $state->id }},
                            "name": "{{ $state->name }}",
                        },
                        @endforeach
                    ],
                    "cities": [
                        @foreach($country->cities as $city)
                        {
                            "id": {{ $city->id }},
                            "name": "{{ $city->name }}",
                        },
                        @endforeach
                    ]
                },
                @endforeach
            ]
        };

        // add new contact button action

        $('.btn-contact').on('click', function() {
            $(` <div class="box box-success with-border">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][first_name]" class="control-label required">
                                    @lang('global.contacts.fields.first-name')
                                </label>
                                <input class="form-control" placeholder="" required="" name="new_contact[` + i + `][first_name]" type="text" id="new_contact[` + i + `][first_name]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][last_name]" class="control-label required">
                                    @lang('global.contacts.fields.last-name')
                                </label>
                                <input class="form-control" placeholder="" required="" name="new_contact[` + i + `][last_name]" type="text" id="new_contact[` + i + `][last_name]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][mobile_number]" class="control-label">
                                    @lang('global.contacts.fields.mobile-number')
                                </label>
                                <input class="form-control" placeholder="" name="new_contact[` + i + `][mobile_number]" type="text" id="new_contact[` + i + `][mobile_number]">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][phone_number]" class="control-label">
                                    @lang('global.contacts.fields.phone-number')
                                </label>
                                <input class="form-control" placeholder="" name="new_contact[` + i + `][phone_number]" type="text" id="new_contact[` + i + `][phone_number]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][email]" class="control-label">
                                    @lang('global.contacts.fields.email')
                                </label>
                                <input class="form-control" placeholder="" name="new_contact[` + i + `][email]" type="email" id="new_contact[` + i + `][email]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][contact_type_id]" class="control-label">
                                    @lang('global.contacts.fields.contact-type')
                                </label>
                                <select class="form-control select2" id="new_contact[` + i + `][contact_type_id]" name="new_contact[` + i + `][contact_type_id]">
                                @foreach ($contact_types as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][designation_type_id]" class="control-label">
                                    @lang('global.contacts.fields.designation-type')
                                </label>
                                <select class="form-control select2" id="new_contact[` + i + `][designation_type_id]" name="new_contact[` + i + `][designation_type_id]">
                                @foreach ($designation_types as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + i + `][is_primary]" class="control-label">
                                    @lang('global.contacts.fields.is-primary')
                                </label>
                                <input name="new_contact[` + i + `][is_primary]" type="hidden" value="0" id="new_contact[` + i + `][is_primary]">
                                <input name="new_contact[` + i + `][is_primary]" type="checkbox" value="1" id="new_contact[` + i + `][is_primary]">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-address" data-cfid="`+ i +`">
                            <span class="fa fa-plus">
                        </span> Add New Address</button>
                    </div>
                </div>`).insertBefore('.btn-contact');

            $('#new_contact\\[' + i + '\\]\\[contact_type_id\\]').select2();
            $('#new_contact\\[' + i + '\\]\\[designation_type_id\\]').select2();
            i++;
        });

        // add new address button action for new contact +++

        $('.panel-contacts').on('click', '.btn-address', function(){
            var cfid = $(this).data('cfid');
            $(this).before(`
                <div class="box box-primary with-border">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][address_type_id]" class="control-label">
                                    @lang('global.addresses.fields.address-type')
                                </label>
                                <select class="form-control select2" id="new_contact[` + cfid + `][address][` + j + `][address_type_id]" name="new_contact[` + cfid + `][address][` + j + `][address_type_id]">
                                    @foreach($address_types as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][street]" class="control-label">
                                    @lang('global.addresses.fields.street')
                                </label>
                                <input class="form-control" placeholder="" name="new_contact[` + cfid + `][address][` + j + `][street]" type="text" id="new_contact[` + cfid + `][address][` + j + `][street]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][country_id]" class="control-label">
                                    @lang('global.addresses.fields.country')
                                </label>
                                <select class="form-control select2 form-country-id" id="new_contact[` + cfid + `][address][` + j + `][country_id]" name="new_contact[` + cfid + `][address][` + j + `][country_id]">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][state_id]" class="control-label">
                                    @lang('global.addresses.fields.state')
                                </label>
                                <select class="form-control select2 form-state-id" id="new_contact[` + cfid + `][address][` + j + `][state_id]" name="new_contact[` + cfid + `][address][` + j + `][state_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.state')"
                                name="new_contact[` + cfid + `][address][` + j + `][state]"
                                type="text"
                                id="new_contact[` + cfid + `][address][` + j + `][state]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][city_id]" class="control-label">
                                    @lang('global.addresses.fields.city')
                                </label>
                                <select class="form-control select2 form-city-id" id="new_contact[` + cfid + `][address][` + j + `][city_id]" name="new_contact[` + cfid + `][address][` + j + `][city_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.city')"
                                name="new_contact[` + cfid + `][address][` + j + `][city]"
                                type="text"
                                id="new_contact[` + cfid + `][address][` + j + `][city]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_contact[` + cfid + `][address][` + j + `][note]" class="control-label">
                                    @lang('global.addresses.fields.note')
                                </label>
                                <textarea class="form-control " placeholder="" name="new_contact[` + cfid + `][address][` + j + `][note]" cols="50" rows="10" id="new_contact[` + cfid + `][address][` + j + `][note]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $('#new_contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[address_type_id\\]').select2();
            $('#new_contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[country_id\\]').select2().trigger('change');
            $('#new_contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[state_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.state-id')',
            });
            $('#new_contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[city_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.city-id')',
            });

            j++;
        });

        // add new address button action for existing contact +++

        $('.panel-contacts').on('click', '.btn-existing-address', function(){
            var cfid = $(this).data('cfid');
            $(this).before(`
                <div class="box box-primary with-border">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][address_type_id]" class="control-label">
                                    @lang('global.addresses.fields.address-type')
                                </label>
                                <select class="form-control select2" id="contact[` + cfid + `][new_address][` + j + `][address_type_id]" name="contact[` + cfid + `][new_address][` + j + `][address_type_id]">
                                    @foreach($address_types as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][street]" class="control-label">
                                    @lang('global.addresses.fields.street')
                                </label>
                                <input class="form-control" placeholder="" name="contact[` + cfid + `][new_address][` + j + `][street]" type="text" id="contact[` + cfid + `][new_address][` + j + `][street]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][country_id]" class="control-label">
                                    @lang('global.addresses.fields.country')
                                </label>
                                <select class="form-control select2 form-country-id" id="contact[` + cfid + `][new_address][` + j + `][country_id]" name="contact[` + cfid + `][new_address][` + j + `][country_id]">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][state_id]" class="control-label">
                                    @lang('global.addresses.fields.state')
                                </label>
                                <select class="form-control select2 form-state-id" id="contact[` + cfid + `][new_address][` + j + `][state_id]" name="contact[` + cfid + `][new_address][` + j + `][state_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.state')"
                                name="contact[` + cfid + `][new_address][` + j + `][state]"
                                type="text"
                                id="contact[` + cfid + `][new_address][` + j + `][state]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][city_id]" class="control-label">
                                    @lang('global.addresses.fields.city')
                                </label>
                                <select class="form-control select2 form-city-id" id="contact[` + cfid + `][new_address][` + j + `][city_id]" name="contact[` + cfid + `][new_address][` + j + `][city_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.city')"
                                name="contact[` + cfid + `][new_address][` + j + `][city]"
                                type="text"
                                id="contact[` + cfid + `][new_address][` + j + `][city]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][new_address][` + j + `][note]" class="control-label">
                                    @lang('global.addresses.fields.note')
                                </label>
                                <textarea class="form-control " placeholder="" name="contact[` + cfid + `][new_address][` + j + `][note]" cols="50" rows="10" id="contact[` + cfid + `][new_address][` + j + `][note]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $('#contact\\[' + cfid + '\\]\\[new_address\\]\\[' + j + '\\]\\[address_type_id\\]').select2();
            $('#contact\\[' + cfid + '\\]\\[new_address\\]\\[' + j + '\\]\\[country_id\\]').select2().trigger('change');
            $('#contact\\[' + cfid + '\\]\\[new_address\\]\\[' + j + '\\]\\[state_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.state-id')',
            });
            $('#contact\\[' + cfid + '\\]\\[new_address\\]\\[' + j + '\\]\\[city_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.city-id')',
            });

            j++;
        });

        // changes states and cities on country select
        // event for all address forms

        $('.panel-contacts').on('change', '.form-country-id', function(){
            var self = this;
            var currentCountry = $(this).val();
            for (var i = 0; i < countryData.country.length; i++) {
                if (countryData.country[i].id == currentCountry) {
                    $(this).closest('.box-body').find('.form-state-id').empty();
                    $(this).closest('.box-body').find('.form-state-id').append('<option value=""></option>');
                    $.each(countryData.country[i].states, function(index, value) {
                        $(self).closest('.box-body').find('.form-state-id').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                    $(this).closest('.box-body').find('.form-city-id').empty();
                    $(this).closest('.box-body').find('.form-city-id').append('<option value=""></option>');
                    $.each(countryData.country[i].cities, function(index, value) {
                        $(self).closest('.box-body').find('.form-city-id').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        });

        $('.form-state-id').select2({
            placeholder: '@lang('global.addresses.placeholders.state-id')',
        });
        $('.form-city-id').select2({
            placeholder: '@lang('global.addresses.placeholders.city-id')',
        });

    });
    </script>

@stop
