<?php

namespace App\Common\Components;

use App\Common\Models\Catalog\Document\CatalogDocument;
use Dompdf\Dompdf;

class DocumentPrint
{
    private CatalogDocument $model;
    private Dompdf $dompdf;

    public function __construct(CatalogDocument $model)
    {
        $this->model = $model;
        $this->dompdf = new Dompdf();
    }

    public function credit(): void
    {
        $date = date('d.m.Y', $this->model->updated_at);
        $sum = _price($this->model->sum_in, 2, '.', ',');
        $sumString = _string_price($this->model->sum_in);
        $producer = $this->model->producer_name_full . '(' . $this->model->producer_name . ')';
        $customer = config('app.company_name');
        $documentContents = '';
        $i = 1;
        if ($catalogDocumentContents = $this->model->catalogDocumentContents) {
            foreach ($catalogDocumentContents as $documentContent) {
                $documentContents .= '
                <tr class=R10>
                    <td><span></span></td>
                    <td class="R10C1" colspan=2><span style="white-space:nowrap;max-width:0px;">' . $i . '</span></td>
                    <td class="R10C3" colspan=3>' . $documentContent->oem . '</td>
                    <td class="R10C3" colspan=15>' . $documentContent->title . '</td>
                    <td class="R10C21" colspan=5><span style="white-space:nowrap;max-width:0px;">1</span></td>
                    <td class="R10C21" colspan=3><span style="white-space:nowrap;max-width:0px;">' . number_format($documentContent->price_in, 2, '.', ',') . '</span></td>
                    <td class="R10C29" colspan=4><span style="white-space:nowrap;max-width:0px;">' . number_format($documentContent->price_in, 2, '.', ',') . '</span></td>
                    <td><span></span></td>
                    <td></td>
                </tr>
            ';
                $i++;
            }
        }
        $i--;
        $document = <<<PRINT
            <style TYPE="text/css">
        body {
            background: #ffffff;
            margin: 0;
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
        }

        tr.R0 {
            height: 15px;
        }

        tr.R0 td.R14C1 {
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
            text-align: left;
        }

        tr.R0 td.R8C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 2px solid;
            border-top: #000000 2px solid;
        }

        tr.R0 td.R8C22 {
            text-align: left;
        }

