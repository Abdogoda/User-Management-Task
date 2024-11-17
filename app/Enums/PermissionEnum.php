<?php
namespace App\Enums;

enum PermissionEnum: string{
    // User Management
    case CREATE_USER = 'create_user';
    case VIEW_USER = 'view_user';
    case EDIT_USER = 'edit_user';
    case DELETE_USER = 'delete_user';

    // Role Management
    case CREATE_ROLE = 'create_role';
    case VIEW_ROLE = 'view_role';
    case EDIT_ROLE = 'edit_role';
    case DELETE_ROLE = 'delete_role';
    case ASSIGN_ROLE = 'assign_role';

    // Permission Management
    case VIEW_PERMISSION = 'view_permission';
}