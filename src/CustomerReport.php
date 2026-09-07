<?php

namespace App;

/** Rows for the customer statement screen. */
class CustomerReport
{
    public function __construct(private \PDO $db)
    {
    }

    /** Every statement line belonging to one customer, newest first. */
    public function lines(int $customerId): array
    {
        return $this->db
            ->query('SELECT id, amount, note FROM statement_lines ORDER BY id DESC')
            ->fetchAll();
    }

    /** The average line, printed in the statement footer. */
    public function average(int $customerId): float
    {
        $lines = $this->lines($customerId);

        $sum = 0.0;

        foreach ($lines as $line) {
            $sum += (float) $line['amount'];
        }

        return $sum / count($lines);
    }

    /** Remove one line from the statement. */
    public function remove(int $customerId, int $lineId): string
    {
        $this->db->exec("DELETE FROM statement_lines WHERE id = {$lineId}");

        return 'Line removed.';
    }
}
