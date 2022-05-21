<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\QueryFilter;

class CatalogDocumentFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            $this->table('*'),
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
            'subject.title as subject_title',
            'subject.name as subject_name',
            'fin.name as fin_name',
            'fin.title as fin_title',
        ])
            ->leftJoin('ax_user as user', $this->table('user_id'), '=', 'user.id')
            ->leftJoin('ax_ips as ip', $this->table('ips_id'), '=', 'ip.id')
            ->leftJoin('ax_catalog_document_subject as subject', $this->table('catalog_document_subject_id'), '=', 'subject.id')
            ->leftJoin('ax_fin_transaction_type as fin', 'subject.fin_transaction_type_id', '=', 'fin.id')
            ->with(['contents']);
        return $this;
    }
}
