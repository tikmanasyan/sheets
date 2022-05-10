<?php


namespace App\Services;


use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleSheet {
    private $spread_sheet_id;
    private $client;
    private $google_sheet_service;

    public function __construct()
    {
        $this->spread_sheet_id = config('google.google_sheet_id');

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->addScope("https://www.googleapis.com/auth/spreadsheets");

        $this->google_sheet_service = new Google_Service_Sheets($this->client);
    }

    public function readGoogleSheet()
    {
        $dimensions = $this->getDimensions($this->spread_sheet_id);
        $range = 'Sheet1!A1:' . $dimensions['colCount'];

        $data = $this->google_sheet_service
            ->spreadsheets_values
            ->batchGet($this->spread_sheet_id, ['ranges' => $range]);

        return $data->getValueRanges()[0]->values;
    }

    public function readGoogleSheetByCall($id)
    {
        $dimensions = $this->getDimensions($this->spread_sheet_id);
        $range = "Sheet1!A{$id}:" . $dimensions['colCount'];
        return $range;
        $data = $this->google_sheet_service
            ->spreadsheets_values
            ->batchGet($this->spread_sheet_id, ['ranges' => $range]);

        return $data->getValueRanges()[0]->values;
    }

    public function saveDataToSheet(array $data)
    {
        $dimensions = $this->getDimensions($this->spread_sheet_id);

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range = "A" . ($dimensions['rowCount'] + 1);

        return $this->google_sheet_service
            ->spreadsheets_values
            ->update($this->spread_sheet_id, $range, $body, $params);
    }

    public function updateDataToSheet(array $data, int $id)
    {
        $dimensions = $this->getDimensions($this->spread_sheet_id);

       /* $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range = "A{$id}";*/

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range = "A" . ($id + 1);

        return $this->google_sheet_service
            ->spreadsheets_values
            ->update($this->spread_sheet_id, $range, $body, $params);
    }

    private function getDimensions($spreadSheetId)
    {
        $rowDimensions = $this->google_sheet_service->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => 'Sheet1!A:A', 'majorDimension' => 'COLUMNS']
        );

        //if data is present at nth row, it will return array till nth row
        //if all column values are empty, it returns null
        $rowMeta = $rowDimensions->getValueRanges()[0]->values;
        if (!$rowMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        $colDimensions = $this->google_sheet_service->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => 'Sheet1!1:1', 'majorDimension' => 'ROWS']
        );

        //if data is present at nth col, it will return array till nth col
        //if all column values are empty, it returns null
        $colMeta = $colDimensions->getValueRanges()[0]->values;
        if (!$colMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        return [
            'error' => false,
            'rowCount' => count($rowMeta[0]),
            'colCount' => $this->colLengthToColumnAddress(count($colMeta[0]))
        ];
    }

    private function colLengthToColumnAddress($number)
    {
        if ($number <= 0) return null;

        $letter = '';
        while ($number > 0) {
            $temp = ($number - 1) % 26;
            $letter = chr($temp + 65) . $letter;
            $number = ($number - $temp - 1) / 26;
        }
        return $letter;
    }

}
