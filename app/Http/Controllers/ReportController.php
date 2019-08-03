<?php
namespace App\Http\Controllers;

define('STDIN',fopen("php://stdin","r"));

use DateTime;
use DateTimeZone;

use App\Models\User;
use App\Models\Article;
use App\Models\Type;
use App\Models\Report;
use App\Http\Requests\ReportCreateRequest;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;

class ReportController extends Controller
{
	public function showAll()
    {
        return Report::with('user', 'article', 'type')->get();
    }

    public function create(ReportCreateRequest $request)
    {
        $user = User::create($request->all());
        $article = Article::create($request->all());
        $type = Type::create($request->all());

        $report = new Report($request->all());
        $report->user()->associate($user);
        $report->article()->associate($article);
        $report->type()->associate($type);
        $report->save();        

        // connecting to google sheets
        $client = $this->getGoogleClient();
        $sheets = new \Google_Service_Sheets($client);
        $spreadsheetId = config('app.spreadSheetId');

        if (date('j') == '1') {
            $this->createSheet($sheets, $spreadsheetId, $this->getTimeStr('Y/m'));
        }

        // Create the value range Object
        $valueRange = new Google_Service_Sheets_ValueRange();
	$valueRange->setValues(["values" => [
            $request->input('fingerprint'),
            '=HYPERLINK("'.($request->input('url')).'";"'.urldecode($request->input('url')).'")',
            $request->input('highlighted'),
            $request->input('description'),
            $request->input('type'),
            $this->getTimeStr('Y/m/d H:i:s')
        ]]);

        $range = date('Y/m')."!A:F";
        $conf = ["valueInputOption" => "USER_ENTERED"];

        $sheets->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);

        return response('', 201);
    }

    public function getGoogleClient() 
    {
        $client = new \Google_Client();
        $client->setApplicationName('wiki-awareness');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('/var/www/service/g0v-wiki-awareness-e81bff7c6201.json');

        return $client;
    }

    public function createSheet(Google_Service_Sheets $sheets, $spreadsheetId, $title) 
    {
        $sheetsInfo = $sheets->spreadsheets->get($spreadsheetId)['sheets'];
        $sheetsTitles = array_column(array_column($sheetsInfo, 'properties'), 'title');
        $hasAlreadyCreated = false;
        foreach ($sheetsTitles as $key => $value) {
            if ($value == $title) {
                $hasAlreadyCreated = true;
            }
        }

        if (!$hasAlreadyCreated) {
            $body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
            'requests' => array('addSheet' => array('properties' => array('title' => $title )))));
            $result = $sheets->spreadsheets->batchUpdate($spreadsheetId,$body);
        }
    }

    public function getTimeStr($format) {
        $tz = 'Asia/Taipei';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        return $dt->format($format);
    }
}