        tr.R0 td.R8C29 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 1px solid;
            border-top: #000000 2px solid;
            border-right: #000000 2px solid;
        }

        tr.R0 td.R8C3 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 1px solid;
            border-top: #000000 2px solid;
        }

        tr.R1 {
            height: 1px;
        }

        tr.R10 {
            height: 29px;
        }

        tr.R10 td.R10C1 {
            text-align: center;
            vertical-align: top;
            border-left: #000000 2px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C21 {
            text-align: right;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C22 {
            text-align: left;
        }

        tr.R10 td.R10C24 {
            text-align: left;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C29 {
            text-align: right;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
            border-right: #000000 2px solid;
        }

        tr.R10 td.R10C3 {
            text-align: left;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R2 {
            height: 28px;
        }

        tr.R2 td.R2C1 {
            font-family: DejaVu Sans;
            font-size: 14pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
            border-bottom: #000000 2px solid;
        }

        tr.R4 {
            height: 17px;
        }

        tr.R4 td.R12C28 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: right;
            vertical-align: top;
        }

        tr.R4 td.R18C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
        }

        tr.R4 td.R18C4 {
            text-align: left;
            border-bottom: #ffffff 1px none;
        }

        tr.R4 td.R18C5 {
            text-align: left;
            border-bottom: #000000 1px solid;
        }

        tr.R4 td.R18C9 {
            text-align: right;
            border-bottom: #000000 1px solid;
        }

        tr.R4 td.R4C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            text-align: left;
            vertical-align: middle;
        }

        tr.R4 td.R4C6 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
            vertical-align: top;
        }

        tr.R5 {
            height: 9px;
        }

        tr.R5 td.R11C1 {
            text-align: left;
            border-top: #000000 2px solid;
        }

        tr.R5 td.R16C1 {
            text-align: left;
            border-bottom: #000000 2px solid;
        }

        table {
            table-layout: fixed;
            padding: 0;
            padding-left: 2px;
            vertical-align: bottom;
            border-collapse: collapse;
            width: 100%;
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
        }

        td {
            padding: 0;
            padding-left: 2px;
            overflow: hidden;
            vertical-align: bottom;
        }
    </style>
    <table CELLSPACING=0 style="width:100%; height:0px; ">
        <col width=21>
        <col width=14>
        <col width=10>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=14>
        <col width=14>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=14>
        <col width=14>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        <tr class=R1>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:1px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R2>
            <td>
                <div style="position:relative; height:28px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R2C1" colspan=32><span style="white-space:nowrap;max-width:0px;">Приходная накладная&nbsp;№&nbsp;{$this->model->id}&nbsp;от&nbsp;{$date}</span>
            </td>
            <td>
                <div style="position:relative; height:28px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:28px;overflow:hidden;"></div>
            </td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        <tr class=R4>
            <td><span></span></td>
            <td class="R4C1" colspan=5><span style="white-space:nowrap;max-width:0px;">Поставщик:</span></td>
            <td class="R4C6" colspan=27>$producer</td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R4>
            <td><span></span></td>
            <td class="R4C1" colspan=5><span style="white-space:nowrap;max-width:0px;">Покупатель:</span></td>
            <td class="R4C6" colspan=27>$customer</td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td class="R8C1" colspan=2 rowspan=2><span style="white-space:nowrap;max-width:0px;">№</span></td>
            <td class="R8C3" colspan=3 rowspan=2><span style="white-space:nowrap;max-width:0px;">Код</span></td>
            <td class="R8C3" colspan=15 rowspan=2><span style="white-space:nowrap;max-width:0px;">Товар</span></td>
            <td class="R8C3" colspan=5 rowspan=2><span style="white-space:nowrap;max-width:0px;">Количество</span></td>
            <td class="R8C3" colspan=3 rowspan=2><span style="white-space:nowrap;max-width:0px;">Цена</span></td>
            <td class="R8C29" colspan=4 rowspan=2><span style="white-space:nowrap;max-width:0px;">Сумма</span></td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        $documentContents
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R4>
            <td class="R12C28" colspan=29><span style="white-space:nowrap;max-width:0px;">Итого:</span></td>
            <td class="R12C28" colspan=4><span style="white-space:nowrap;max-width:0px;">$sum</span></td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
        </td>
    </tr>
    <tr class=R0>
        <td><span></span></td>
        <td class="R14C1" colspan=32><span style="white-space:nowrap;max-width:0px;">Всего&nbsp;наименований&nbsp;$i,&nbsp;на&nbsp;сумму&nbsp;$sum&nbsp;RUB</span>
        </td>
        <td><span></span></td>
        <td></td>
    </tr>
    <tr class=R4>
        <td><span></span></td>
        <td class="R4C6" colspan=32>$sumString</td>
        <td><span></span></td>
        <td></td>
    </tr>
    <tr class=R5>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
        </td>
    </tr>
    <tr class=R0>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr class=R4>
        <td><span></span></td>
        <td class="R18C1" colspan=3><span style="white-space:nowrap;max-width:0px;">Отпустил</span></td>
        <td class="R18C4"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C9" colspan=7><span></span></td>
        <td><span></span></td>
        <td class="R18C1" colspan=3><span style="white-space:nowrap;max-width:0px;">Получил</span></td>
        <td class="R18C4"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C9" colspan=9><span></span></td>
        <td><span></span></td>
        <td></td>
    </tr>
