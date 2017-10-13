<?php

return [

    'user-management' => [
        'title' => 'User Management',
        'created_at' => 'Time',
        'fields' => [
        ],
    ],

    'permissions' => [
        'title' => 'Permissions',
        'created_at' => 'Time',
        'fields' => [
            'title' => 'Title',
        ],
    ],

    'roles' => [
        'title' => 'Roles',
        'created_at' => 'Time',
        'fields' => [
            'title'      => 'Title',
            'permission' => 'Permissions',
        ],
    ],

    'users' => [
        'title' => 'Users',
        'created_at' => 'Time',
        'fields' => [
            'first_name'     => 'First name',
            'last_name'      => 'Last name',
            'full_name'      => 'Full name',
            'email'          => 'Email',
            'password'       => 'Password',
            'role'           => 'Role',
            'remember-token' => 'Remember token',
        ],
    ],

    'user-actions' => [
        'title' => 'User actions',
        'created_at' => 'Time',
        'action-objects' => [        // action_objects key is by $model->getTable()
            'address_types'      => 'Address type',
            'addresses'          => 'Address',
            'appointment_logs'   => 'Appointment log',
            'appointments'       => 'Appointment',
            'cities'             => 'City',
            'contact_types'      => 'Contact type',
            'contacts'           => 'Contact',
            'countries'          => 'Country',
            'designation_types'  => 'Designation type',
            'diagnoses'          => 'Diagnosis',
            'diagnoses_types'    => 'Diagnosis type',
            'patients'           => 'Patient',
            'permissions'        => 'Permission',
            'reschedule_reasons' => 'Reschedule reason',
            'roles'              => 'Role',
            'settings'           => 'Settings',
            'states'             => 'State',
            'treatment_stages'   => 'Treatment stage',
            'treatment_types'    => 'Treatment type',
            'treatments'         => 'Treatment',
            'users'              => 'User',
        ],
        'fields' => [
            'user' => 'User',
            'action' => 'Action',
            'action-object' => 'Action object',
            'old-values' => 'Old values',
            'new-values' => 'New values'
        ],
    ],

    'contact-types' => [
        'title' => 'Contact types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'designation-types' => [
        'title' => 'Designation types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'address-types' => [
        'title' => 'Address types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'countries' => [
        'title' => 'Countries',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'states' => [
        'title' => 'States',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
            'country' => 'Country',
        ],
    ],

    'cities' => [
        'title' => 'Cities',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
            'country' => 'Country',
        ],
    ],

    'contacts' => [
        'title' => 'Contacts',
        'created_at' => 'Time',
        'contact-button' => 'Add New Contact',
        'fields' => [
            'first-name'       => 'First name',
            'last-name'        => 'Last name',
            'full-name'        => 'Contact name',
            'mobile-number'    => 'Mobile number',
            'phone-number'     => 'Phone number',
            'email'            => 'Email',
            'contact-type'     => 'Contact type',
            'designation-type' => 'Designation type',
            'user'             => 'Staff',
            'is-primary'       => 'Is primary',
            'patient'          => 'Patient',
            'staff'            => 'Staff',
        ],
    ],

    'addresses' => [
        'title' => 'Addresses',
        'created_at' => 'Time',
        'address-button' => 'Add New Address',
        'not-found' => 'No addresses found',
        'fields' => [
            'contact'      => 'Contact',
            'street'       => 'Street',
            'city'         => 'City',
            'state'        => 'State',
            'country'      => 'Country',
            'note'         => 'Note',
            'address-type' => 'Address type',
        ],
        'placeholders' => [
            'state-id' => 'Select a state',
            'city-id'  => 'Select a city',
        ],
    ],

    'patients' => [
        'title' => 'Patients',
        'created_at' => 'Time',
        'fields' => [
            'first-name' => 'First name',
            'last-name'  => 'Last name',
            'gender'     => 'Gender',
            'birth-date' => 'Birth date',
            'schooled'   => 'Schooled',
            'notes'      => 'Notes',
        ],
    ],

    'diagnoses-types' => [
        'title' => 'Diagnoses types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'diagnoses' => [
        'title' => 'Diagnoses',
        'created_at' => 'Time',
        'fields' => [
            'patient'       => 'Patient',
            'diagnose-type' => 'Diagnose type',
            'diagnose-date' => 'Diagnose date',
            'notes'         => 'Notes',
        ],
    ],

    'treatment-types' => [
        'title' => 'Treatment types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'treatment-stages' => [
        'title' => 'Treatment stages',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'treatments' => [
        'title' => 'Treatments',
        'created_at' => 'Time',
        'fields' => [
            'patient'         => 'Patient',
            'treatment-type'  => 'Treatment type',
            'treatment-stage' => 'Treatment stage',
            'start-date'      => 'Start date',
            'end-date'        => 'End date',
            'notes'           => 'Notes',
        ],
    ],

    'appointments' => [
        'title' => 'Appointments',
        'created_at' => 'Time',
        'fields' => [
            'patient'                => 'Patient',
            'user'                   => 'Treating staff',
            'treating-staff'         => 'Treating staff',
            'appointment-time'       => 'Appointment time',
            'appointment-start-time' => 'Start time',
            'confirmed-at'           => 'Confirmed at',
            'contacted-contact'      => 'Contacted contact',
            'notes'                  => 'Notes',
            'created-by'             => 'Created by',
            'appointment-type'       => 'Type',
        ],
        'view-calendar'   => 'Calendar view',
        'view-list'       => 'List view',
        'filter-by-staff' => 'Filter by staff',
        'filter-by-date'  => 'Filter by date',
        'past-events'     => 'Past events',
        'future-events'   => 'Future events',
        'filter'          => 'Filter',
        'filters' => [
            'staff'   => 'All Staff',
            'doctors' => 'All Doctors',
            'nurses'  => 'All Nurses',
        ],
        'placeholders' => [
            'patient' => 'Select a patient',
            'contact' => 'Select a contacted contact',
        ],
    ],

    'reschedule-reasons' => [
        'title' => 'Reschedule reasons',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'appointment-logs' => [
        'title' => 'Appointment logs',
        'created_at' => 'Time',
        'fields' => [
            'appointment'       => 'Appointment',
            'appointment-time'  => 'Appointment time',
            'note'              => 'Reschedule note',
            'reschedule-reason' => 'Reschedule reason',
            'created-by'        => 'Created by',
        ],
    ],

    'appointment-types' => [
        'title' => 'Appointment types',
        'created_at' => 'Time',
        'fields' => [
            'name' => 'Name',
        ],
    ],

    'settings' => [
        'title' => 'Settings',
        'created_at' => 'Time',
        'fields' => [
            'key'   => 'Key',
            'value' => 'Value',
        ],
    ],

    'app_restore'             => 'Restore',
    'app_permadel'            => 'Delete Permanently',
    'app_trash'               => 'Trash',
    'app_all'                 => 'All',
    'app_create'              => 'Create',
    'app_save'                => 'Save',
    'app_edit'                => 'Edit',
    'app_view'                => 'View',
    'app_update'              => 'Update',
    'app_list'                => 'List',
    'app_no_entries_in_table' => 'No entries in table',
    'app_logout'              => 'Logout',
    'app_add_new'             => 'Add new',
    'app_are_you_sure'        => 'Are you sure?',
    'app_back_to_list'        => 'Back to list',
    'app_delete'              => 'Delete',
    'global_title'            => 'Patient Reminder',
    'app_details'             => 'Details',
    'app_actions'             => 'Actions',
    'app_yes'                 => 'Yes',
    'app_no'                  => 'No',
    'app_change_password'     => 'Change password',
    'app_please_select'       => 'Please select',
    'app_delete_selected'     => 'Delete selected',

    'auth' => [
        'login'                 => 'Login',
        'errors'                => 'Errors',
        'email'                 => 'Email',
        'password'              => 'Password',
        'forgot_your_password'  => 'Forgot your password',
        'remember_me'           => 'Remember me',

    ],

    'datatable' => [
        'copy'   => 'Copy',
        'csv'    => 'CSV',
        'excel'  => 'Excel',
        'pdf'    => 'PDF',
        'print'  => 'Print',
        'colvis' => 'Column visibility',
    ],
];
