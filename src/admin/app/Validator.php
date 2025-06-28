<?php

namespace Peking\Admin;

class Validator
{
    private array $errors = [];
    private array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function validate(array $rules): bool
    {
        $this->errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $this->validateField($field, $fieldRules);
        }
        
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        return empty($this->errors) ? null : reset($this->errors);
    }

    public function getCleanData(): array
    {
        $clean = [];
        foreach ($this->data as $key => $value) {
            $clean[$key] = $this->sanitize($value);
        }
        return $clean;
    }

    private function validateField(string $field, array $rules): void
    {
        $value = $this->data[$field] ?? null;
        
        foreach ($rules as $rule) {
            $this->applyRule($field, $value, $rule);
        }
    }

    private function applyRule(string $field, mixed $value, string $rule): void
    {
        $parts = explode(':', $rule, 2);
        $ruleName = $parts[0];
        $parameter = $parts[1] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, "Polje '{$field}' je obavezno.");
                }
                break;
                
            case 'min':
                if (strlen($value) < (int)$parameter) {
                    $this->addError($field, "Polje '{$field}' mora imati najmanje {$parameter} znakova.");
                }
                break;
                
            case 'max':
                if (strlen($value) > (int)$parameter) {
                    $this->addError($field, "Polje '{$field}' može imati najviše {$parameter} znakova.");
                }
                break;
                
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Polje '{$field}' mora biti važeća email adresa.");
                }
                break;
                
            case 'numeric':
                if (!is_numeric($value)) {
                    $this->addError($field, "Polje '{$field}' mora biti broj.");
                }
                break;
                
            case 'alpha':
                if (!ctype_alpha($value)) {
                    $this->addError($field, "Polje '{$field}' može sadržavati samo slova.");
                }
                break;
                
            case 'alphanumeric':
                if (!ctype_alnum($value)) {
                    $this->addError($field, "Polje '{$field}' može sadržavati samo slova i brojeve.");
                }
                break;
                
            case 'price':
                if (!preg_match('/^\d+([.,]\d{1,2})?$/', $value)) {
                    $this->addError($field, "Polje '{$field}' mora biti važeća cijena (npr. 12,50).");
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    private function sanitize(mixed $value): mixed
    {
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    public static function csrfField(): string
    {
        $auth = new Auth();
        $token = $auth->generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validateCSRF(string $token): bool
    {
        $auth = new Auth();
        return $auth->validateCSRFToken($token);
    }
}