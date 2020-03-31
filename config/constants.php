<?php

/**
 * Created by Netbeans.
 * User: Annanovas
 * Date: 12/07/18
 */
return [
    'ACTIVE_STATUSES' => [1 => 'Active', 0 => 'Inactive'],
    'ARCHIVE_STATUSES' => [1 => 'Archive', 0 => 'Not Archive'],
    'ACTIVE_CLIENT_STATUSES' => [0 => 'Pending', 1 => 'Active', 2 => 'Inactive', 3 => 'Suspended'],
    'ACTIVE_VENDOR_STATUSES' => [0 => 'Pending', 1 => 'Active', 2 => 'Inactive', 3 => 'Suspended'],
    'ACTIVE_PUBLIC_TYPES' => [1 => 'Public', 0 => 'Private'],
    'ASSET_IMAGE' => 'assetImage',
    'ASSET_QR_CODE_IMAGE' => 'assetQrCodeImage',
    'ASSET_ATTACHMENT' => 'assetAttachment',
    'VENDOR_ATTACHMENT' => 'vendorEnlistmentAttachment',
    'PROCESS_TYPES' => [1 => 'Any one user can approve', 2 => 'All of the user must approve', 3 => 'Minimum no. of user can approve'],
    'ASSET_PERMISSION_TYPES' => [0 => 'No Asset', 1 => 'All Assets', 2 => 'Exclusively Some Assets'],
    'PROCESS_NOT_COMPLETE_TYPES' => [1 => 'Return to previous step if not complete', 2 => 'Proceed to next step', 3 => 'Stop'],
    'ACTIVE_ASSESSMENT_TYPES' => [0 => 'New', 1 => 'Renew'],
    'ACTIVE_ASSESSMENT_STATUSES' => [0 => 'Inactive', 1 => 'In-progress', 2 => 'Approved', 3 => 'Reject'],
    'ASSESSMENT_APPROVAL_STATUSES' => [1 => 'Approved', 2 => 'Rejected'],
    'ASSET_STORE_TYPE' => [0 => 'Store'],
    'DEPRECIATION_TYPE' => [0 => 'Percentage',1 => 'Fixed Amount'], //if change here please update to helper and cron jobs
    'DEPRECIATION_CATEGORY' => [0 => 'Daily Basis',1 => 'Yearly Basis'], //if change here please update to helper and cron jobs
    'ASSET_ASSIGN_STATUSES' => [0 => 'New', 1 => 'Accepted', 2 => 'Rejected', 3 => 'Return to Store'],
    'ASSET_STAGE_STATUSES' =>[1 => 'Created', 2 => 'Updated', 3 => 'assigned', 4 => 'User Accept', 5 => 'User Reject', 6 => 'User Return', 7 => 'Admin Return Accept', 8 => 'Admin Return Reject', 9 => 'Store Moved', 10 => 'Archived', 11 => 'Deleted', 12 => 'Attached File', 13 => 'Attachment Delete'],
    'ASSET_STAGE_BG' =>[1 => 'bg-green', 2 => 'bg-blue', 3 => 'bg-aqua', 4 => 'bg-green', 5 => 'bg-fuchsia', 6 => 'bg-navy', 7 => 'bg-green', 8 => 'bg-fuchsia', 9 => 'bg-teal', 10 => 'bg-orange', 11 => 'bg-red', 12 => 'bg-black', 13 => 'bg-red'],
    'ASSET_STAGE_ICON' =>[1 => 'fa-folder-open', 2 => 'fa-edit', 3 => 'fa-user-plus', 4 => 'fa-check', 5 => 'fa-user-times', 6 => 'fa-rotate-left', 7 => 'fa-check-square-o', 8 => 'fa-remove', 9 => 'fa-exchange', 10 => 'fa-archive', 11 => 'fa-trash-o', 12 => 'fa-file', 13 => 'fa-trash-o'],
    'ASSET_ID_PREFIX' => 'AST-',
];
