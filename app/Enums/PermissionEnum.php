<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case CREATE_ARTICLES = 'create articles';
    case EDIT_ARTICLES = 'edit articles';
    case DELETE_ARTICLES = 'delete articles';
    case VIEW_ARTICLES = 'view articles';
    case CREATE_COMMENTS = 'create comments';
    case DELETE_COMMENTS = 'delete comments';
    case VIEW_COMMENTS = 'view comments';
    case CREATE_ESTATES = 'create estates';
    case EDIT_ESTATES = 'edit estates';
    case DELETE_ESTATES = 'delete estates';
    case VIEW_ESTATES = 'view estates';
    case CREATE_CONTACTS = 'create contacts';
    case EDIT_CONTACTS = 'edit contacts';
    case DELETE_CONTACTS = 'delete contacts';
    case VIEW_CONTACTS = 'view contacts';
    case EDIT_PROFILES = 'edit profiles';
    case VIEW_PROFILES = 'view profiles';
    case EDIT_SETTINGS = 'edit settings';
    case VIEW_SETTINGS = 'view settings';
    case VIEW_OVERVIEW = 'view overview';

    public static function labels(): array
    {
        return [
            self::CREATE_ARTICLES->value => __('home.create_articles'),
            self::EDIT_ARTICLES->value => __('home.edit_articles'),
            self::DELETE_ARTICLES->value => __('home.delete_articles'),
            self::VIEW_ARTICLES->value => __('home.view_articles'),
            self::CREATE_COMMENTS->value => __('home.create_comments'),
            self::DELETE_COMMENTS->value => __('home.delete_comments'),
            self::VIEW_COMMENTS->value => __('home.view_comments'),
            self::CREATE_ESTATES->value => __('home.create_estates'),
            self::EDIT_ESTATES->value => __('home.edit_estates'),
            self::DELETE_ESTATES->value => __('home.delete_estates'),
            self::VIEW_ESTATES->value => __('home.view_estates'),
            self::CREATE_CONTACTS->value => __('home.create_contacts'),
            self::EDIT_CONTACTS->value => __('home.edit_contacts'),
            self::DELETE_CONTACTS->value => __('home.delete_contacts'),
            self::VIEW_CONTACTS->value => __('home.view_contacts'),
            self::EDIT_PROFILES->value => __('home.edit_profiles'),
            self::VIEW_PROFILES->value => __('home.view_profiles'),
            self::EDIT_SETTINGS->value => __('home.edit_settings'),
            self::VIEW_SETTINGS->value => __('home.view_settings'),
            self::VIEW_OVERVIEW->value => __('home.view_overview'),
        ];
    }
}
