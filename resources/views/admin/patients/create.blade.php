@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.patients.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.patients.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
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
                    {!! Form::checkbox('schooled', 1, true, []) !!}
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

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.contacts.title')
                </div>

                <div class="panel-body panel-contacts">
                    <button type="button" class="btn btn-success btn-contact"><span class="fa fa-plus"></span> @lang('global.contacts.contact-button')</button>
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('redirect_to', $redirect_to) }}
    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @include('partials.forms.date')
    <script>
        // dynamic forms
        $(function(){

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
                                <label for="contact[` + i + `][first_name]" class="control-label required">
                                    @lang('global.contacts.fields.first-name')
                                </label>
                                <input class="form-control" placeholder="" required="" name="contact[` + i + `][first_name]" type="text" id="contact[` + i + `][first_name]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][last_name]" class="control-label required">
                                    @lang('global.contacts.fields.last-name')
                                </label>
                                <input class="form-control" placeholder="" required="" name="contact[` + i + `][last_name]" type="text" id="contact[` + i + `][last_name]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][mobile_number]" class="control-label">
                                    @lang('global.contacts.fields.mobile-number')
                                </label>
                                <input class="form-control" placeholder="" name="contact[` + i + `][mobile_number]" type="text" id="contact[` + i + `][mobile_number]">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][phone_number]" class="control-label">
                                    @lang('global.contacts.fields.phone-number')
                                </label>
                                <input class="form-control" placeholder="" name="contact[` + i + `][phone_number]" type="text" id="contact[` + i + `][phone_number]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][email]" class="control-label">
                                    @lang('global.contacts.fields.email')
                                </label>
                                <input class="form-control" placeholder="" name="contact[` + i + `][email]" type="email" id="contact[` + i + `][email]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][contact_type_id]" class="control-label">
                                    @lang('global.contacts.fields.contact-type')
                                </label>
                                <select class="form-control select2" id="contact[` + i + `][contact_type_id]" name="contact[` + i + `][contact_type_id]">
                                @foreach ($contact_types as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][designation_type_id]" class="control-label">
                                    @lang('global.contacts.fields.designation-type')
                                </label>
                                <select class="form-control select2" id="contact[` + i + `][designation_type_id]" name="contact[` + i + `][designation_type_id]">
                                @foreach ($designation_types as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + i + `][is_primary]" class="control-label">
                                    @lang('global.contacts.fields.is-primary')
                                </label>
                                <input name="contact[` + i + `][is_primary]" type="hidden" value="0" id="contact[` + i + `][is_primary]">
                                <input name="contact[` + i + `][is_primary]" type="checkbox" value="1" id="contact[` + i + `][is_primary]">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-address" data-cfid="`+ i +`">
                            <span class="fa fa-plus">
                        </span> @lang('global.addresses.address-button')</button>
                    </div>
                </div>
                `).insertBefore('.btn-contact');

            $('#contact\\[' + i + '\\]\\[contact_type_id\\]').select2();
            $('#contact\\[' + i + '\\]\\[designation_type_id\\]').select2();
            i++;
        });

        // add new address button action

        $('.panel-contacts').on('click', '.btn-address', function(){
            var cfid = $(this).data('cfid');
            $(this).before(`
                <div class="box box-primary with-border">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][address_type_id]" class="control-label">
                                    @lang('global.addresses.fields.address-type')
                                </label>
                                <select class="form-control select2" id="contact[` + cfid + `][address][` + j + `][address_type_id]" name="contact[` + cfid + `][address][` + j + `][address_type_id]">
                                    @foreach($address_types as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][street]" class="control-label">
                                    @lang('global.addresses.fields.street')
                                </label>
                                <input class="form-control" placeholder="" name="contact[` + cfid + `][address][` + j + `][street]" type="text" id="contact[` + cfid + `][address][` + j + `][street]">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][country_id]" class="control-label">
                                    @lang('global.addresses.fields.country')
                                </label>
                                <select class="form-control select2 form-country-id" id="contact[` + cfid + `][address][` + j + `][country_id]" name="contact[` + cfid + `][address][` + j + `][country_id]">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][state_id]" class="control-label">
                                    @lang('global.addresses.fields.state')
                                </label>
                                <select class="form-control select2 form-state-id" id="contact[` + cfid + `][address][` + j + `][state_id]" name="contact[` + cfid + `][address][` + j + `][state_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.state')"
                                name="contact[` + cfid + `][address][` + j + `][state]"
                                type="text"
                                id="contact[` + cfid + `][address][` + j + `][state]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][city_id]" class="control-label">
                                    @lang('global.addresses.fields.city')
                                </label>
                                <select class="form-control select2 form-city-id" id="contact[` + cfid + `][address][` + j + `][city_id]" name="contact[` + cfid + `][address][` + j + `][city_id]">
                                </select>
                                <input
                                class="form-control"
                                placeholder="@lang('global.addresses.placeholders.city')"
                                name="contact[` + cfid + `][address][` + j + `][city]"
                                type="text"
                                id="contact[` + cfid + `][address][` + j + `][city]"
                                style="margin-top: 4px;"
                                >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="contact[` + cfid + `][address][` + j + `][note]" class="control-label">
                                    @lang('global.addresses.fields.note')
                                </label>
                                <textarea class="form-control" placeholder="" name="contact[` + cfid + `][address][` + j + `][note]" cols="50" rows="10" id="contact[` + cfid + `][address][` + j + `][note]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $('#contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[address_type_id\\]').select2();
            $('#contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[country_id\\]').select2().trigger('change');
            $('#contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[state_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.state-id')',
            });
            $('#contact\\[' + cfid + '\\]\\[address\\]\\[' + j + '\\]\\[city_id\\]').select2({
                placeholder: '@lang('global.addresses.placeholders.city-id')',
            });

            j++;
        });

        // changes states and cities on country select

        $('.panel-contacts').on('change', '.form-country-id', function(){
            var self = this;
            var currentCountry = $(this).val();
            for (var i = 0; i < countryData.country.length; i++) {
                if (countryData.country[i].id == currentCountry) {
                    $(this).closest('.box-body').find('.form-state-id').empty();
                    $(this).closest('.box-body').find('.form-state-id').append('<option value=""></option>');;
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

        // invoke first contact and address open

        $('.btn-contact').trigger('click');
        $('.btn-address').trigger('click');
    });
    </script>

@stop
