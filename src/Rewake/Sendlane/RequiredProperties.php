<?php

namespace Rewake\Sendlane;


class RequiredProperties
{
    public $data = [

        'credentials' => [
            'api',
            'hash'
        ],

        'user-details' => [
            'email',
            'password'
        ],

        'list-subscribers-add' => [
            'email',
            'list_id'
        ],

        'list-subscriber-add' => [
            'email',
            'list_id'
        ],

        'subscribers-delete' => [
            'email',
            'list_id'
        ],

        'unsubscribe' => [
            'email'
        ],

        'list-create' => [
            'list_name',
            'from_name',
            'reply_email',
            'short_reminder',
            'company',
            'address',
            'city',
            'zipcode',
            'country',
            'state',
            'phone'
        ],

        'list-update' => [
            'list_id'
        ],

        'list-delete' => [
            'list_id'
        ],

        'lists' => [
            // No fields other than credentials are required
        ],

        'opt-in-form' => [
            'form_id'
        ],

        'opt-in-create' => [
            'list_id',
            'form-name',
            'email'
        ],

        'subscriber-export' => [
            'list_id'
        ],

        'tags' => [
            // No fields other than credentials are required
        ],

        'tag-create' => [
            'name'
        ],

        'tag-subscriber-add' => [
            'email'
            // TODO: OR on tag_ids || tag_names
        ],

        'tag-subscriber-remove' => [
            'email',
            // TODO: OR on tag_ids || tag_names
        ],

        'subscriber-exists' => [
            'list_id',
            'email'
        ]

    ];
}