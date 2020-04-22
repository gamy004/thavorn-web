<?php

namespace App\IOCs;

class DBCol
{
    const ID = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
    
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const IDENTITY_CARD_ID = 'identity_card_id';
    const GENDER = 'gender';
    const FACEBOOK = 'facebook';
    const LINE = 'line';
    const EMAIL = 'email';
    const PHONE_NUMBER = 'phone_number';
    const PASSWORD = 'password';
    const REMEMBER_TOKEN = 'remember_token';
    const EMAIL_VERIFIED_AT = 'email_verified_at';

    const PAWN_NO = 'pawn_no';
    const INTEREST_RATE = 'interest_rate';

    const ITEM_WEIGHT = 'item_weight';
    const ITEM_WEIGHT_UNIT = 'item_weight_unit';
    const ITEM_VALUE = 'item_value';
    const ITEM_VALUE_UNIT = 'item_value_unit';

    const ITEM_CATEGORY = 'item_category';
    const ITEM_DAMAGE = 'item_damage';
    
    const USERNAME = 'username';
    const NAME = 'name';
    const AVATAR = 'avatar';
    const AVAILABLE = 'available';
    const INBOX_SETTINGS = 'inbox_settings';
    const ROLE = 'role';
    const TYPE = 'type';
    
    const EXPIRE_AT = 'expire_at';
    const REF = 'ref';
    const VALUE = 'value';
    const DESCRIPTION = 'description';
    const LABEL = 'label';
    const DISPLAY = 'display';
    const REQUIRED = 'required';
    const ACTIVE = 'active';
    const UNIQUE = 'unique';
    const NOTE = 'note';
    const UUID = 'uuid';

    /**
     * ISSUE
     */
    const SUBJECT = 'subject';
    const ISSUED_BY = 'issued_by';
    const REFERENCED_TO = 'referenced_to';
    const RECIPIENT_ID = 'recipient_id';
    const ARCHIVE = 'archive';
    const DRAFT = 'draft';

    /**
     * ISSUE_CATEGORY
     */
    const CATEGORY = 'category';

    /**
     * ISSUE STATUS
     */
    const STATUS = 'status';
    const COLOR = 'color';
    const DURATION = 'duration';
    const UNIT = 'unit';
    const DEFAULT = 'default';
    const STATUS_UPDATED_AT = 'status_updated_at';
    const STARTED_AT = 'started_at';
    const ENDED_AT = 'ended_at';

    /**
     * ISSUE NOTE
     */
    const CREATED_BY = 'created_by';

    /**
     * File
     */
    const DISPLAY_NAME = 'display_name';
    const HASH_NAME = 'hash_name';
    const SIZE = 'size';
    const FORMATTED_SIZE = 'formatted_size';
    const MIME = 'mime';
    const PATH = 'path';
    const URL = 'url';
    const _PUBLIC = 'public';

    /**
     * THAWON
     */
    const AMOUNT = 'amount';
    const MONTH_AMOUNT = 'month_amount';
    const COMPLETE = 'complete';
    const LATEST_PAID_AT = 'latest_paid_at';
    const NEXT_PAID_AT = 'next_paid_at';
    const TIME_START_AT = 'time_start_at';
    const TIME_END_AT = 'time_end_at';
}
