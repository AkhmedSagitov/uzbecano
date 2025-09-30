<?php

declare(strict_types=1);

namespace Uzbecano\TelegramMessenger\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use Uzbecano\TelegramMessenger\Service\TelegramService;

class TelegramFinisher extends AbstractFinisher
{
    protected $shortFinisherIdentifier = 'Telegram';

    protected function executeInternal(): void
    {
        $formValues = $this->getFormValues();
        $telegramService = GeneralUtility::makeInstance(TelegramService::class);

        try {
            // Get custom message template or use default
            $messageTemplate = $this->parseOption('messageTemplate') ?: $this->getDefaultMessageTemplate();
            $chatId = $this->parseOption('chatId') ?: null;

            // Format message
            $message = $this->formatMessage($messageTemplate, $formValues);

            // Send to Telegram
            $success = $telegramService->sendMessage($message, $chatId);

            if (!$success) {
                throw new \Exception('Failed to send message to Telegram');
            }

        } catch (\Exception $e) {
            // Log error or handle silently based on configuration
            if ($this->parseOption('debugMode')) {
                throw $e;
            }
        }
    }

    protected function getFormValues(): array
    {
        $formRuntime = $this->finisherContext->getFormRuntime();
        return $formRuntime->getFormState()->getFormValues();
    }

    protected function getDefaultMessageTemplate(): string
    {
        return "🛒 <b>New Order Received!</b>\n\n{fields}\n\n📅 <i>Submitted: {date}</i>\n🌐 <i>From: {site}</i>";
    }

    protected function formatMessage(string $template, array $formValues): string
    {
        // Build fields string
        $fieldsText = '';
        foreach ($formValues as $key => $value) {
            if (!empty($value) && !is_array($value)) {
                $fieldLabel = $this->getFieldLabel($key);
                $fieldsText .= "<b>{$fieldLabel}:</b> {$value}\n";
            } elseif (is_array($value)) {
                $fieldLabel = $this->getFieldLabel($key);
                $fieldsText .= "<b>{$fieldLabel}:</b> " . implode(', ', $value) . "\n";
            }
        }

        // Replace template variables and individual field placeholders
        $formDefinition = $this->finisherContext->getFormRuntime()->getFormDefinition();
        $replacements = [
            '{fields}' => $fieldsText,
            '{date}' => date('Y-m-d H:i:s'),
            '{site}' => $_SERVER['HTTP_HOST'] ?? 'TYPO3 Site',
            '{formTitle}' => $formDefinition->getLabel() ?: 'Form'
        ];

        // Add individual field replacements
        foreach ($formValues as $key => $value) {
            if (!is_array($value)) {
                $replacements['{' . $key . '}'] = $value;
            } else {
                $replacements['{' . $key . '}'] = implode(', ', $value);
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    protected function getFieldLabel(string $fieldName): string
    {
        // Try to get proper field label from form definition
        $formDefinition = $this->finisherContext->getFormRuntime()->getFormDefinition();

        foreach ($formDefinition->getRenderablesRecursively() as $renderable) {
            if ($renderable->getIdentifier() === $fieldName) {
                return $renderable->getLabel() ?: ucfirst(str_replace('_', ' ', $fieldName));
            }
        }

        // Fallback to formatted field name
        return ucfirst(str_replace('_', ' ', $fieldName));
    }
}
