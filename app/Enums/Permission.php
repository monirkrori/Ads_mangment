<?php

namespace App\Enums;

enum Permission: string
{
    // Ads
    case CREATE_AD = 'create-ad';
    case VIEW_AD = 'view-ad';
    case UPDATE_AD = 'update-ad';
    case DELETE_AD = 'delete-ad';
    case APPROVE_AD = 'approve-ad';

    // Categories
    case VIEW_CATEGORY = 'view-category';
    case CREATE_CATEGORY = 'create-category';
    case UPDATE_CATEGORY = 'update-category';
    case DELETE_CATEGORY = 'delete-category';
    
    // Reviews
    case CREATE_REVIEW = 'create-review';
    case UPDATE_REVIEW = 'update-review';
    case DELETE_REVIEW = 'delete-review';
}
