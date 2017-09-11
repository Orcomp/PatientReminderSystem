<?php

return [

    'user-management' => [
        'title' => 'Gestion Utilisateur',
        'created_at' => 'Date',
        'fields' => [
        ],
    ],

    'permissions' => [
        'title' => 'Autorisation',
        'created_at' => 'Date',
        'fields' => [
            'title' => 'Titre',
        ],
    ],

    'roles' => [
        'title' => 'Profils',
        'created_at' => 'Date',
        'fields' => [
            'title' => 'Titre',
            'permission' => 'Autorisation',
        ],
    ],

    'users' => [
        'title' => 'Utilisateur',
        'created_at' => 'Date',

        'fields' => [
            'first_name' => 'Prénom',
            'last_name' => 'Nom',
            'full_name' => 'Nom Complet',
            'email' => 'Email',
            'password' => 'Mot de Passe',
            'role' => 'Profils',
            'remember-token' => 'Token',
        ],
    ],

    'user-actions' => [
        'title' => 'Actions utilisateur',
        'created_at' => 'Date',
        'action-objects' => [        // action_objects key is by $model->getTable()
            'address_types'      => 'Type Adresse',
            'addresses'          => 'Adresse',
            'appointment_logs'   => 'Rendez-vous log',
            'appointments'       => 'Rendez-vous',
            'cities'             => 'Ville',
            'contact_types'      => 'Type de contact',
            'contacts'           => 'Contact',
            'countries'          => 'Pays',
            'designation_types'  => 'Type de Désignation',
            'diagnoses'          => 'Diagnostique',
            'diagnoses_types'    => 'Type de Diagnostique',
            'patients'           => 'Patient',
            'permissions'        => 'Autorisation',
            'reschedule_reasons' => 'Raison du Report',
            'roles'              => 'Profil',
            'states'             => 'Etat de santé',
            'treatment_stages'   => 'Stade du Traitement',
            'treatment_types'    => 'Type de Traitement',
            'treatments'         => 'Traitement',
            'users'              => 'Utilisateur',
        ],
        'fields' => [
    'user' => 'Utilisateur',
    'action' => 'Action',
    'action-object' => 'Action object',
    'old-values' => 'Ancienne Donnée',
    'new-values' => 'Nouvelle Donnée'
],
    ],

    'settings' => [
    'title' => 'Paramètres',
    'created_at' => 'Date',
    'fields' => [
    ],
],

    'contact-types' => [
    'title' => 'Type de contact ou Relation',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'designation-types' => [
    'title' => 'Type de Désignation',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'address-types' => [
    'title' => 'Type d’Adresse',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'countries' => [
    'title' => 'Pays',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'states' => [
    'title' => 'Etats',
    'created_at' => 'Date',

    'fields' => [
        'name' => 'Nom',
        'country' => 'Pays',
    ],
],

    'cities' => [
    'title' => 'Ville',
    'created_at' => 'Date',

    'fields' => [
        'name' => 'Nom',
        'country' => 'Pays',
    ],
],

    'contacts' => [
    'title' => 'Contacts',
    'created_at' => 'Date',
    'contact-button' => 'Ajouter nouveau Contact',
    'fields' => [
        'first-name'       => 'Prénom',
        'last-name'        => 'Nom de Famille',
        'full-name'        => 'Nom du Contact',
        'mobile-number'    => 'Numéro de portable',
        'phone-number'     => 'Numéro de Téléphone',
        'email'            => 'Email',
        'contact-type'     => 'Type de contact',
        'designation-type' => 'Type de Désignation',
        'user'             => 'Utilisateur',
        'is-primary'       => 'Principal',
        'patient'          => 'Patient',
        'staff'            => 'Collaborateur',
    ],
],

    'addresses' => [
    'title' => 'Adresse',
    'created_at' => 'Date',
    'address-button' => 'Ajouter Nouvelle Adresse',
    'select-placeholder' => 'Sélectionnez',
    'country-required' => 'Sélectionnez Pays',
    'fields' => [
        'contact'          => 'Contact',
        'street'           => 'Rue',
        'city'             => 'Ville',
        'state'            => 'Etat',
        'country'          => 'Pays',
        'note'             => 'Note',
        'address-type'     => 'Type d’Adresse',
    ],
],

    'patients' => [
    'title' => 'Patients',
    'created_at' => 'Date',
    'fields' => [
        'first-name' => 'Prénom',
        'last-name'  => 'Nom de Famille',
        'gender'     => 'Sexe',
        'birth-date' => 'Date de Naissance (année-mois-jour)',
        'schooled'   => 'A l’école?',
        'notes'      => 'Notes',
    ],
],

    'diagnoses-types' => [
    'title' => 'Type de Diagnostique',
    'created_at' => 'Date',

    'fields' => [
        'name' => 'Nom',
    ],
],

    'diagnoses' => [
    'title' => 'Diagnostique',
    'created_at' => 'Date',
    'fields' => [
        'patient' => 'Patient',
        'diagnose-type' => 'Type de Diagnostique',
        'diagnose-date' => 'Date du Diagnostique',

        'notes' => 'Notes',
    ],
],

    'treatment-types' => [
    'title' => 'Type de Traitement',
    'created_at' => 'Time',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'treatment-stages' => [
    'title' => 'Stade du Traitement',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'treatments' => [
    'title' => 'Traitements',
    'created_at' => 'Date',
    'fields' => [
        'patient' => 'Patient',
        'treatment-type' => 'Type de Traitement',
        'treatment-stage' => 'Stade du Traitement',
        'start-date' => 'Date de Début',
        'end-date' => 'Date de Fin',
        'notes' => 'Notes',
    ],
],

    'appointments' => [
    'title' => 'Rendez-vous',
    'created_at' => 'Date',
    'fields' => [
        'patient' => 'Patient',
        'user' => 'Suivi par',
        'treating-staff' => 'Suivi Par',
        'appointment-time' => 'Date de Rendez-vous',
        'appointment-start-time' => 'Heure de Début',
        'confirmed-at' => 'Date de Confirmation',
        'contacted-contact' => 'La personne contactée',
        'notes' => 'Notes',
        'created-by' => 'Créé par',
        'appointment-type' => 'Type de Rendez-vous',
    ],
    'view-calendar' => 'Voir Calendrier',
    'view-list' => 'Voir Liste',
    'filter-by-staff' => 'Filtrer par collaborateur',
    'filter' => 'Filtrer',
],

    'reschedule-reasons' => [
    'title' => 'Raison du Report',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'appointment-logs' => [
    'title' => 'Rendez-vous Log',
    'created_at' => 'Date',
    'fields' => [
        'appointment' => 'Rendez-vous',
        'appointment-time' => 'Date du rendez-vous',
        'note' => 'Note Report',
        'reschedule-reason' => 'Raison du Report',
        'created-by' => 'Créé par',
    ],
],

    'appointment-types' => [
    'title' => 'Type de Rendez-vous',
    'created_at' => 'Date',
    'fields' => [
        'name' => 'Nom',
    ],
],

    'app_restore'             => 'Restaurer',
    'app_permadel'            => 'Supprimer Définitivement',
    'app_trash'               => 'Corbeille',
    'app_all'                 => 'Tout',
    'app_create'              => 'Créer',
    'app_save'                => 'Enregistrer',
    'app_edit'                => 'Editer',
    'app_view'                => 'Voir',
    'app_update'              => 'Mettre à jour',
    'app_list'                => 'Liste',
    'app_no_entries_in_table' => 'Aucune Donnée dans le tableau',
    'app_logout'              => 'Logout',
    'app_add_new'             => 'Nouveau',
    'app_are_you_sure'        => 'Confirmez?',
    'app_back_to_list'        => 'Retour à la liste',
    'app_delete'              => 'Supprimer',
    'global_title'            => 'Rappel du Patient',
    'app_details'             => 'Détails',
    'app_actions'             => 'Actions',
    'app_yes'                 => 'Oui',
    'app_no'                  => 'Non',
    'app_change_password'     => 'Modifier mot de passe',
    'app_please_select'       => 'Veuillez sélectionner',
    'app_delete_selected'     => 'Supprimer sélectionnée',

    'auth' => [
        'login'                 => 'Login',
        'errors'                => 'Erreurs',
        'email'                 => 'Email',
        'password'              => 'Mot de passe',
        'forgot_your_password'  => 'Mot depasse oublié',
        'remember_me'           => 'Se souvenir de moi',
    ],

    'datatable' => [
        'copy'   => 'Copie',
        'csv'    => 'CSV',
        'excel'  => 'Excel',
        'pdf'    => 'PDF',
        'print'  => 'Imprimer',
        'colvis' => 'Visibilité de la colonne',
    ],
];
