<?php

declare(strict_types=1);

namespace Uzbecano\TelegramMessenger\Service;

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use TYPO3\CMS\Core\SingletonInterface;

class TelegramService implements SingletonInterface
{
    private ?Telegram $telegram = null;
    private array $config = [];

    public function __construct()
    {
        $this->loadConfiguration();
    }

    private function loadConfiguration(): void
    {
        // Try to get configuration from Site Sets first (TYPO3 v13 way)
        if (isset($GLOBALS['TYPO3_REQUEST'])) {
            try {
                $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
                if ($site) {
                    $siteSettings = $site->getSettings();
                    $telegramConfig = $siteSettings->get('telegram', []);
                    if (!empty($telegramConfig)) {
                        $this->config = $telegramConfig;
                        return;
                    }
                }
            } catch (\Exception $e) {
                // Fall through to fallback
            }
        }

        // Fallback to extension configuration
        $this->config = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['telegram-messenger'] ?? [
            'botToken' => '',
            'botUsername' => '',
            'chatId' => '',
        ];
    }

    private function initializeTelegram(): void
    {
        if ($this->telegram !== null) {
            return;
        }

        if (empty($this->config['botToken'])) {
            throw new \RuntimeException('Telegram bot token not configured');
        }

        try {
            $this->telegram = new Telegram($this->config['botToken'], $this->config['botUsername'] ?? '');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to initialize Telegram: ' . $e->getMessage());
        }
    }

    public function sendMessage(string $message, ?string $chatId = null): bool
    {
        $this->initializeTelegram();

        $targetChatId = $chatId ?: $this->config['chatId'];

        if (empty($targetChatId)) {
            throw new \RuntimeException('Chat ID not provided and not configured');
        }

        try {
            $result = Request::sendMessage([
                'chat_id' => $targetChatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]);

            return $result->isOk();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to send Telegram message: ' . $e->getMessage());
        }
    }

    public function sendFormNotification(array $formData): bool
    {
        $message = $this->formatFormMessage($formData);
        return $this->sendMessage($message);
    }

    private function formatFormMessage(array $formData): string
    {
        $message = "<b>🔔 New Form Submission</b>\n\n";

        foreach ($formData as $key => $value) {
            if (!empty($value)) {
                $fieldName = ucfirst(str_replace('_', ' ', $key));
                $message .= "<b>{$fieldName}:</b> {$value}\n";
            }
        }

        $message .= "\n<i>Sent from TYPO3 at " . date('Y-m-d H:i:s') . "</i>";

        return $message;
    }

    public function testConnection(): array
    {
        try {
            $this->initializeTelegram();
            $result = Request::getMe();

            if ($result->isOk()) {
                $botInfo = $result->getResult();
                return [
                    'success' => true,
                    'message' => 'Connection successful',
                    'bot_info' => [
                        'username' => $botInfo->getUsername(),
                        'first_name' => $botInfo->getFirstName(),
                        'id' => $botInfo->getId()
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Connection failed: ' . $result->getDescription()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
