<?php

namespace App\Models;

use App\Enum\ButtonTypeEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateButton extends BaseModel
{
    protected $fillable = [
        'template_id',
        'button_text',
        'button_type',
        'action_value',
        'background_color',
        'text_color',
        'sort_order',
    ];

    protected $casts = [
        'button_type' => ButtonTypeEnum::class,
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function formatAction(?string $actionValue = null): string
    {
        $value = $actionValue ?? $this->action_value;

        return $this->button_type->formatAction($value);
    }

    public function isWhatsAppButton(): bool
    {
        return $this->button_type == ButtonTypeEnum::WHATSAPP;
    }

    public function isPhoneButton(): bool
    {
        return $this->button_type == ButtonTypeEnum::PHONE;
    }

    public function isUrlButton(): bool
    {
        return $this->button_type == ButtonTypeEnum::URL;
    }

    public function isEmailButton(): bool
    {
        return $this->button_type == ButtonTypeEnum::EMAIL;
    }

    public function isQuickReplyButton(): bool
    {
        return $this->button_type == ButtonTypeEnum::QUICK_REPLY;
    }

    public function getValidationRules(): array
    {
        return $this->button_type->getValidationRules();
    }
}
