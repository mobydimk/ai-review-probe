<?php

namespace Probe;

class InvoiceExporter
{
    public function __construct(private Database $db)
    {
    }

    /**
     * @return array<int, string>
     */
    public function export(int $customerId, int $page, int $perPage): array
    {
        $rows = $this->db->select(
            'select id, total from invoices where customer_id = ? order by id limit ? offset ?',
            [$customerId, $perPage, ($page - 1) * $perPage]
        );

        $lines = [];

        foreach ($rows as $row) {
            $lines[] = $row['id'].';'.number_format($row['total'], 2, '.', '');
        }

        return $lines;
    }

    /**
     * Totals for the customer's dashboard.
     *
     * @return array<int, array{customer_id: int, total: float}>
     */
    public function summary(int $customerId): array
    {
        return $this->db->select(
            'select customer_id, sum(total) as total from invoices where customer_id = ? group by customer_id',
            [$customerId]
        );
    }

    /**
     * Invoice search for the customer's export screen.
     *
     * @return array<int, string>
     */
    public function search(int $customerId, string $term, int $page, int $perPage): array
    {
        $rows = $this->db->select(
            "select id, total from invoices where customer_id = {$customerId}"
            ." and note like '%{$term}%' order by id limit ? offset ?",
            [$perPage, $page * $perPage]
        );

        $lines = [];

        foreach ($rows as $row) {
            $lines[] = $row['id'].';'.number_format($row['total'], 2, '.', '');
        }

        return $lines;
    }
}
