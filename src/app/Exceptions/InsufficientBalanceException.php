<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * InsufficientBalanceException
 *
 * Dilempar oleh WalletService::debit() ketika user mencoba melakukan
 * debit yang melebihi saldo wallet yang tersedia.
 *
 * Tangkap exception ini di controller untuk mengembalikan pesan error
 * yang sesuai kepada user.
 */
class InsufficientBalanceException extends RuntimeException
{
    public function __construct(
        public readonly float $requestedAmount,
        public readonly float $availableBalance,
        string $message = '',
    ) {
        parent::__construct(
            $message ?: "Saldo tidak cukup. Saldo tersedia: Rp " .
                number_format($availableBalance, 0, ',', '.') .
                ", nominal yang diminta: Rp " .
                number_format($requestedAmount, 0, ',', '.')
        );
    }
}
