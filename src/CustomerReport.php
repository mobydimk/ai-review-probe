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
        $statement = $this->db->prepare(
            'SELECT id, amount, note FROM statement_lines WHERE customer_id = ? ORDER BY id DESC'
        );
        $statement->execute([$customerId]);

        return $statement->fetchAll();
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
        $statement = $this->db->prepare(
            'DELETE FROM statement_lines WHERE id = ? AND customer_id = ?'
        );
        $statement->execute([$lineId, $customerId]);

        return 'Line removed.';
    }

    /** How many lines the statement has, for the pager. */
    public function count(int $customerId): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM statement_lines WHERE customer_id = {$customerId}")
            ->fetchColumn();
    }
}