</table>
PRINT;
        $this->dompdf->loadHtml($document);
        $this->dompdf->render();
        $this->dompdf->stream('document', ["Attachment" => 0]);
    }

    public function debit(): void
    {
        $date = date('d.m.Y', $this->model->updated_at);
        $sum = number_format($this->model->sum_out, 2, '.', ',');
        $sumString = Helper::stringPrice($this->model->sum_out);
        $producer = config('app.company_name');
        $customer = $this->model->customer_name_short;
        $documentContents = '';
        $i = 1;
        if ($catalogDocumentContents = $this->model->catalogDocumentContents) {
            foreach ($catalogDocumentContents as $documentContent) {
                $documentContents .= '
                <tr class=R10>
                    <td><span></span></td>
                    <td class="R10C1" colspan=2><span style="white-space:nowrap;max-width:0px;">' . $i . '</span></td>
                    <td class="R10C3" colspan=3>' . $documentContent->oem . '</td>
                    <td class="R10C3" colspan=15>' . $documentContent->title . '</td>
                    <td class="R10C21" colspan=5><span style="white-space:nowrap;max-width:0px;">1</span></td>
                    <td class="R10C21" colspan=3><span style="white-space:nowrap;max-width:0px;">' . number_format($documentContent->price_out, 2, '.', ',') . '</span></td>
                    <td class="R10C29" colspan=4><span style="white-space:nowrap;max-width:0px;">' . number_format($documentContent->price_out, 2, '.', ',') . '</span></td>
                    <td><span></span></td>
                    <td></td>
                </tr>
            ';
                $i++;
            }
        }
        $i--;
        $document = <<<PRINT
            <style TYPE="text/css">
        body {
            background: #ffffff;
            margin: 0;
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
        }

        tr.R0 {
            height: 15px;
        }

        tr.R0 td.R14C1 {
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
            text-align: left;
        }

        tr.R0 td.R8C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 2px solid;
            border-top: #000000 2px solid;
        }

        tr.R0 td.R8C22 {
            text-align: left;
        }

        tr.R0 td.R8C29 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 1px solid;
            border-top: #000000 2px solid;
            border-right: #000000 2px solid;
        }

        tr.R0 td.R8C3 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border-left: #000000 1px solid;
            border-top: #000000 2px solid;
        }

        tr.R1 {
            height: 1px;
        }

        tr.R10 {
            height: 29px;
        }

        tr.R10 td.R10C1 {
            text-align: center;
            vertical-align: top;
            border-left: #000000 2px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C21 {
            text-align: right;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C22 {
            text-align: left;
        }

        tr.R10 td.R10C24 {
            text-align: left;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R10 td.R10C29 {
            text-align: right;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
            border-right: #000000 2px solid;
        }

        tr.R10 td.R10C3 {
            text-align: left;
            vertical-align: top;
            border-left: #000000 1px solid;
            border-top: #000000 1px solid;
        }

        tr.R2 {
            height: 28px;
        }

        tr.R2 td.R2C1 {
            font-family: DejaVu Sans;
            font-size: 14pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
            border-bottom: #000000 2px solid;
        }

        tr.R4 {
            height: 17px;
        }

        tr.R4 td.R12C28 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: right;
            vertical-align: top;
        }

        tr.R4 td.R18C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
        }

        tr.R4 td.R18C4 {
            text-align: left;
            border-bottom: #ffffff 1px none;
        }

        tr.R4 td.R18C5 {
            text-align: left;
            border-bottom: #000000 1px solid;
        }

        tr.R4 td.R18C9 {
            text-align: right;
            border-bottom: #000000 1px solid;
        }

        tr.R4 td.R4C1 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            text-align: left;
            vertical-align: middle;
        }

        tr.R4 td.R4C6 {
            font-family: DejaVu Sans;
            font-size: 9pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
            vertical-align: top;
        }

        tr.R5 {
            height: 9px;
        }

        tr.R5 td.R11C1 {
            text-align: left;
            border-top: #000000 2px solid;
        }

        tr.R5 td.R16C1 {
            text-align: left;
            border-bottom: #000000 2px solid;
        }

        table {
            table-layout: fixed;
            padding: 0;
            padding-left: 2px;
            vertical-align: bottom;
            border-collapse: collapse;
            width: 100%;
            font-family: DejaVu Sans;
            font-size: 8pt;
            font-style: normal;
        }

        td {
            padding: 0;
            padding-left: 2px;
            overflow: hidden;
            vertical-align: bottom;
        }
    </style>
    <table CELLSPACING=0 style="width:100%; height:0px; ">
        <col width=21>
        <col width=14>
        <col width=10>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=14>
        <col width=14>
        <col width=21>
        <col width=21>
        <col width=21>
        <col width=14>
        <col width=14>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col width=28>
        <col>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        <tr class=R1>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:1px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:1px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R2>
            <td>
                <div style="position:relative; height:28px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R2C1" colspan=32><span style="white-space:nowrap;max-width:0px;">Расходная накладная&nbsp;№&nbsp;{$this->model->id}&nbsp;от&nbsp;{$date}</span>
            </td>
            <td>
                <div style="position:relative; height:28px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:28px;overflow:hidden;"></div>
            </td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        <tr class=R4>
            <td><span></span></td>
            <td class="R4C1" colspan=5><span style="white-space:nowrap;max-width:0px;">Поставщик:</span></td>
            <td class="R4C6" colspan=27>$producer</td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R4>
            <td><span></span></td>
            <td class="R4C1" colspan=5><span style="white-space:nowrap;max-width:0px;">Покупатель:</span></td>
            <td class="R4C6" colspan=27>$customer</td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td class="R8C1" colspan=2 rowspan=2><span style="white-space:nowrap;max-width:0px;">№</span></td>
            <td class="R8C3" colspan=3 rowspan=2><span style="white-space:nowrap;max-width:0px;">Код</span></td>
            <td class="R8C3" colspan=15 rowspan=2><span style="white-space:nowrap;max-width:0px;">Товар</span></td>
            <td class="R8C3" colspan=5 rowspan=2><span style="white-space:nowrap;max-width:0px;">Количество</span></td>
            <td class="R8C3" colspan=3 rowspan=2><span style="white-space:nowrap;max-width:0px;">Цена</span></td>
            <td class="R8C29" colspan=4 rowspan=2><span style="white-space:nowrap;max-width:0px;">Сумма</span></td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R0>
            <td><span></span></td>
            <td><span></span></td>
            <td>&nbsp;</td>
        </tr>
        $documentContents
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td class="R11C1">
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
            </td>
        </tr>
        <tr class=R4>
            <td class="R12C28" colspan=29><span style="white-space:nowrap;max-width:0px;">Итого:</span></td>
            <td class="R12C28" colspan=4><span style="white-space:nowrap;max-width:0px;">$sum</span></td>
            <td><span></span></td>
            <td></td>
        </tr>
        <tr class=R5>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
                <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
            </td>
            <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
        </td>
    </tr>
    <tr class=R0>
        <td><span></span></td>
        <td class="R14C1" colspan=32><span style="white-space:nowrap;max-width:0px;">Всего&nbsp;наименований&nbsp;$i,&nbsp;на&nbsp;сумму&nbsp;$sum&nbsp;RUB</span>
        </td>
        <td><span></span></td>
        <td></td>
    </tr>
    <tr class=R4>
        <td><span></span></td>
        <td class="R4C6" colspan=32>$sumString</td>
        <td><span></span></td>
        <td></td>
    </tr>
    <tr class=R5>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td class="R16C1">
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="position:relative; height:9px;width: 100%; overflow:hidden;"><span></span></div>
        </td>
        <td>
            <div style="width:100%;height:9px;overflow:hidden;">&nbsp;</div>
        </td>
    </tr>
    <tr class=R0>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td><span></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr class=R4>
        <td><span></span></td>
        <td class="R18C1" colspan=3><span style="white-space:nowrap;max-width:0px;">Отпустил</span></td>
        <td class="R18C4"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C9" colspan=7><span></span></td>
        <td><span></span></td>
        <td class="R18C1" colspan=3><span style="white-space:nowrap;max-width:0px;">Получил</span></td>
        <td class="R18C4"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C5"><span></span></td>
        <td class="R18C9" colspan=9><span></span></td>
        <td><span></span></td>
        <td></td>
    </tr>
</table>
PRINT;
        $this->dompdf->loadHtml($document);
        $this->dompdf->render();
        $this->dompdf->stream('document', ["Attachment" => 0]);
    }
}
